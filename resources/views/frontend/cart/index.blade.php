<x-layouts.app :title="'Gio hang | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <section class="space-y-6">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-orange-500 font-semibold">Cart</p>
            <h1 class="text-3xl font-bold text-gray-900">Gio hang cua ban</h1>
            <p class="text-sm text-gray-500 mt-2">{{ $cartCount }} san pham trong gio</p>
        </div>

        @if ($cartItems === [])
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">
                <h2 class="text-xl font-semibold text-gray-900">Gio hang dang trong</h2>
                <p class="text-sm text-gray-500 mt-2">Them san pham tu trang chu, danh muc hoac trang chi tiet san pham.</p>
                <a href="{{ route('home') }}" class="inline-flex mt-5 rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600 transition">
                    Tiep tuc mua sam
                </a>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px] items-start">
                <div class="space-y-4">
                    @foreach ($cartItems as $item)
                        <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                            <div class="flex flex-col gap-4 md:flex-row">
                                <div class="w-full md:w-32 shrink-0 overflow-hidden rounded-xl bg-gray-50">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-32 w-full object-cover">
                                </div>

                                <div class="flex-1">
                                    <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                                        <div>
                                            <a href="{{ route('products.show', $item['slug']) }}" class="text-lg font-semibold text-gray-900 hover:text-orange-600 transition">
                                                {{ $item['name'] }}
                                            </a>
                                            <div class="mt-2 flex flex-wrap gap-2 text-xs text-gray-500">
                                                <span class="rounded-full bg-gray-100 px-3 py-1">{{ $item['brand'] }}</span>
                                                @if ($item['storage'])
                                                    <span class="rounded-full bg-gray-100 px-3 py-1">{{ $item['storage'] }}</span>
                                                @endif
                                                @if ($item['color'])
                                                    <span class="rounded-full bg-gray-100 px-3 py-1">{{ $item['color'] }}</span>
                                                @endif
                                                <span class="rounded-full bg-gray-100 px-3 py-1">SKU: {{ $item['sku'] }}</span>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-lg font-bold text-red-600">{{ $item['price'] }}</div>
                                            @if ($item['old_price'])
                                                <div class="text-sm text-gray-400 line-through">{{ $item['old_price'] }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <form action="{{ route('cart.update', $item['line_id']) }}" method="post" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <label for="qty-{{ $item['line_id'] }}" class="text-sm text-gray-500">So luong</label>
                                            <input id="qty-{{ $item['line_id'] }}" type="number" min="0" max="99" name="quantity" value="{{ $item['quantity'] }}" class="w-20 rounded-xl border border-gray-200 px-3 py-2 text-sm">
                                            <button type="submit" class="rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:border-orange-300 hover:text-orange-600 transition">
                                                Cap nhat
                                            </button>
                                        </form>

                                        <div class="flex items-center gap-3">
                                            <div class="text-sm font-semibold text-gray-900">
                                                Tam tinh: {{ number_format($item['price_value'] * $item['quantity'], 0, ',', '.') }}đ
                                            </div>
                                            <form action="{{ route('cart.destroy', $item['line_id']) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100 transition">
                                                    Xoa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Tong don hang</h2>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>So luong san pham</span>
                        <span>{{ $cartCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>Phi van chuyen</span>
                        <span>Lien he</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                        <span class="text-base font-semibold text-gray-900">Tam tinh</span>
                        <span class="text-2xl font-bold text-red-600">{{ number_format($cartSubtotal, 0, ',', '.') }}đ</span>
                    </div>
                    <button type="button" class="w-full rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600 transition">
                        Tien hanh dat hang
                    </button>
                    <a href="{{ route('home') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:border-orange-300 hover:text-orange-600 transition">
                        Tiep tuc mua sam
                    </a>
                </aside>
            </div>
        @endif
    </section>
</x-layouts.app>
