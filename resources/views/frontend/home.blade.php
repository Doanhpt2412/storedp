<x-layouts.app :navCategories="$navCategories ?? []">

        <main class="homepage">
            <section class="container hero-layout">
                <aside class="category-panel">
                    <h2>Danh mục nổi bật</h2>
                    <ul>
                        @foreach ($navCategories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category->slug ?? '') }}">
                                    <span>{{ $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration }}</span>
                                    {{ $category->name ?? $category }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>

                <div class="hero-showcase">
                    <div class="hero-slider" data-slider>
                        <div class="hero-slider__track">
                            @foreach ($heroSlides as $slide)
                                <article class="hero-slide{{ $loop->first ? ' is-active' : '' }}" data-slide>
                                    <div class="hero-slide__content">
                                        <p class="hero-slide__eyebrow">{{ $slide['eyebrow'] }}</p>
                                        <h1>{{ $slide['title'] }}</h1>
                                        <p>{{ $slide['description'] }}</p>

                                        <div class="hero-slide__actions">
                                            <a href="#" class="button-primary">{{ $slide['primary_cta'] }}</a>
                                            <a href="#" class="button-secondary">{{ $slide['secondary_cta'] }}</a>
                                        </div>
                                    </div>

                                    <div class="hero-slide__visual">
                                        <div class="hero-stat">
                                            <span>Ưu đãi</span>
                                            <strong>{{ $slide['highlight'] }}</strong>
                                        </div>
                                        <div class="hero-device-card">
                                            <span>StoreDP Selection</span>
                                            <strong>Sản phẩm công nghệ chọn lọc</strong>
                                            <p>Bố cục mô phỏng sát UX của trang bán lẻ công nghệ quy mô lớn.</p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="hero-slider__dots">
                            @foreach ($heroSlides as $slide)
                                <button
                                    type="button"
                                    class="hero-slider__dot{{ $loop->first ? ' is-active' : '' }}"
                                    data-slide-dot
                                    aria-label="Chuyển slide {{ $loop->iteration }}"
                                ></button>
                            @endforeach
                        </div>
                    </div>

                    <div class="mini-banners">
                        <article class="mini-banner mini-banner--gold">
                            <span>Trả góp 0%</span>
                            <strong>Mua trước, thanh toán linh hoạt</strong>
                        </article>
                        <article class="mini-banner mini-banner--blue">
                            <span>Thu cũ đổi mới</span>
                            <strong>Lên đời nhanh, trợ giá minh bạch</strong>
                        </article>
                    </div>
                </div>
            </section>

            <section class="container service-strip">
                @foreach ($serviceHighlights as $service)
                    <article class="service-pill">
                        <span class="service-pill__icon">{{ $loop->iteration }}</span>
                        <p>{{ $service }}</p>
                    </article>
                @endforeach
            </section>

            <section class="container section-block">
                <div class="section-heading">
                    <div>
                        <p class="section-kicker">Danh mục nhanh</p>
                        <h2>Nhóm sản phẩm được quan tâm nhiều nhất</h2>
                    </div>
                </div>

                <div class="featured-category-grid">
                    @foreach ($featuredCategories as $category)
                        <a href="{{ route('categories.show', $category['slug'] ?? '') }}" class="featured-category-card">
                            <span class="featured-category-card__icon">{{ $category['icon'] }}</span>
                            <strong>{{ $category['name'] }}</strong>
                            <small>{{ $category['note'] }}</small>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="container section-block promotions-block">
                <div class="section-heading">
                    <div>
                        <p class="section-kicker">Khuyến mãi</p>
                        <h2>Ưu đãi lớn đang chạy trên trang chủ</h2>
                    </div>
                    <a href="#" class="section-link">Xem tất cả</a>
                </div>

                <div class="promotion-grid">
                    @foreach ($promotions as $promotion)
                        <article class="promotion-card">
                            <span class="promotion-card__date">{{ $promotion['date'] }}</span>
                            <h3>{{ $promotion['title'] }}</h3>
                            <p>{{ $promotion['subtitle'] }}</p>
                            <a href="#">Nhận ưu đãi ngay</a>
                        </article>
                    @endforeach
                </div>
            </section>

            @foreach ($productSections as $section)
                <section class="container section-block product-showcase">
                    <div class="section-heading">
                        <div>
                            <p class="section-kicker">{{ $section['badge'] }}</p>
                            <h2>{{ $section['title'] }}</h2>
                            <p class="section-description">{{ $section['subtitle'] }}</p>
                        </div>
                        <a href="#" class="section-link">Xem thêm</a>
                    </div>

                    <div class="product-grid">
                        @foreach ($section['products'] as $product)
                            <x-frontend.product-card :product="$product" />
                        @endforeach
                    </div>
                </section>
            @endforeach
        </main>
</x-layouts.app>
