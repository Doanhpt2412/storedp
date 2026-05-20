<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Support\CartManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index(CartManager $cart)
    {
        if ($cart->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        return view('frontend.checkout.index', [
            'cartItems' => $cart->items(),
            'cartSubtotal' => $cart->subtotal(),
            'cartCount' => $cart->count(),
            // Common shared data can be injected if needed, like navCategories
            'navCategories' => \App\Models\ProductCategory::whereNull('parent_id')->with('children')->get(),
        ]);
    }

    public function store(Request $request, CartManager $cart)
    {
        if ($cart->count() === 0) {
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

        try {
            DB::beginTransaction();

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'delivery_method' => $validated['delivery_method'],
                'customer_address' => $validated['customer_address'],
                'customer_note' => $validated['customer_note'],
                'subtotal' => $cart->subtotal(),
                'total' => $cart->subtotal(), // No shipping fee or discount for now
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

            DB::commit();

            // Clear cart completely
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

    public function success(string $orderCode)
    {
        $order = Order::with('items')->where('order_code', $orderCode)->firstOrFail();

        return view('frontend.checkout.success', [
            'order' => $order,
            'navCategories' => \App\Models\ProductCategory::whereNull('parent_id')->with('children')->get(),
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $orders = null;

        if ($query) {
            $orders = Order::with('items')
                ->where('order_code', 'like', "%{$query}%")
                ->orWhere('customer_phone', 'like', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('frontend.checkout.search', [
            'query' => $query,
            'orders' => $orders,
            'navCategories' => \App\Models\ProductCategory::whereNull('parent_id')->with('children')->get(),
        ]);
    }
}
