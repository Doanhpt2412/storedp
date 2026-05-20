<x-layouts.app :title="$post->title . ' | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <!-- Thêm CSS cho nội dung CKEditor -->
    <style>
        .ck-content {
            font-size: 1.125rem;
            line-height: 1.75;
            color: #334155;
        }
        .ck-content h2 { font-size: 1.875rem; font-weight: 800; margin-top: 2em; margin-bottom: 0.75em; color: #0f172a; }
        .ck-content h3 { font-size: 1.5rem; font-weight: 700; margin-top: 1.5em; margin-bottom: 0.75em; color: #1e293b; }
        .ck-content p { margin-bottom: 1.25em; }
        .ck-content img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1.5em auto; display: block; }
        .ck-content ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1.25em; }
        .ck-content ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1.25em; }
        .ck-content a { color: #2563eb; text-decoration: underline; text-underline-offset: 2px; }
        .ck-content a:hover { color: #1d4ed8; }
        .ck-content blockquote { border-left: 4px solid #cbd5e1; padding-left: 1rem; font-style: italic; color: #475569; margin: 1.5em 0; }
        .ck-content strong { font-weight: 700; color: #0f172a; }
        .ck-content table { width: 100%; border-collapse: collapse; margin: 1.5em 0; }
        .ck-content table th, .ck-content table td { border: 1px solid #e2e8f0; padding: 0.75rem; text-align: left; }
        .ck-content table th { background-color: #f8fafc; font-weight: 600; }
    </style>

    <div class="max-w-[1240px] mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-gray-500 mb-6 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition-colors">Tin tức</a>
                    </div>
                </li>
                @if($post->category)
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-blue-600 transition-colors">{{ $post->category->name }}</a>
                    </div>
                </li>
                @endif
            </ol>
        </nav>

        <div class="grid lg:grid-cols-[1fr_320px] gap-10 items-start">
            <!-- Article Body -->
            <article class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 md:p-10">
                <header class="mb-8 pb-8 border-b border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <a href="{{ route('blog.category', $post->category?->slug ?? 'all') }}" class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-md hover:bg-blue-100 transition-colors">
                            {{ $post->category?->name ?? 'Tin tức' }}
                        </a>
                        <span class="text-sm text-gray-500 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            {{ $post->published_at ? $post->published_at->format('d/m/Y - H:i') : $post->created_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-6">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $post->author?->name ?? 'StoreDP Team' }}</p>
                                <p class="text-xs text-gray-500">{{ number_format($post->views) }} lượt xem</p>
                            </div>
                        </div>

                        <!-- Chia sẻ -->
                        <div class="flex gap-2">
                            <a href="#" class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="Chia sẻ Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                            </a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Đã copy link bài viết!');" class="w-9 h-9 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-gray-200 transition-colors" title="Copy Link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                            </button>
                        </div>
                    </div>
                </header>

                @if($post->excerpt)
                    <div class="text-lg font-medium text-slate-700 mb-8 leading-relaxed">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <div class="ck-content">
                    {!! $post->content !!}
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="space-y-8 sticky top-6">
                <!-- Chuyên mục -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                        Chuyên mục
                    </h3>
                    <ul class="space-y-3">
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('blog.category', $cat->slug) }}" class="flex items-center justify-between text-sm group">
                                    <span class="font-medium {{ $post->post_category_id == $cat->id ? 'text-blue-600' : 'text-gray-600 group-hover:text-blue-600' }} transition-colors">{{ $cat->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Bài viết liên quan -->
                @if($relatedPosts && $relatedPosts->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-orange-500 rounded-full"></span>
                        Bài viết liên quan
                    </h3>
                    <div class="space-y-5">
                        @foreach($relatedPosts as $related)
                            <article class="flex gap-4 group">
                                <a href="{{ route('blog.show', ['category_slug' => $related->category?->slug ?? 'all', 'post_slug' => $related->slug]) }}" class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                    @if($related->thumbnail)
                                        <img src="{{ $related->thumbnail }}" alt="{{ $related->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @endif
                                </a>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-900 leading-snug mb-1.5 group-hover:text-blue-600 transition-colors line-clamp-2">
                                        <a href="{{ route('blog.show', ['category_slug' => $related->category?->slug ?? 'all', 'post_slug' => $related->slug]) }}">{{ $related->title }}</a>
                                    </h4>
                                    <div class="flex items-center text-[10px] text-gray-500 gap-3">
                                        <span>{{ $related->published_at ? $related->published_at->format('d/m/Y') : $related->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>
</x-layouts.app>
