<x-layouts.app :title="$currentNode['label'] . ' | ' . config('app.name')" :navCategories="$navCategories">
    @php
        $activeBrand = !empty($currentNode['is_brand']) ? $currentNode['slug'] : request()->string('brand')->toString();
        $activeCategory = empty($currentNode['is_brand']) ? $currentNode['slug'] : null;

        $getSidebarUrl = function($catSlug) use ($activeBrand) {
            if ($activeBrand) {
                return route('categories.show', ['path' => $catSlug, 'brand' => $activeBrand]);
            }
            return route('categories.show', $catSlug);
        };

        $isCatActive = function($catSlug) use ($currentNode) {
            if (empty($currentNode['is_brand']) && !empty($currentNode['path'])) {
                return str_starts_with($currentNode['path'], $catSlug);
            }
            return false;
        };

        $getBrandUrl = function($brandSlug) use ($currentNode, $activeCategory) {
            $isCurrentlyThisBrand = (isset($currentNode['is_brand']) && strtolower($currentNode['slug']) === $brandSlug)
                || (request()->string('brand')->toString() === $brandSlug);
                
            if ($isCurrentlyThisBrand) {
                // Toggle off
                if (!empty($currentNode['is_brand'])) {
                    return route('categories.show');
                }
                return route('categories.show', $activeCategory);
            } else {
                // Toggle on
                if ($activeCategory) {
                    return route('categories.show', ['path' => $activeCategory, 'brand' => $brandSlug]);
                }
                return route('categories.show', $brandSlug);
            }
        };
    @endphp
    <!-- Main page content container -->
    <div class="flex gap-6 relative">
        
        <!-- Floating category shortcuts left sidebar (exact Oneway style) -->
        <aside class="hidden lg:flex flex-col items-center gap-4 bg-white border border-gray-200 rounded-2xl py-6 px-3 sticky top-24 self-start shadow-sm shrink-0">
            <a href="{{ $getSidebarUrl('dien-thoai') }}" class="p-2.5 rounded-xl transition {{ $isCatActive('dien-thoai') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Điện thoại">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"></path></svg>
            </a>
            <a href="{{ $getSidebarUrl('laptop') }}" class="p-2.5 rounded-xl transition {{ $isCatActive('laptop') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Laptop">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></svg>
            </a>
            <a href="{{ $getSidebarUrl('may-cu') }}" class="p-2.5 rounded-xl transition {{ $isCatActive('may-cu') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Máy cũ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></svg>
            </a>
            <a href="{{ $getSidebarUrl('may-tinh-bang') }}" class="p-2.5 rounded-xl transition {{ $isCatActive('may-tinh-bang') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Máy tính bảng">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z"></path></svg>
            </a>
            <a href="{{ $getSidebarUrl('phu-kien') }}" class="p-2.5 rounded-xl transition {{ $isCatActive('phu-kien') ? 'bg-orange-50 text-orange-600' : 'text-gray-400 hover:bg-gray-50' }}" title="Phụ kiện">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
            </a>
        </aside>

        <!-- Right Side: Content Area -->
        <div class="flex-1 flex flex-col gap-6">
            
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-1.5 text-xs text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-orange-600 transition">Trang chủ</a>
                <span>/</span>
                <a href="{{ route('categories.show') }}" class="hover:text-orange-600 transition">Danh mục</a>
                @foreach ($currentNode['breadcrumbs'] as $breadcrumb)
                    <span>/</span>
                    <a href="{{ route('categories.show', $breadcrumb['slug']) }}" class="hover:text-orange-600 transition {{ $loop->last ? 'text-gray-800 font-semibold' : '' }}">
                        {{ $breadcrumb['label'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Page Title -->
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $currentNode['label'] }}</h1>

            <!-- Hero Banners Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Banner 1: Galaxy S26 Ultra -->
                <div class="relative rounded-2xl overflow-hidden shadow-sm h-48 md:h-56 flex items-center justify-between p-6 md:p-8" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                    <div class="z-10 flex flex-col items-start justify-center gap-2">
                        <span class="text-[10px] text-cyan-400 uppercase font-bold tracking-widest bg-cyan-400/10 px-2 py-0.5 rounded">Pre-order Now</span>
                        <h2 class="text-white font-extrabold text-xl md:text-2xl leading-tight">Galaxy S26 Ultra<br><span class="text-cyan-400">Galaxy AI</span></h2>
                        <a href="#" class="mt-2 bg-white text-gray-900 text-xs font-bold px-4 py-2 rounded-full hover:bg-gray-100 transition shadow-md">Đặt ngay</a>
                    </div>
                    <!-- Mock vector graphics representing high-end camera phone -->
                    <div class="absolute right-4 bottom-0 w-1/2 h-full opacity-60 flex items-end justify-center pointer-events-none select-none">
                        <div class="w-24 h-44 bg-slate-800 border-2 border-slate-700 rounded-t-2xl shadow-2xl relative flex flex-col items-center justify-start p-2">
                            <div class="w-8 h-1.5 bg-slate-900 rounded-full mb-4"></div>
                            <div class="w-12 h-12 rounded-full bg-slate-950/80 border border-slate-800 flex items-center justify-center mb-2">
                                <div class="w-6 h-6 rounded-full bg-cyan-500/25"></div>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-slate-950/80 border border-slate-800 flex items-center justify-center"></div>
                        </div>
                    </div>
                </div>

                <!-- Banner 2: Mua iPhone trả góp -->
                <div class="relative rounded-2xl overflow-hidden shadow-sm h-48 md:h-56 flex items-center justify-between p-6 md:p-8" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                    <div class="z-10 flex flex-col items-start justify-center gap-2">
                        <span class="text-[10px] text-white uppercase font-bold tracking-widest bg-white/20 px-2 py-0.5 rounded">StoreDP Special Offer</span>
                        <h2 class="text-white font-extrabold text-xl md:text-2xl leading-tight">MUA IPHONE<br>TRẢ GÓP 0% LÃI SUẤT</h2>
                        <span class="text-[11px] text-white/90 font-medium">Bảo hành 12 tháng chính hãng OneWay</span>
                    </div>
                    <!-- Graphic representing mock stack of premium colorful iPhones -->
                    <div class="absolute right-4 bottom-0 w-1/2 h-full opacity-70 flex items-end justify-center gap-2 pointer-events-none select-none">
                        <div class="w-16 h-40 bg-orange-200 rounded-t-xl transform rotate-6 translate-x-4 translate-y-4 shadow-lg"></div>
                        <div class="w-16 h-42 bg-blue-300 rounded-t-xl transform -rotate-3 translate-x-1 translate-y-2 shadow-lg"></div>
                        <div class="w-16 h-44 bg-green-200 rounded-t-xl transform -rotate-12 -translate-x-3 translate-y-6 shadow-lg"></div>
                    </div>
                </div>
            </div>

            <!-- "Chọn theo thương hiệu sản phẩm" -->
            <div class="flex flex-col gap-3 mt-4">
                <h2 class="text-base font-bold text-gray-900">Chọn theo thương hiệu sản phẩm</h2>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                    @foreach ($brands as $b)
                        @php
                            $isCurrentBrand = (isset($currentNode['is_brand']) && strtolower($currentNode['slug']) === $b->slug) 
                                || (request()->string('brand')->toString() === $b->slug);
                        @endphp
                        <a href="{{ $getBrandUrl($b->slug) }}" class="bg-white border rounded-xl p-3 flex flex-col items-center justify-center h-16 hover:border-orange-500 hover:shadow-sm transition-all duration-300 {{ $isCurrentBrand ? 'border-orange-500 ring-2 ring-orange-500/10' : 'border-gray-200' }}">
                            <span class="text-xs font-extrabold text-gray-800 tracking-tight">{{ $b->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- "Chọn sản phẩm theo tiêu chí" (Filters Row) -->
            <form action="{{ route('categories.show', $currentNode['slug']) }}" method="get" class="flex flex-wrap items-center justify-between gap-4 bg-white border border-gray-200 rounded-xl p-4 mt-2">
                <input type="hidden" name="q" value="{{ $query }}">
                
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide mr-1">Lọc theo:</span>
                    
                    <!-- Brand Select dropdown -->
                    <select name="brand" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 rounded-full px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none cursor-pointer hover:bg-gray-100 transition">
                        <option value="">Tất cả Hãng</option>
                        @foreach ($filters['brands'] as $brand)
                            <option value="{{ $brand['slug'] }}" {{ $selectedFilters['brand'] === $brand['slug'] ? 'selected' : '' }}>
                                {{ $brand['label'] }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Series Select dropdown -->
                    <select name="series" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 rounded-full px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none cursor-pointer hover:bg-gray-100 transition">
                        <option value="">Tất cả Dòng</option>
                        @foreach ($filters['series'] as $series)
                            <option value="{{ $series['slug'] }}" {{ $selectedFilters['series'] === $series['slug'] ? 'selected' : '' }}>
                                {{ $series['label'] }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Price range dropdown -->
                    <select name="price" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 rounded-full px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none cursor-pointer hover:bg-gray-100 transition">
                        <option value="">Mức giá</option>
                        @foreach ($filters['prices'] as $price)
                            <option value="{{ $price['slug'] }}" {{ $selectedFilters['price'] === $price['slug'] ? 'selected' : '' }}>
                                {{ $price['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort select dropdown -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500 font-semibold">Sắp xếp theo:</span>
                    <select name="sort" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 rounded-full px-4 py-1.5 text-xs font-semibold text-gray-700 outline-none cursor-pointer hover:bg-gray-100 transition">
                        <option value="">Mặc định</option>
                        <option value="price-asc" {{ $selectedFilters['sort'] === 'price-asc' ? 'selected' : '' }}>Giá thấp - Cao</option>
                        <option value="price-desc" {{ $selectedFilters['sort'] === 'price-desc' ? 'selected' : '' }}>Giá cao - Thấp</option>
                        <option value="name-asc" {{ $selectedFilters['sort'] === 'name-asc' ? 'selected' : '' }}>Tên A-Z</option>
                    </select>
                </div>
            </form>

            <!-- Product listing results grid -->
            <div class="flex flex-col gap-4 mt-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ count($products) }} sản phẩm phù hợp</span>
                    @if(request()->filled('brand') || request()->filled('series') || request()->filled('price') || request()->filled('sort'))
                        <a href="{{ route('categories.show', $currentNode['path']) }}" class="text-xs text-orange-600 font-bold hover:underline">Xóa tất cả bộ lọc</a>
                    @endif
                </div>

                <!-- 4 Columns Product Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
                    @forelse ($products as $product)
                        <x-frontend.product-card :product="$product" />
                    @empty
                        <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center flex flex-col items-center justify-center gap-3">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                            <h3 class="text-gray-800 font-bold text-sm">Không có sản phẩm nào phù hợp với bộ lọc</h3>
                            <p class="text-xs text-gray-400">Vui lòng chọn mức giá khác hoặc xóa bớt tiêu chí lọc.</p>
                            <a href="{{ route('categories.show', $currentNode['path']) }}" class="mt-2 bg-orange-600 text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-orange-700 transition shadow-sm">Đặt lại</a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
