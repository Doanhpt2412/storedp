<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $currentNode['label'] }} | {{ config('app.name') }}</title>
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

                <form class="header-search" action="{{ route('categories.show', $currentNode['path']) }}" method="get">
                    <input type="search" name="q" value="{{ $query }}" placeholder="Tim trong danh muc nay..." aria-label="Tim kiem">
                    <button type="submit">Tim kiem</button>
                </form>

                <div class="header-contact">
                    <div>
                        <strong>Danh muc san pham</strong>
                        <span>Bo loc va duong dan da cap</span>
                    </div>
                    <a href="{{ route('home') }}" class="cart-link">Ve trang chu</a>
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

        <main class="category-page">
            <div class="container">
                <nav class="breadcrumb">
                    <a href="{{ route('home') }}">Trang chu</a>
                    <span>/</span>
                    <a href="{{ route('categories.show') }}">Danh muc</a>
                    @foreach ($currentNode['breadcrumbs'] as $breadcrumb)
                        <span>/</span>
                        <a href="{{ route('categories.show', implode('/', array_slice(array_column($currentNode['breadcrumbs'], 'slug'), 0, $loop->iteration))) }}">
                            {{ $breadcrumb['label'] }}
                        </a>
                    @endforeach
                </nav>

                <section class="category-hero">
                    <div>
                        <p class="section-kicker">Category Path</p>
                        <h1>{{ $currentNode['label'] }}</h1>
                        <p class="section-description">
                            Route taxonomy hien tai:
                            <code>{{ $currentNode['path'] !== '' ? $currentNode['path'] : 'catalog' }}</code>
                        </p>
                    </div>

                    @if ($childPaths !== [])
                        <div class="taxonomy-chip-grid">
                            @foreach ($childPaths as $childPath)
                                <a href="{{ route('categories.show', $childPath['path']) }}" class="taxonomy-chip">
                                    <span>Cap {{ $childPath['level'] }}</span>
                                    <strong>{{ $childPath['label'] }}</strong>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="catalog-layout">
                    <aside class="filter-sidebar">
                        <form action="{{ route('categories.show', $currentNode['path']) }}" method="get" class="filter-panel">
                            <div class="filter-group">
                                <h2>Tim kiem</h2>
                                <input type="search" name="q" value="{{ $query }}" class="filter-input" placeholder="Nhap ten san pham">
                            </div>

                            <div class="filter-group">
                                <h2>Thuong hieu</h2>
                                <div class="filter-option-list">
                                    @foreach ($filters['brands'] as $brand)
                                        <label class="filter-option">
                                            <input type="radio" name="brand" value="{{ $brand['slug'] }}" {{ $selectedFilters['brand'] === $brand['slug'] ? 'checked' : '' }}>
                                            <span>{{ $brand['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-group">
                                <h2>Nhom san pham</h2>
                                <div class="filter-option-list">
                                    @foreach ($filters['lines'] as $line)
                                        <label class="filter-option">
                                            <input type="radio" name="line" value="{{ $line['slug'] }}" {{ $selectedFilters['line'] === $line['slug'] ? 'checked' : '' }}>
                                            <span>{{ $line['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-group">
                                <h2>Series</h2>
                                <div class="filter-option-list">
                                    @foreach ($filters['series'] as $series)
                                        <label class="filter-option">
                                            <input type="radio" name="series" value="{{ $series['slug'] }}" {{ $selectedFilters['series'] === $series['slug'] ? 'checked' : '' }}>
                                            <span>{{ $series['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-group">
                                <h2>Muc gia</h2>
                                <div class="filter-option-list">
                                    @foreach ($filters['prices'] as $price)
                                        <label class="filter-option">
                                            <input type="radio" name="price" value="{{ $price['slug'] }}" {{ $selectedFilters['price'] === $price['slug'] ? 'checked' : '' }}>
                                            <span>{{ $price['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-group">
                                <h2>Sap xep</h2>
                                <select name="sort" class="filter-input">
                                    <option value="">Mac dinh</option>
                                    <option value="price-asc" {{ $selectedFilters['sort'] === 'price-asc' ? 'selected' : '' }}>Gia thap den cao</option>
                                    <option value="price-desc" {{ $selectedFilters['sort'] === 'price-desc' ? 'selected' : '' }}>Gia cao den thap</option>
                                    <option value="name-asc" {{ $selectedFilters['sort'] === 'name-asc' ? 'selected' : '' }}>Ten A-Z</option>
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="purchase-button purchase-button--primary">Loc ket qua</button>
                                <a href="{{ route('categories.show', $currentNode['path']) }}" class="purchase-button purchase-button--ghost">Dat lai</a>
                            </div>
                        </form>
                    </aside>

                    <div class="catalog-results">
                        <div class="section-heading">
                            <div>
                                <p class="section-kicker">Product Listing</p>
                                <h2>{{ count($products) }} san pham phu hop</h2>
                            </div>
                        </div>

                        <div class="catalog-path-grid">
                            @foreach ($products as $product)
                                <article class="catalog-path-card">
                                    <small>{{ strtoupper($product['brand_slug']) }} / {{ $product['line_label'] }}</small>
                                    <strong>{{ $product['series_label'] ?? $product['model_label'] }}</strong>
                                    <p>{{ $product['taxonomy_path'] }}</p>
                                </article>
                            @endforeach
                        </div>

                        <div class="product-grid">
                            @forelse ($products as $product)
                                <x-frontend.product-card :product="$product" />
                            @empty
                                <div class="product-content-card">
                                    <div class="content-card__header">
                                        <p class="section-kicker">Khong co ket qua</p>
                                        <h2>Khong tim thay san pham phu hop bo loc</h2>
                                    </div>
                                    <p class="section-description">Thu bo mot vai dieu kien loc hoac doi tu khoa tim kiem.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
