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

    public function store(Request $request, CartManager $cart, ProductCatalog $catalog): RedirectResponse
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

        $cookie = $cart->add($product, (int) ($validated['quantity'] ?? 1), [
            'sku' => $validated['sku'] ?? null,
            'storage' => $validated['storage'] ?? null,
            'color' => $validated['color'] ?? null,
            'price' => $validated['price'] ?? null,
            'old_price' => $validated['old_price'] ?? null,
            'discount' => $validated['discount'] ?? null,
            'price_value' => $validated['price_value'] ?? null,
        ]);

        $redirect = ($validated['redirect_to'] ?? '') === 'cart'
            ? redirect()->route('cart.index')
            : back();

        return $redirect
            ->withCookie($cookie)
            ->with('cart_success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, CartManager $cart, string $lineId): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $cookie = $cart->update($lineId, (int) $validated['quantity']);

        return back()
            ->withCookie($cookie)
            ->with('cart_success', 'Đã cập nhật giỏ hàng.');
    }

    public function destroy(CartManager $cart, string $lineId): RedirectResponse
    {
        $cookie = $cart->remove($lineId);

        return back()
            ->withCookie($cookie)
            ->with('cart_success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
