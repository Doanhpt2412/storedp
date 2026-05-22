@props(['product'])

@php
    $discount = $product['discount'] ?? '';
    $storageOptions = ['128GB', '256GB', '512GB', '1TB'];
    $currentStorage = $product['storage'] ?? '';
    $benefits = collect($product['benefits'] ?? [])->filter()->take(3)->values();

    if (str_contains($currentStorage, '256')) $currentStorage = '256GB';
    elseif (str_contains($currentStorage, '512')) $currentStorage = '512GB';
    elseif (str_contains($currentStorage, '128')) $currentStorage = '128GB';
    elseif (str_contains(strtolower($currentStorage), '1t')) $currentStorage = '1TB';
    else $currentStorage = null;
@endphp

<article class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 relative overflow-hidden flex flex-col justify-between h-full p-4 group">
    <div class="flex items-start justify-between gap-3 w-full mb-3">
        @if ($discount !== '')
            <span class="text-white text-[11px] font-bold px-2.5 py-1 rounded-br-lg rounded-tl-sm -ml-4 -mt-4 shadow-sm" style="background: #f95f06;">
                {{ $discount }}
            </span>
        @else
            <div></div>
        @endif

        <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full border border-red-200 shrink-0">Mới 100%</span>
    </div>

    <div class="w-full flex items-center justify-center py-2 h-48 overflow-hidden relative">
        <a href="{{ route('products.show', $product['slug']) }}" class="block transform group-hover:scale-105 transition duration-300">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="object-contain max-h-44" loading="lazy">
        </a>
    </div>

    <div class="flex-1 flex flex-col justify-between mt-3">
        <div>
            <h3 class="text-gray-800 font-bold text-sm leading-snug min-h-[42px] hover:text-orange-600 transition">
                <a href="{{ route('products.show', $product['slug']) }}">
                    {{ $product['name'] }}
                </a>
            </h3>

            @if ($currentStorage)
                <div class="flex flex-wrap gap-1.5 mt-3">
                    @foreach ($storageOptions as $option)
                        @php $isActive = $option === $currentStorage; @endphp
                        <span class="text-[10px] px-2 py-1 rounded border font-semibold transition {{ $isActive ? 'bg-orange-500 border-orange-500 text-white' : 'bg-gray-50 border-gray-200 text-gray-500' }}">
                            {{ $option }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="flex items-baseline gap-2 mt-3">
                <strong class="text-red-600 text-base font-extrabold">{{ $product['price'] }}</strong>
                @if (! empty($product['old_price']))
                    <span class="text-xs text-gray-400 line-through">{{ $product['old_price'] }}</span>
                @endif
            </div>

            <div class="flex items-center gap-2 mt-2">
                <div class="flex items-center text-xs text-yellow-500 font-semibold gap-1">
                    <span>★</span>
                    <span>{{ $product['rating'] ?? 5 }}</span>
                </div>
                @if (!empty($product['reviews_count']))
                    <span class="text-xs text-gray-500">{{ $product['reviews_count'] }} đánh giá</span>
                @endif
            </div>
        </div>

        <div class="bg-gray-50 rounded-xl p-3 mt-4 text-xs text-gray-600 leading-relaxed border border-gray-100 flex flex-col gap-1.5">
            @forelse ($benefits as $benefit)
                <div class="flex items-start gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                    <span>{{ $benefit }}</span>
                </div>
            @empty
                <div class="flex items-start gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                    <span>Bảo hành chính hãng, hỗ trợ kỹ thuật tận tâm.</span>
                </div>
            @endforelse
        </div>

        <div class="mt-4 grid grid-cols-3 gap-2.5">
            <a href="{{ route('products.show', $product['slug']) }}" class="col-span-2 inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-xs font-semibold text-gray-700 hover:border-orange-300 hover:text-orange-600 transition">
                Xem chi tiết
            </a>
            @if(isset($product['stock']) && $product['stock'] <= 0)
                <button type="button" class="col-span-1 w-full inline-flex items-center justify-center rounded-xl bg-gray-200 px-3 py-2.5 text-gray-500 cursor-not-allowed transition" disabled aria-label="Hết hàng">
                    <span class="text-xs font-semibold">Hết hàng</span>
                </button>
            @else
                <form action="{{ route('cart.store') }}" method="post" data-cart-form class="col-span-1">
                    @csrf
                    <input type="hidden" name="slug" value="{{ $product['slug'] }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-orange-500 px-3 py-2.5 text-white hover:bg-orange-600 transition" aria-label="Thêm vào giỏ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="8" cy="21" r="1"/>
                            <circle cx="19" cy="21" r="1"/>
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</article>
