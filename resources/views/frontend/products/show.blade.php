<x-layouts.app :title="$product['name'] . ' | ' . config('app.name')" :navCategories="$navCategories ?? []">

        <main class="product-page">
            <div class="container">
                <nav class="breadcrumb">
                    <a href="{{ route('home') }}">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('categories.show') }}">Danh mục</a>
                    @foreach ($productBreadcrumbs as $breadcrumb)
                        <span>/</span>
                        <a href="{{ route('categories.show', $breadcrumb['slug']) }}">{{ $breadcrumb['label'] }}</a>
                    @endforeach
                    <span>/</span>
                    <strong>{{ $product['name'] }}</strong>
                </nav>

                <section class="product-detail-hero">
                    <div class="product-gallery">
                        <div class="product-gallery__stage">
                            <img src="{{ $product['gallery'][0] }}" alt="{{ $product['name'] }}" data-gallery-main>
                        </div>

                        <div class="product-gallery__thumbs">
                            @foreach ($product['gallery'] as $image)
                                <button
                                    type="button"
                                    class="product-gallery__thumb{{ $loop->first ? ' is-active' : '' }}"
                                    data-gallery-thumb
                                    data-image="{{ $image }}"
                                    aria-label="Xem anh {{ $loop->iteration }}"
                                >
                                    <img src="{{ $image }}" alt="{{ $product['name'] }} {{ $loop->iteration }}">
                                </button>
                            @endforeach
                        </div>

                        <div class="product-highlight-grid">
                            @foreach ($product['highlights'] as $highlight)
                                <article class="product-highlight-card">
                                    <span>Feature {{ $loop->iteration }}</span>
                                    <p>{{ $highlight }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    <aside class="product-summary flex flex-col gap-5" data-variant-picker data-variants='@json($product['variant_matrix'] ?? [])'>
                        <!-- Tiêu đề & Đánh giá -->
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 leading-tight mb-2">{{ $product['name'] }}</h1>
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                <span class="flex items-center text-yellow-500">
                                    {{ str_repeat('★', $product['rating']) }}{{ str_repeat('☆', 5 - $product['rating']) }}
                                </span>
                                <span class="h-3 w-px bg-gray-300"></span>
                                <span>{{ $product['reviews_count'] }} đánh giá</span>
                                <span class="h-3 w-px bg-gray-300"></span>
                                <span>Mã: <strong class="text-gray-900" data-variant-sku>{{ $product['sku'] }}</strong></span>
                            </div>
                        </div>

                        <!-- Trạng thái -->
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-red-600 text-white text-xs font-bold rounded shadow-sm">MỚI 100%</span>
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded" data-variant-status>{{ $product['status'] }}</span>
                        </div>

                        <!-- Giá & Khuyến mãi (Block màu cam/đỏ) -->
                        <div class="border border-red-200 bg-red-50/30 rounded-xl overflow-hidden shadow-sm">
                            <div class="bg-gradient-to-r from-red-600 to-orange-500 px-4 py-2 text-center">
                                <span class="text-sm font-bold text-white uppercase tracking-wide">Giá Tốt - Trả góp 0%</span>
                            </div>
                            <div class="p-4 flex flex-col gap-3">
                                <div class="flex items-baseline gap-3">
                                    <span class="text-3xl font-extrabold text-red-600" data-variant-price>{{ $product['price'] }}</span>
                                    <span class="text-sm text-gray-400 line-through" data-variant-old-price>{{ $product['old_price'] }}</span>
                                    <span class="px-2 py-0.5 bg-red-100 text-red-600 text-xs font-bold rounded" data-variant-discount>{{ $product['discount'] }}</span>
                                </div>
                                <div class="text-sm text-gray-700">
                                    <strong>Giá tại:</strong>
                                    <select class="bg-transparent font-bold text-blue-600 outline-none cursor-pointer">
                                        <option>Hà Nội</option>
                                        <option>Hồ Chí Minh</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Lựa chọn phiên bản -->
                        <section class="mt-2">
                            <h3 class="text-sm font-semibold text-gray-800 mb-2">Chọn phiên bản: <span class="font-normal text-red-600" data-selected-storage>{{ $product['storage'] }}</span></h3>
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-2.5">
                                @foreach ($product['variants'] as $variant)
                                    <button type="button" data-storage-option="{{ $variant['label'] }}" class="relative p-2.5 border rounded-lg flex flex-col items-center justify-center text-center transition {{ $variant['active'] ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-400' }}">
                                        <strong class="text-sm {{ $variant['active'] ? 'text-red-600' : 'text-gray-800' }}">{{ $variant['label'] }}</strong>
                                        <span class="text-xs {{ $variant['active'] ? 'text-red-600' : 'text-gray-500' }} mt-0.5">Giá từ {{ $variant['price'] ?? $product['price'] }}</span>
                                        <span data-active-check class="{{ $variant['active'] ? '' : 'hidden' }} absolute top-0 right-0 w-4 h-4 bg-red-500 text-white flex items-center justify-center rounded-bl-lg rounded-tr-lg text-[10px]">✓</span>
                                    </button>
                                @endforeach
                            </div>
                        </section>

                        <!-- Lựa chọn màu sắc -->
                        <section class="mt-2">
                            <h3 class="text-sm font-semibold text-gray-800 mb-2">Chọn màu sắc: <span class="font-normal text-red-600" data-selected-color>{{ $product['color'] }}</span></h3>
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-2.5">
                                @foreach ($product['colors'] as $color)
                                    <button type="button" data-color-option="{{ $color['label'] }}" class="relative p-2.5 border rounded-lg flex flex-col items-center justify-center text-center transition {{ $color['active'] ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-400' }}">
                                        <div class="flex items-center gap-1.5 mb-1">
                                            <span class="w-4 h-4 rounded-full shadow-sm border border-gray-300" style="background-color: {{ $color['hex'] }}"></span>
                                            <strong class="text-sm {{ $color['active'] ? 'text-red-600' : 'text-gray-800' }}">{{ $color['label'] }}</strong>
                                        </div>
                                        <span class="text-xs {{ $color['active'] ? 'text-red-600' : 'text-gray-500' }}">{{ $color['price'] ?? $product['price'] }}</span>
                                        <span data-active-check class="{{ $color['active'] ? '' : 'hidden' }} absolute top-0 right-0 w-4 h-4 bg-red-500 text-white flex items-center justify-center rounded-bl-lg rounded-tr-lg text-[10px]">✓</span>
                                    </button>
                                @endforeach
                            </div>
                        </section>

                        <!-- Ưu đãi -->
                        <section class="border border-green-200 bg-white rounded-xl overflow-hidden mt-2 shadow-sm">
                            <div class="bg-green-50 px-4 py-2.5 border-b border-green-200 flex items-center gap-2">
                                <span class="text-green-600">🎁</span>
                                <h3 class="text-sm font-bold text-green-700">Khuyến mãi & Ưu đãi</h3>
                            </div>
                            <div class="p-4">
                                <ul class="flex flex-col gap-2.5">
                                    @foreach ($product['benefits'] as $benefit)
                                        <li class="flex items-start gap-2 text-sm text-gray-700">
                                            <span class="text-green-500 font-bold mt-0.5">✔</span>
                                            <span>{{ $benefit }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>

                        <!-- Hành động -->
                        <div class="flex flex-col sm:flex-row gap-3 mt-2">
                            <button class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition flex flex-col items-center shadow-lg shadow-red-500/30">
                                <span class="text-base uppercase tracking-wide">Mua ngay</span>
                                <span class="text-[11px] font-normal opacity-90">Giao tận nơi hoặc nhận tại cửa hàng</span>
                            </button>
                            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition flex flex-col items-center shadow-lg shadow-blue-500/30">
                                <span class="text-base uppercase tracking-wide">Trả góp</span>
                                <span class="text-[11px] font-normal opacity-90">Xét duyệt nhanh qua điện thoại</span>
                            </button>
                            <button class="w-14 sm:w-16 bg-white border border-red-500 text-red-500 hover:bg-red-50 rounded-xl flex items-center justify-center transition" aria-label="Thêm vào giỏ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                            </button>
                        </div>
                    </aside>
                </section>

                <section class="product-content-grid">
                    <article class="product-content-card">
                        <div class="content-card__header">
                            <p class="section-kicker">Mo ta chi tiet</p>
                            <h2>Danh gia nhanh {{ $product['name'] }}</h2>
                        </div>

                        @foreach ($product['description_sections'] as $section)
                            <section class="rich-copy-block">
                                <h3>{{ $section['title'] }}</h3>
                                @foreach ($section['content'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </section>
                        @endforeach
                    </article>

                    <aside class="product-side-stack">
                        <section class="product-content-card">
                            <div class="content-card__header" style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                                <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0;">Thông số kỹ thuật</h2>
                                <button type="button" data-modal-open="specs-modal" style="color: var(--accent); background: none; border: none; padding: 0; cursor: pointer; text-decoration: none; font-size: 0.95rem;">Xem cấu hình chi tiết</button>
                            </div>

                            <div class="spec-table">
                                @foreach ($product['technical_specs'] as $spec)
                                    <div class="spec-row">
                                        <span>{{ $spec['label'] }}</span>
                                        <strong>{{ $spec['value'] }}</strong>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="product-content-card">
                            <div class="content-card__header">
                                <p class="section-kicker">Phu kien di kem</p>
                                <h2>Trong hop co gi</h2>
                            </div>

                            <ul class="box-list">
                                @foreach ($product['in_the_box'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </section>
                    </aside>
                </section>

                <section class="section-block">
                    <div class="section-heading">
                        <div>
                            <p class="section-kicker">Lien quan</p>
                            <h2>San pham cung nhom dang duoc quan tam</h2>
                        </div>
                    </div>

                    <div class="product-grid">
                        @foreach ($relatedProducts as $relatedProduct)
                            <x-frontend.product-card :product="$relatedProduct" />
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- Specs Modal -->
            <div class="modal" id="specs-modal" aria-hidden="true">
                <div class="modal__overlay" tabindex="-1" data-modal-close></div>
                <div class="modal__dialog" role="dialog" aria-modal="true" aria-labelledby="specs-modal-title">
                    <header class="modal__header">
                        <h2 id="specs-modal-title">Thông số kỹ thuật chi tiết</h2>
                        <button type="button" class="modal__close" aria-label="Đóng" data-modal-close>&times;</button>
                    </header>
                    <div class="modal__content">
                        <div class="spec-table spec-table--full">
                            @foreach ($product['technical_specs'] as $spec)
                                <div class="spec-row" style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--surface-border);">
                                    <span style="color: var(--text-muted);">{{ $spec['label'] }}</span>
                                    <strong style="text-align: right; max-width: 60%;">{{ $spec['value'] }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>

</x-layouts.app>
