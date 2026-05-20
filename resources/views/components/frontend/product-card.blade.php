@props(['product'])

@php
    $discount = $product['discount'] ?? '';
    $storageOptions = ['128GB', '256GB', '512GB', '1TB'];
    $currentStorage = $product['storage'] ?? '128GB';

    if (str_contains($currentStorage, '256')) $currentStorage = '256GB';
    if (str_contains($currentStorage, '512')) $currentStorage = '512GB';
    if (str_contains($currentStorage, '128')) $currentStorage = '128GB';
    if (str_contains(strtolower($currentStorage), '1t')) $currentStorage = '1TB';
@endphp

<article class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 relative overflow-hidden flex flex-col justify-between h-full p-3 group">
    <div class="flex items-center justify-between w-full mb-2">
        @if ($discount !== '')
            <span class="text-white text-[10px] font-bold px-2 py-0.5 rounded-br-lg rounded-tl-sm -ml-3 -mt-3 shadow-sm" style="background: #f95f06;">
                {{ $discount }}
            </span>
        @else
            <div></div>
        @endif

        <a href="{{ route('products.show', $product['slug']) }}" class="text-gray-300 hover:text-red-500 transition ml-auto" aria-label="Xem san pham">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        </a>
    </div>

    <div class="w-full flex items-center justify-center py-2 h-44 overflow-hidden relative">
        <a href="{{ route('products.show', $product['slug']) }}" class="block transform group-hover:scale-105 transition duration-300">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="object-contain max-h-40" loading="lazy">
        </a>
    </div>

    <div class="flex-1 flex flex-col justify-between mt-2">
        <div>
            <h3 class="text-gray-800 font-bold text-xs leading-snug min-h-[36px] hover:text-orange-600 transition">
                <a href="{{ route('products.show', $product['slug']) }}">
                    {{ $product['name'] }}
                </a>
            </h3>

            <div class="flex flex-wrap gap-1 mt-2">
                @foreach ($storageOptions as $option)
                    @php $isActive = $option === $currentStorage; @endphp
                    <span class="text-[9px] px-1.5 py-0.5 rounded border font-semibold transition {{ $isActive ? 'bg-orange-500 border-orange-500 text-white' : 'bg-gray-50 border-gray-200 text-gray-400' }}">
                        {{ $option }}
                    </span>
                @endforeach
            </div>

            <div class="flex items-baseline gap-1.5 mt-2.5">
                <strong class="text-red-600 text-sm font-extrabold">{{ $product['price'] }}</strong>
                @if (! empty($product['old_price']))
                    <span class="text-[10px] text-gray-400 line-through">{{ $product['old_price'] }}</span>
                @endif
            </div>

            <div class="flex items-center gap-2 mt-1">
                <div class="flex items-center text-[10px] text-yellow-400 font-semibold gap-0.5">
                    <span>★</span>
                    <span>{{ $product['rating'] ?? 5 }}</span>
                </div>
                <span class="bg-red-50 text-red-600 text-[8px] font-bold px-1.5 py-0.5 rounded border border-red-200">Moi 100%</span>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-2 mt-3 text-[9px] text-gray-500 leading-relaxed border border-gray-100 flex flex-col gap-1">
            <div class="flex items-center gap-1">
                <span class="w-1 h-1 rounded-full bg-orange-500"></span>
                <span>Ho tro tra gop 0%</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="w-1 h-1 rounded-full bg-orange-500"></span>
                <span>Thu cu doi moi tro gia den 2.500.000d</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="w-1 h-1 rounded-full bg-orange-500"></span>
                <span>Bao hanh 12 thang chinh hang</span>
            </div>
        </div>

        <div class="mt-3 grid grid-cols-2 gap-2">
            <a href="{{ route('products.show', $product['slug']) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-[11px] font-semibold text-gray-700 hover:border-orange-300 hover:text-orange-600 transition">
                Xem chi tiet
            </a>
            <form action="{{ route('cart.store') }}" method="post">
                @csrf
                <input type="hidden" name="slug" value="{{ $product['slug'] }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-orange-500 px-3 py-2 text-[11px] font-semibold text-white hover:bg-orange-600 transition">
                    Them vao gio
                </button>
            </form>
        </div>
    </div>
</article>
