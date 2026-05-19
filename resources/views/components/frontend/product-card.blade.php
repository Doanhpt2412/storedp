@props(['product'])

<article class="product-card product-card--showcase">
    <div class="product-card__media">
        <a href="{{ route('products.show', $product['slug']) }}" class="product-card__image-link">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy">
        </a>

        <div class="product-card__overlay-badges">
            <span class="product-card__badge product-card__badge--live">{{ $product['tag'] }}</span>
            <span class="product-card__badge product-card__badge--genre">{{ $product['brand'] }}, {{ $product['category'] }}</span>
        </div>
    </div>

    <div class="product-card__panel">
        <h3 class="product-card__title">
            <a href="{{ route('products.show', $product['slug']) }}">{{ $product['name'] }}</a>
        </h3>

        <div class="product-card__chip-row">
            <span class="product-card__chip product-card__chip--blue">{{ $product['storage'] }}</span>
            <span class="product-card__chip product-card__chip--green">{{ $product['brand'] }}</span>
            <span class="product-card__chip product-card__chip--gray">{{ $product['color'] }}</span>
        </div>

        <div class="product-card__info-row">
            <strong>{{ $product['price'] }}</strong>
            <span>{{ $product['reviews_count'] }}+ danh gia</span>
            @if (! empty($product['old_price']))
                <small>{{ $product['old_price'] }}</small>
            @endif
        </div>

        <div class="product-card__date-row">
            <span>{{ $product['release_label'] }}</span>
        </div>

        <div class="product-card__footer-actions">
            <a href="{{ route('products.show', $product['slug']) }}" class="product-card__cta product-card__cta--primary">
                Xem chi tiet
            </a>
            <a href="{{ route('products.show', $product['slug']) }}" class="product-card__cta product-card__cta--secondary">
                Mua ngay
            </a>
        </div>
    </div>
</article>
