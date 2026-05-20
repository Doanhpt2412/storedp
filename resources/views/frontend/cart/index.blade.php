<x-layouts.app :title="'Giỏ hàng của bạn | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <section class="space-y-6">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-orange-500 font-semibold">Giỏ hàng</p>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Giỏ hàng của bạn</h1>
            <p class="text-sm text-gray-500 mt-2"><span id="cart-total-count" class="font-bold text-orange-500">{{ $cartCount }}</span> sản phẩm trong giỏ</p>
        </div>

        <!-- Trạng thái giỏ hàng trống (Dự phòng động) -->
        <div id="cart-empty-state" class="rounded-2xl border border-dashed border-gray-300 bg-white p-12 text-center shadow-sm {{ $cartItems === [] ? '' : 'hidden' }}">
            <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Giỏ hàng của bạn đang trống</h2>
            <p class="text-sm text-gray-500 mt-2">Hãy thêm các sản phẩm công nghệ chất lượng từ cửa hàng để bắt đầu mua sắm.</p>
            <a href="{{ route('home') }}" class="inline-flex mt-6 rounded-xl bg-gradient-to-r from-orange-500 to-red-600 px-6 py-3.5 text-sm font-bold text-white hover:opacity-95 transition-all shadow-lg shadow-orange-500/20 active:scale-95">
                Tiếp tục mua sắm
            </a>
        </div>

        <!-- Trạng thái giỏ hàng có sản phẩm -->
        <div id="cart-content-wrapper" class="{{ $cartItems === [] ? 'hidden' : '' }} grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px] items-start">
            <div class="space-y-4">
                @foreach ($cartItems as $item)
                    <article data-cart-item="{{ $item['line_id'] }}" class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex flex-col gap-4 md:flex-row">
                            <div class="w-full md:w-32 h-32 shrink-0 overflow-hidden rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center p-2">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                            </div>

                            <div class="flex-1 flex flex-col justify-between">
                                <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('products.show', $item['slug']) }}" class="text-lg font-bold text-gray-900 hover:text-orange-600 transition-colors line-clamp-2">
                                            {{ $item['name'] }}
                                        </a>
                                        <div class="mt-2 flex flex-wrap gap-2 text-[10px]">
                                            <span class="rounded-full bg-slate-100 px-2.5 py-1 font-bold text-slate-600 border border-slate-200">{{ $item['brand'] }}</span>
                                            @if ($item['storage'])
                                                <span class="rounded-full bg-orange-50 px-2.5 py-1 font-bold text-orange-600 border border-orange-100">Dung lượng: {{ $item['storage'] }}</span>
                                            @endif
                                            @if ($item['color'])
                                                <span class="rounded-full bg-blue-50 px-2.5 py-1 font-bold text-blue-600 border border-blue-100">Màu: {{ $item['color'] }}</span>
                                            @endif
                                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-gray-500 border border-gray-200">SKU: {{ $item['sku'] }}</span>
                                        </div>
                                    </div>

                                    <div class="text-left md:text-right mt-2 md:mt-0 flex-shrink-0">
                                        <div class="text-lg font-extrabold text-red-600">{{ $item['price'] }}</div>
                                        @if ($item['old_price'])
                                            <div class="text-xs text-gray-400 line-through mt-0.5">{{ $item['old_price'] }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <!-- Premium Quantity Picker Component -->
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-semibold text-gray-500">Số lượng:</span>
                                        <div class="quantity-picker flex items-center border border-gray-200 rounded-xl bg-gray-50 p-0.5">
                                            <button type="button" data-qty-btn="minus" data-line-id="{{ $item['line_id'] }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-200 hover:text-gray-900 active:scale-90 transition-all font-bold" aria-label="Giảm số lượng">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                            </button>
                                            <input type="number" readonly min="1" max="99" data-qty-input="{{ $item['line_id'] }}" value="{{ $item['quantity'] }}" class="w-10 text-center bg-transparent border-0 outline-none text-sm font-extrabold text-gray-800">
                                            <button type="button" data-qty-btn="plus" data-line-id="{{ $item['line_id'] }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-200 hover:text-gray-900 active:scale-90 transition-all font-bold" aria-label="Tăng số lượng">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between sm:justify-end gap-5">
                                        <div class="text-sm font-semibold text-gray-800">
                                            Tạm tính: <span class="font-extrabold text-red-600 text-base" data-item-subtotal="{{ $item['line_id'] }}">{{ number_format($item['price_value'] * $item['quantity'], 0, ',', '.') }}đ</span>
                                        </div>
                                        
                                        <button type="button" data-cart-delete-btn="{{ $item['line_id'] }}" class="rounded-xl border border-red-100 bg-red-50/50 hover:bg-red-50 hover:border-red-200 px-3.5 py-2 text-xs font-bold text-red-600 transition-all flex items-center gap-1 active:scale-95">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Panel tổng hợp thanh toán -->
            <aside class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm space-y-4 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100">Tổng đơn hàng</h2>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>Số lượng sản phẩm</span>
                        <span class="font-bold text-gray-800"><span id="cart-summary-count">{{ $cartCount }}</span> sản phẩm</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>Phí vận chuyển</span>
                        <span class="font-bold text-green-600">Miễn phí giao hàng</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                    <span class="text-base font-bold text-gray-900">Thành tiền</span>
                    <span id="cart-subtotal" class="text-2xl font-black text-red-600">{{ number_format($cartSubtotal, 0, ',', '.') }}đ</span>
                </div>

                <div class="pt-2 space-y-2">
                    <a href="{{ route('checkout.index') }}" class="inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-red-600 to-orange-500 hover:opacity-95 text-white font-bold py-3.5 px-5 text-sm transition-all shadow-md shadow-red-500/20 active:scale-[0.98]">
                        Tiến hành đặt hàng
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-orange-300 hover:text-orange-600 transition-all">
                        Tiếp tục mua sắm
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
