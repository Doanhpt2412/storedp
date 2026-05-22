<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\CartManager;
use App\Support\ProductCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartController extends Controller
{
    public function index(CartManager $cart, ProductCatalog $catalog): View
    {
        return view('frontend.cart.index', [
            'cartItems' => $cart->items(),
            'cartCount' => $cart->count(),
            'cartSubtotal' => $cart->subtotal(),
            'navCategories' => $catalog->navCategories(),
        ]);
    }

    public function store(Request $request, CartManager $cart, ProductCatalog $catalog): \Symfony\Component\HttpFoundation\Response
    {
        $validated = $request->validate([
            'slug' => ['required', 'string'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
            'sku' => ['nullable', 'string'],
            'storage' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'price' => ['nullable', 'string'],
            'old_price' => ['nullable', 'string'],
            'discount' => ['nullable', 'string'],
            'price_value' => ['nullable', 'integer', 'min:0'],
            'redirect_to' => ['nullable', 'string'],
        ]);

        $product = $catalog->find($validated['slug']);

        if (! $product) {
            throw new NotFoundHttpException();
        }

        $selectedVariant = null;
        if (!empty($product['variant_matrix'])) {
            $selectedVariant = collect($product['variant_matrix'])->first(function ($v) use ($validated) {
                return $v['sku'] === ($validated['sku'] ?? null) || ($v['storage'] === ($validated['storage'] ?? null) && $v['color'] === ($validated['color'] ?? null));
            });
        }

        $isOutOfStock = false;
        if ($selectedVariant && $selectedVariant['stock'] <= 0) {
            $isOutOfStock = true;
        } elseif (!$selectedVariant && isset($product['stock']) && $product['stock'] <= 0) {
            $isOutOfStock = true;
        }

        if ($isOutOfStock) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm này đã hết hàng.',
                ]);
            }
            return back()->with('error', 'Sản phẩm này đã hết hàng.');
        }

        $cookie = $cart->add($product, (int) ($validated['quantity'] ?? 1), [
            'sku' => $validated['sku'] ?? null,
            'storage' => $validated['storage'] ?? null,
            'color' => $validated['color'] ?? null,
            'price' => $validated['price'] ?? null,
            'old_price' => $validated['old_price'] ?? null,
            'discount' => $validated['discount'] ?? null,
            'price_value' => $validated['price_value'] ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
                'cart_count' => $cart->count(),
                'cart_subtotal' => $cart->formatPrice($cart->subtotal()),
                'product' => [
                    'name' => $product['name'],
                    'image' => $product['image'] ?? '',
                    'price' => $validated['price'] ?? $product['price'] ?? '',
                    'storage' => $validated['storage'] ?? '',
                    'color' => $validated['color'] ?? '',
                    'quantity' => (int) ($validated['quantity'] ?? 1),
                ]
            ])->withCookie($cookie);
        }

        $redirect = ($validated['redirect_to'] ?? '') === 'cart'
            ? redirect()->route('cart.index')
            : back();

        return $redirect
            ->withCookie($cookie)
            ->with('cart_success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, CartManager $cart, string $lineId): \Symfony\Component\HttpFoundation\Response
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $cookie = $cart->update($lineId, (int) $validated['quantity']);

        if ($request->wantsJson() || $request->ajax()) {
            // Find the updated item to calculate its subtotal
            $items = $cart->items();
            $updatedItem = null;
            foreach ($items as $item) {
                if (($item['line_id'] ?? null) === $lineId) {
                    $updatedItem = $item;
                    break;
                }
            }

            $itemSubtotal = $updatedItem ? ($updatedItem['price_value'] * $updatedItem['quantity']) : 0;

            return response()->json([
                'success' => true,
                'message' => $validated['quantity'] <= 0 ? 'Đã xóa sản phẩm khỏi giỏ hàng.' : 'Đã cập nhật số lượng sản phẩm.',
                'cart_count' => $cart->count(),
                'cart_subtotal' => $cart->subtotal(),
                'formatted_cart_subtotal' => number_format($cart->subtotal(), 0, ',', '.') . 'đ',
                'item_quantity' => (int) $validated['quantity'],
                'item_subtotal' => $itemSubtotal,
                'formatted_item_subtotal' => number_format($itemSubtotal, 0, ',', '.') . 'đ'
            ])->withCookie($cookie);
        }

        return back()
            ->withCookie($cookie)
            ->with('cart_success', 'Đã cập nhật giỏ hàng.');
    }

    public function destroy(Request $request, CartManager $cart, string $lineId): \Symfony\Component\HttpFoundation\Response
    {
        $cookie = $cart->remove($lineId);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'cart_count' => $cart->count(),
                'cart_subtotal' => $cart->subtotal(),
                'formatted_cart_subtotal' => number_format($cart->subtotal(), 0, ',', '.') . 'đ',
            ])->withCookie($cookie);
        }

        return back()
            ->withCookie($cookie)
            ->with('cart_success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
