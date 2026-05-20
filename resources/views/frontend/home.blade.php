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
                                <article
                                    class="hero-slide{{ $loop->first ? ' is-active' : '' }}"
                                    data-slide
                                    @if (!empty($slide['image_url']))
                                        style="background-image: url('{{ $slide['image_url'] }}')"
                                    @endif
                                >
                                    <div class="hero-slide__content">
                                        <p class="hero-slide__eyebrow">{{ $slide['eyebrow'] ?? '' }}</p>
                                        <h1>{{ $slide['title'] ?? '' }}</h1>
                                        <p>{{ $slide['description'] ?? '' }}</p>

                                        <div class="hero-slide__actions">
                                            @if (filled($slide['primary_label'] ?? null) && filled($slide['primary_url'] ?? null))
                                                <a href="{{ $slide['primary_url'] }}" class="button-primary">{{ $slide['primary_label'] }}</a>
                                            @endif

                                            @if (filled($slide['secondary_label'] ?? null) && filled($slide['secondary_url'] ?? null))
                                                <a href="{{ $slide['secondary_url'] }}" class="button-secondary">{{ $slide['secondary_label'] }}</a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="hero-slide__visual">
                                        @if ($slide['highlight_label'])
                                        <div class="hero-stat">
                                            <span>{{ $slide['highlight_label'] ?? 'Ưu đãi nổi bật' }}</span>
                                            <strong>{{ $slide['highlight_text'] ?? '' }}</strong>
                                        </div>
                                        @endif
                                        @if ($slide['card_title'])
                                        <div class="hero-device-card">
                                            <strong>{{ $slide['card_title'] ?? 'Cụm sản phẩm nổi bật' }}</strong>
                                            <p>{{ $slide['card_text'] ?? '' }}</p>
                                        </div>
                                        @endif
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
                        @foreach ($homeBanners as $banner)
                            <a
                                href="{{ $banner['url'] ?? '#' }}"
                                class="mini-banner{{ $loop->odd ? ' mini-banner--gold' : ' mini-banner--blue' }}"
                                @if (!empty($banner['image_url']))
                                    style="background-image: url('{{ $banner['image_url'] }}')"
                                @endif
                            >
                                <span>{{ $banner['eyebrow'] ?? '' }}</span>
                                <strong>{{ $banner['title'] ?? '' }}</strong>
                            </a>
                        @endforeach
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

            @foreach ($productSections as $section)
                <section class="container section-block product-showcase">
                    <div class="section-heading">
                        <div>
                            <p class="section-kicker">{{ $section['badge'] }}</p>
                            <h2>{{ $section['title'] }}</h2>
                            <p class="section-description">{{ $section['subtitle'] }}</p>
                        </div>
                        <a href="#" class="section-link">Xem them</a>
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
