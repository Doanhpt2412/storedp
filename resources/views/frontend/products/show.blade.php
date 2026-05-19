<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $product['name'] }} | {{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="site-topbar">
            <div class="container topbar-inner">
                <p>Xem gia tai Ha Noi va Ho Chi Minh</p>
                <div class="topbar-actions">
                    <a href="#">Cua hang gan ban</a>
                    <a href="#">Tra cuu don hang</a>
                    <a href="#">Dang nhap</a>
                    <a href="tel:02466819779" class="topbar-phone">0246 681 9779</a>
                </div>
            </div>
        </div>

        <header class="site-header">
            <div class="container header-main">
                <a href="{{ route('home') }}" class="brand-mark" aria-label="StoreDP homepage">
                    <span>Store</span>DP
                </a>

                <form class="header-search" action="#" method="get">
                    <input type="search" name="q" placeholder="Tim iPhone, MacBook, Samsung, phu kien..." aria-label="Tim kiem">
                    <button type="submit">Tim kiem</button>
                </form>

                <div class="header-contact">
                    <div>
                        <strong>Tu van mua hang</strong>
                        <span>8:00 - 21:30 moi ngay</span>
                    </div>
                    <a href="#" class="cart-link">0 Gio hang</a>
                </div>
            </div>

            <nav class="header-nav">
                <div class="container nav-scroller">
                    @foreach ($navCategories as $category)
                        <a href="#">{{ $category }}</a>
                    @endforeach
                </div>
            </nav>
        </header>

        <main class="product-page">
            <div class="container">
                <nav class="breadcrumb">
                    <a href="{{ route('home') }}">Trang chu</a>
                    <span>/</span>
                    <a href="{{ route('categories.show') }}">Danh muc</a>
                    @php
                        $segments = [];
                    @endphp
                    @foreach ($productBreadcrumbs as $breadcrumb)
                        @php
                            $segments[] = $breadcrumb['slug'];
                        @endphp
                        <span>/</span>
                        <a href="{{ route('categories.show', implode('/', $segments)) }}">{{ $breadcrumb['label'] }}</a>
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

                    <aside class="product-summary">
                        <div class="product-summary__head">
                            <span class="product-summary__category">{{ $product['brand'] }} / {{ $product['category'] }}</span>
                            <h1>{{ $product['name'] }}</h1>
                            <div class="product-summary__meta">
                                <span>{{ str_repeat('★', $product['rating']) }}{{ str_repeat('☆', 5 - $product['rating']) }}</span>
                                <span>{{ $product['reviews_count'] }} danh gia</span>
                                <span>SKU: {{ $product['sku'] }}</span>
                            </div>
                        </div>

                        <div class="product-summary__price">
                            <strong>{{ $product['price'] }}</strong>
                            <span>{{ $product['old_price'] }}</span>
                            <em>{{ $product['discount'] }}</em>
                        </div>

                        <div class="product-summary__stock">
                            <span class="status-dot"></span>
                            {{ $product['status'] }}
                        </div>

                        <section class="option-group">
                            <div class="option-group__header">
                                <h2>Phien ban</h2>
                                <span>{{ $product['storage'] }}</span>
                            </div>
                            <div class="option-chip-grid">
                                @foreach ($product['variants'] as $variant)
                                    <button type="button" class="option-chip{{ $variant['active'] ? ' is-active' : '' }}">
                                        {{ $variant['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </section>

                        <section class="option-group">
                            <div class="option-group__header">
                                <h2>Mau sac</h2>
                                <span>{{ $product['color'] }}</span>
                            </div>
                            <div class="color-chip-grid">
                                @foreach ($product['colors'] as $color)
                                    <button type="button" class="color-chip{{ $color['active'] ? ' is-active' : '' }}">
                                        <span style="background-color: {{ $color['hex'] }}"></span>
                                        {{ $color['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </section>

                        <section class="offer-panel">
                            <h2>Uu dai khi mua ngay</h2>
                            <ul>
                                @foreach ($product['benefits'] as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </section>

                        <div class="purchase-actions">
                            <a href="#" class="purchase-button purchase-button--primary">Mua ngay</a>
                            <a href="#" class="purchase-button purchase-button--secondary">Them vao gio</a>
                            <a href="#" class="purchase-button purchase-button--ghost">Tu van tra gop</a>
                        </div>

                        <div class="support-grid">
                            <article>
                                <strong>Giao hang</strong>
                                <p>Noi thanh 2h, ngoai thanh giao nhanh toan quoc.</p>
                            </article>
                            <article>
                                <strong>Bao hanh</strong>
                                <p>Ho tro ro rang, kiem tra may va sao luu du lieu.</p>
                            </article>
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
                            <div class="content-card__header">
                                <p class="section-kicker">Thong so</p>
                                <h2>Cau hinh ky thuat</h2>
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
        </main>
    </body>
</html>
