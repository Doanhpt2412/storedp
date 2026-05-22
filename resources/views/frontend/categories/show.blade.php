<x-layouts.app :title="$currentNode['label'] . ' | ' . config('app.name')" :navCategories="$navCategories">
    @php
        $activeBrand = !empty($currentNode['is_brand']) ? $currentNode['slug'] : request()->string('brand')->toString();
        $activeCategory = empty($currentNode['is_brand']) ? $currentNode['slug'] : null;

        $getSidebarUrl = function ($catSlug) use ($activeBrand) {
            if ($activeBrand) {
                return route('categories.show', ['path' => $catSlug, 'brand' => $activeBrand]);
            }

            return route('categories.show', $catSlug);
        };

        $isCatActive = function ($catSlug) use ($currentNode) {
            if (empty($currentNode['is_brand']) && !empty($currentNode['path'])) {
                return str_starts_with($currentNode['path'], $catSlug);
            }

            return false;
        };

        $getBrandUrl = function ($brandSlug) use ($currentNode, $activeCategory) {
            $isCurrentlyThisBrand = (isset($currentNode['is_brand']) && strtolower($currentNode['slug']) === $brandSlug)
                || (request()->string('brand')->toString() === $brandSlug);

            if ($isCurrentlyThisBrand) {
                if (!empty($currentNode['is_brand'])) {
                    return route('categories.show');
                }

                return route('categories.show', $activeCategory);
            }

            if ($activeCategory) {
                return route('categories.show', ['path' => $activeCategory, 'brand' => $brandSlug]);
            }

            return route('categories.show', $brandSlug);
        };
    @endphp

    <div class="relative flex gap-6">
        <aside class="sticky top-24 hidden shrink-0 self-start rounded-2xl border border-gray-200 bg-white px-3 py-6 shadow-sm lg:flex lg:flex-col lg:items-center lg:gap-4">
            <a href="{{ $getSidebarUrl('dien-thoai') }}" class="rounded-xl p-2.5 transition {{ $isCatActive('dien-thoai') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Điện thoại">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"></path></svg>
            </a>
            <a href="{{ $getSidebarUrl('laptop') }}" class="rounded-xl p-2.5 transition {{ $isCatActive('laptop') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Laptop">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></path></svg>
            </a>
            <a href="{{ $getSidebarUrl('may-cu') }}" class="rounded-xl p-2.5 transition {{ $isCatActive('may-cu') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Máy cũ">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path></svg>
            </a>
            <a href="{{ $getSidebarUrl('may-tinh-bang') }}" class="rounded-xl p-2.5 transition {{ $isCatActive('may-tinh-bang') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Máy tính bảng">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z"></path></svg>
            </a>
            <a href="{{ $getSidebarUrl('phu-kien') }}" class="rounded-xl p-2.5 transition {{ $isCatActive('phu-kien') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Phụ kiện">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
            </a>
        </aside>

        <div class="flex flex-1 flex-col gap-6">
            <nav class="flex items-center gap-1.5 text-xs text-gray-500">
                <a href="{{ route('home') }}" class="transition hover:text-orange-600">Trang chủ</a>
                <span>/</span>
                <a href="{{ route('categories.show') }}" class="transition hover:text-orange-600">Danh mục</a>
                @foreach ($currentNode['breadcrumbs'] as $breadcrumb)
                    <span>/</span>
                    <a href="{{ route('categories.show', $breadcrumb['slug']) }}" class="transition hover:text-orange-600 {{ $loop->last ? 'font-semibold text-gray-800' : '' }}">
                        {{ $breadcrumb['label'] }}
                    </a>
                @endforeach
            </nav>

            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $currentNode['label'] }}</h1>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach (($categoryBanners ?? []) as $banner)
                    <a href="{{ $banner['url'] ?: '#' }}" class="group relative flex h-48 overflow-hidden rounded-2xl shadow-sm md:h-56">
                        @if (!empty($banner['image_url']))
                            <img src="{{ $banner['image_url'] }}" alt="{{ $banner['title'] ?? 'Banner danh mục' }}" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-slate-950/45"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-orange-700"></div>
                        @endif

                        <div class="relative z-10 flex max-w-[75%] flex-col items-start justify-end gap-2 p-6 md:p-8">
                            @if (!empty($banner['eyebrow']))
                                <span class="rounded bg-white/15 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-white">{{ $banner['eyebrow'] }}</span>
                            @endif
                            <h2 class="text-xl font-extrabold leading-tight text-white md:text-2xl">{{ $banner['title'] }}</h2>
                            @if (!empty($banner['url']))
                                <span class="mt-2 rounded-full bg-white px-4 py-2 text-xs font-bold text-gray-900 shadow-md">Xem ngay</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-4 flex flex-col gap-3">
                <h2 class="text-base font-bold text-gray-900">Chọn theo thương hiệu sản phẩm</h2>
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                    @foreach ($brands as $b)
                        @php
                            $isCurrentBrand = (isset($currentNode['is_brand']) && strtolower($currentNode['slug']) === $b->slug)
                                || (request()->string('brand')->toString() === $b->slug);
                        @endphp
                        <a href="{{ $getBrandUrl($b->slug) }}" class="flex h-16 flex-col items-center justify-center rounded-xl border bg-white p-3 transition-all duration-300 {{ $isCurrentBrand ? 'border-orange-500 ring-2 ring-orange-500/10' : 'border-gray-200 hover:border-orange-500 hover:shadow-sm' }}">
                            <span class="text-xs font-extrabold tracking-tight text-gray-800">{{ $b->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('categories.show', $currentNode['slug']) }}" method="get" class="mt-2 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-gray-200 bg-white p-4">
                <input type="hidden" name="q" value="{{ $query }}">

                <div class="flex flex-wrap items-center gap-3">
                    <span class="mr-1 text-xs font-bold uppercase tracking-wide text-gray-400">Lọc theo:</span>

                    <select name="brand" onchange="this.form.submit()" class="cursor-pointer rounded-full border border-gray-200 bg-gray-50 px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none transition hover:bg-gray-100">
                        <option value="">Tất cả Hãng</option>
                        @foreach ($filters['brands'] as $brand)
                            <option value="{{ $brand['slug'] }}" {{ $selectedFilters['brand'] === $brand['slug'] ? 'selected' : '' }}>
                                {{ $brand['label'] }}
                            </option>
                        @endforeach
                    </select>

                    <select name="series" onchange="this.form.submit()" class="cursor-pointer rounded-full border border-gray-200 bg-gray-50 px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none transition hover:bg-gray-100">
                        <option value="">Tất cả Dòng</option>
                        @foreach ($filters['series'] as $series)
                            <option value="{{ $series['slug'] }}" {{ $selectedFilters['series'] === $series['slug'] ? 'selected' : '' }}>
                                {{ $series['label'] }}
                            </option>
                        @endforeach
                    </select>

                    <select name="price" onchange="this.form.submit()" class="cursor-pointer rounded-full border border-gray-200 bg-gray-50 px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none transition hover:bg-gray-100">
                        <option value="">Mức giá</option>
                        @foreach ($filters['prices'] as $price)
                            <option value="{{ $price['slug'] }}" {{ $selectedFilters['price'] === $price['slug'] ? 'selected' : '' }}>
                                {{ $price['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-500">Sắp xếp theo:</span>
                    <select name="sort" onchange="this.form.submit()" class="cursor-pointer rounded-full border border-gray-200 bg-gray-50 px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none transition hover:bg-gray-100">
                        <option value="">Mặc định</option>
                        <option value="price-asc" {{ $selectedFilters['sort'] === 'price-asc' ? 'selected' : '' }}>Giá thấp - Cao</option>
                        <option value="price-desc" {{ $selectedFilters['sort'] === 'price-desc' ? 'selected' : '' }}>Giá cao - Thấp</option>
                        <option value="name-asc" {{ $selectedFilters['sort'] === 'name-asc' ? 'selected' : '' }}>Tên A-Z</option>
                    </select>
                </div>
            </form>

            <div class="mt-2 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ count($products) }} sản phẩm phù hợp</span>
                    @if(request()->filled('brand') || request()->filled('series') || request()->filled('price') || request()->filled('sort'))
                        <a href="{{ route('categories.show', $currentNode['path']) }}" class="text-xs font-bold text-orange-600 hover:underline">Xóa tất cả bộ lọc</a>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4">
                    @forelse ($products as $product)
                        <x-frontend.product-card :product="$product" />
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center gap-3 rounded-2xl border border-gray-100 bg-white p-12 text-center">
                            <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                            <h3 class="text-sm font-bold text-gray-800">Không có sản phẩm nào phù hợp với bộ lọc</h3>
                            <p class="text-xs text-gray-400">Vui lòng chọn mức giá khác hoặc xóa bớt tiêu chí lọc.</p>
                            <a href="{{ route('categories.show', $currentNode['path']) }}" class="mt-2 rounded-full bg-orange-600 px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-orange-700">Đặt lại</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
