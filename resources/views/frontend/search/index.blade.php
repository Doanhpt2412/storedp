<x-layouts.app :title="'Tìm kiếm: ' . ($query ?: 'Sản phẩm') . ' | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <div class="flex flex-col gap-6">
        <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <form action="{{ route('search') }}" method="get" class="flex flex-col gap-3 sm:flex-row">
                <input
                    type="search"
                    name="s"
                    value="{{ $query }}"
                    placeholder="Bạn cần tìm gì..."
                    class="min-h-12 flex-1 rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm font-medium text-gray-800 outline-none transition focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-500/10"
                >
                <button type="submit" class="min-h-12 rounded-xl bg-orange-600 px-6 text-sm font-bold text-white transition hover:bg-orange-700">
                    Tìm kiếm
                </button>
            </form>

            <div class="mt-5 flex flex-col gap-1">
                <h1 class="text-2xl font-extrabold text-gray-900">
                    @if($query !== '')
                        Kết quả tìm kiếm "{{ $query }}"
                    @else
                        Tìm kiếm sản phẩm
                    @endif
                </h1>
                <p class="text-sm text-gray-500">
                    @if($query !== '')
                        Tìm thấy {{ $totalResults }} kết quả phù hợp.
                    @else
                        Nhập tên sản phẩm, hãng hoặc danh mục để bắt đầu tìm kiếm.
                    @endif
                </p>
            </div>
        </section>

        @if($query !== '' && count($categories) > 0)
            <section class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-gray-900">Danh mục liên quan</h2>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ count($categories) }} danh mục</span>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category['path']) }}" class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-orange-500 hover:shadow-md">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-sm font-extrabold text-orange-600">
                                    {{ str_pad((string) $category['level'], 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <div class="min-w-0">
                                    <strong class="block truncate text-sm text-gray-900">{{ $category['name'] }}</strong>
                                    <span class="mt-0.5 block truncate font-mono text-xs text-gray-400">{{ $category['path'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if($query !== '' && count($posts) > 0)
            <section class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-gray-900">Bài viết liên quan</h2>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ count($posts) }} bài viết</span>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach($posts as $post)
                        <a href="{{ route('blog.show', ['category_slug' => $post['category_slug'] ?? 'tin-tuc', 'post_slug' => $post['slug']]) }}" class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-orange-500 hover:shadow-md">
                            <div class="space-y-3">
                                <h3 class="text-base font-bold text-gray-900">{{ $post['title'] }}</h3>
                                <p class="text-sm text-gray-500 line-clamp-3">{{ $post['excerpt'] }}</p>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400">
                                    <span>{{ $post['category_name'] ?? 'Tin tức' }}</span>
                                    @if($post['published_at'])
                                        <span>&bull;</span>
                                        <span>{{ $post['published_at'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if($query !== '' && count($products) > 0)
            <section class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-gray-900">Sản phẩm phù hợp</h2>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ count($products) }} sản phẩm</span>
                </div>

                <form action="{{ route('search') }}" method="get" class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-gray-200 bg-white p-4">
                    <input type="hidden" name="s" value="{{ $query }}">

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

                @if(request()->filled('brand') || request()->filled('series') || request()->filled('price') || request()->filled('sort'))
                    <div class="flex items-center justify-end">
                        <a href="{{ route('search', ['s' => $query]) }}" class="text-xs font-bold text-orange-600 hover:underline">Xóa tất cả bộ lọc</a>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach($products as $product)
                        <x-frontend.product-card :product="$product" />
                    @endforeach
                </div>
            </section>
        @endif

        @if($query !== '' && count($categories) === 0 && count($posts) === 0 && count($products) === 0)
            <section class="rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-sm">
                <h3 class="text-base font-bold text-gray-900">Không tìm thấy kết quả phù hợp</h3>
                <p class="mt-2 text-sm text-gray-500">Thử tìm bằng từ khóa khác hoặc kiểm tra lại tên sản phẩm, hãng hoặc danh mục.</p>
            </section>
        @endif
    </div>
</x-layouts.app>
