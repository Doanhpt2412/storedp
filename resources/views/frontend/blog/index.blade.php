<x-layouts.app :title="'Tin tức công nghệ & Thủ thuật | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <section class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ isset($category) ? $category->name : 'Tin tức & Công nghệ' }}</h1>
            <p class="text-gray-500 mt-2">{{ isset($category) ? $category->description : 'Cập nhật tin tức công nghệ mới nhất, đánh giá sản phẩm và thủ thuật hữu ích.' }}</p>
        </div>

        <div class="grid lg:grid-cols-[1fr_300px] gap-10 items-start">
            <!-- Cột trái: Danh sách bài viết -->
            <div class="space-y-8">
                @if(isset($featuredPost) && !isset($category) && request()->page <= 1)
                    <!-- Featured Post -->
                    <article class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm group hover:shadow-md transition-shadow">
                        <a href="{{ route('blog.show', ['category_slug' => $featuredPost->category?->slug ?? 'all', 'post_slug' => $featuredPost->slug]) }}" class="block relative aspect-[21/9] overflow-hidden bg-gray-100">
                            @if($featuredPost->thumbnail)
                                <img src="{{ $featuredPost->thumbnail }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">{{ $featuredPost->category?->name ?? 'Tin tức' }}</span>
                            </div>
                        </a>
                        <div class="p-6 md:p-8">
                            <h2 class="text-2xl font-bold text-gray-900 leading-tight mb-3 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('blog.show', ['category_slug' => $featuredPost->category?->slug ?? 'all', 'post_slug' => $featuredPost->slug]) }}">{{ $featuredPost->title }}</a>
                            </h2>
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $featuredPost->excerpt }}</p>
                            <div class="flex items-center text-xs text-gray-500 gap-4">
                                <span class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ $featuredPost->author?->name ?? 'Admin' }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                    {{ $featuredPost->published_at ? $featuredPost->published_at->format('d/m/Y') : $featuredPost->created_at->format('d/m/Y') }}
                                </span>
                                <span class="flex items-center gap-1.5 ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    {{ number_format($featuredPost->views) }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endif

                <div class="grid sm:grid-cols-2 gap-6">
                    @forelse($posts as $post)
                        @if(isset($featuredPost) && !isset($category) && request()->page <= 1 && $loop->first)
                            @continue
                        @endif
                        <article class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm group hover:shadow-md transition-shadow flex flex-col">
                            <a href="{{ route('blog.show', ['category_slug' => $post->category?->slug ?? 'all', 'post_slug' => $post->slug]) }}" class="block relative aspect-video overflow-hidden bg-gray-100 shrink-0">
                                @if($post->thumbnail)
                                    <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="bg-white/90 backdrop-blur-sm text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-md shadow-sm">{{ $post->category?->name ?? 'Tin tức' }}</span>
                                </div>
                            </a>
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900 leading-snug mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    <a href="{{ route('blog.show', ['category_slug' => $post->category?->slug ?? 'all', 'post_slug' => $post->slug]) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-1">{{ $post->excerpt }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 mt-auto pt-4 border-t border-gray-100">
                                    <span>{{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}</span>
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        {{ number_format($post->views) }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="sm:col-span-2 text-center py-12 bg-white rounded-2xl border border-gray-100 border-dashed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-300 mb-4"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Chưa có bài viết nào</h3>
                            <p class="text-gray-500">Nội dung đang được chúng tôi cập nhật.</p>
                        </div>
                    @endforelse
                </div>

                @if($posts->hasPages())
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

            <!-- Cột phải: Sidebar -->
            <aside class="space-y-8 sticky top-6">
                <!-- Chuyên mục -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                        Chuyên mục
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('blog.index') }}" class="flex items-center justify-between text-sm group">
                                <span class="font-medium {{ !isset($category) ? 'text-blue-600' : 'text-gray-600 group-hover:text-blue-600' }} transition-colors">Tất cả bài viết</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('blog.category', $cat->slug) }}" class="flex items-center justify-between text-sm group">
                                    <span class="font-medium {{ isset($category) && $category->id == $cat->id ? 'text-blue-600' : 'text-gray-600 group-hover:text-blue-600' }} transition-colors">{{ $cat->name }}</span>
                                    <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">{{ $cat->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Bài viết đọc nhiều -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-orange-500 rounded-full"></span>
                        Đọc nhiều nhất
                    </h3>
                    <div class="space-y-5">
                        @foreach($popularPosts as $popular)
                            <article class="flex gap-4 group">
                                <a href="{{ route('blog.show', ['category_slug' => $popular->category?->slug ?? 'all', 'post_slug' => $popular->slug]) }}" class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                    @if($popular->thumbnail)
                                        <img src="{{ $popular->thumbnail }}" alt="{{ $popular->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @endif
                                </a>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-900 leading-snug mb-1.5 group-hover:text-blue-600 transition-colors line-clamp-2">
                                        <a href="{{ route('blog.show', ['category_slug' => $popular->category?->slug ?? 'all', 'post_slug' => $popular->slug]) }}">{{ $popular->title }}</a>
                                    </h4>
                                    <div class="flex items-center text-[10px] text-gray-500 gap-3">
                                        <span>{{ $popular->published_at ? $popular->published_at->format('d/m/Y') : $popular->created_at->format('d/m/Y') }}</span>
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                            {{ number_format($popular->views) }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
