<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductCategory;
use App\Support\CartManager;
use App\Support\PromotionCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(CartManager $cart, PromotionCodeService $promotionCodeService): RedirectResponse|View
    {
        if ($cart->count() === 0) {
            $promotionCodeService->clear();

            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $cartSubtotal = $cart->subtotal();
        $appliedPromotion = $promotionCodeService->current($cartSubtotal);

        return view('frontend.checkout.index', [
            'cartItems' => $cart->items(),
            'cartSubtotal' => $cartSubtotal,
            'cartCount' => $cart->count(),
            'appliedPromotion' => $appliedPromotion,
            'discountAmount' => $appliedPromotion['discount_amount'] ?? 0,
            'checkoutTotal' => $appliedPromotion['total'] ?? $cartSubtotal,
            'navCategories' => ProductCategory::whereNull('parent_id')->with('children')->get(),
        ]);
    }

    public function applyPromotion(Request $request, CartManager $cart, PromotionCodeService $promotionCodeService): RedirectResponse
    {
        if ($cart->count() === 0) {
            $promotionCodeService->clear();

            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $validated = $request->validate([
            'promotion_code' => ['required', 'string', 'max:50'],
        ], [
            'promotion_code.required' => 'Vui lòng nhập mã khuyến mãi.',
        ]);

        $result = $promotionCodeService->validateForApply($validated['promotion_code'], $cart->subtotal());

        if ($result['message'] !== null) {
            return back()
                ->withInput($request->except(['_token']))
                ->with('promotion_error', $result['message']);
        }

        $promotionCodeService->apply($result['promotion']->code);

        return back()
            ->withInput($request->except(['_token']))
            ->with('promotion_success', 'Áp dụng mã khuyến mãi thành công.');
    }

    public function removePromotion(Request $request, PromotionCodeService $promotionCodeService): RedirectResponse
    {
        $promotionCodeService->clear();

        return back()
            ->withInput($request->except(['_token', '_method']))
            ->with('promotion_success', 'Đã gỡ mã khuyến mãi.');
    }

    public function store(Request $request, CartManager $cart, PromotionCodeService $promotionCodeService): RedirectResponse
    {
        if ($cart->count() === 0) {
            $promotionCodeService->clear();

            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'delivery_method' => ['required', 'in:home_delivery,store_pickup'],
            'customer_address' => ['required_if:delivery_method,home_delivery', 'nullable', 'string', 'max:1000'],
            'customer_note' => ['nullable', 'string', 'max:2000'],
        ], [
            'customer_name.required' => 'Vui lòng nhập họ và tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'delivery_method.required' => 'Vui lòng chọn hình thức nhận hàng.',
            'customer_address.required_if' => 'Vui lòng nhập địa chỉ giao hàng.',
        ]);

        $cartSubtotal = $cart->subtotal();
        $appliedPromotion = $promotionCodeService->current($cartSubtotal);
        $discountAmount = $appliedPromotion['discount_amount'] ?? 0;
        $checkoutTotal = $appliedPromotion['total'] ?? $cartSubtotal;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'delivery_method' => $validated['delivery_method'],
                'customer_address' => $validated['customer_address'],
                'customer_note' => $validated['customer_note'],
                'promotion_code' => $appliedPromotion['code'] ?? null,
                'promotion_name' => $appliedPromotion['name'] ?? null,
                'discount_percentage' => $appliedPromotion['discount_percentage'] ?? 0,
                'discount_amount' => $discountAmount,
                'subtotal' => $cartSubtotal,
                'total' => $checkoutTotal,
            ]);

            foreach ($cart->items() as $item) {
                $variantInfo = collect([
                    $item['storage'] ? "Dung lượng: {$item['storage']}" : null,
                    $item['color'] ? "Màu: {$item['color']}" : null,
                ])->filter()->implode(' | ');

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'] ?? null,
                    'product_name' => $item['name'],
                    'product_image' => $item['image'],
                    'sku' => $item['sku'],
                    'variant_info' => $variantInfo ?: null,
                    'price' => $item['price_value'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price_value'] * $item['quantity'],
                ]);
            }

            if (! empty($appliedPromotion['promotion'])) {
                $appliedPromotion['promotion']->increment('usage_count');
            }

            DB::commit();

            $promotionCodeService->clear();
            $cookie = $cart->clear();

            return redirect()->route('checkout.success', $order->order_code)
                ->withCookie($cookie)
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau.');
        }
    }

    public function success(string $orderCode): View
    {
        $order = Order::with('items')->where('order_code', $orderCode)->firstOrFail();

        return view('frontend.checkout.success', [
            'order' => $order,
            'navCategories' => ProductCategory::whereNull('parent_id')->with('children')->get(),
        ]);
    }

    public function search(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));
        $orders = null;

        if ($query !== '') {
            $orders = Order::with('items')
                ->where(function ($builder) use ($query) {
                    $builder
                        ->where('order_code', $query)
                        ->orWhere('customer_phone', $query);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('frontend.checkout.search', [
            'query' => $query,
            'orders' => $orders,
            'navCategories' => ProductCategory::whereNull('parent_id')->with('children')->get(),
        ]);
    }
}
