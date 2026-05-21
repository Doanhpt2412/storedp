@props([
    'title' => config('app.name'),
    'navCategories' => [],
])

@php
    $cartCount = app(\App\Support\CartManager::class)->count();
    $siteSettings = app(\App\Support\SiteSettings::class);
    $activePostCategorySlugs = [];
    $hasActivePostCategories = false;

    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('post_categories')) {
            $activePostCategorySlugs = \App\Models\PostCategory::query()
                ->where('is_active', true)
                ->pluck('slug')
                ->all();
            $hasActivePostCategories = ! empty($activePostCategorySlugs);
        }
    } catch (\Throwable $e) {
        $activePostCategorySlugs = [];
        $hasActivePostCategories = false;
    }
    $site = array_merge([
        'site_name' => 'Tech One',
        'site_tagline' => 'Tech One',
        'logo_alt' => 'Tech One',
        'logo_url' => null,
        'favicon_url' => null,
    ], $siteSettings->group('site'));
    $seo = array_merge([
        'meta_title' => $title ?: 'Tech One',
        'meta_description' => null,
        'meta_keywords' => null,
        'og_image_url' => null,
    ], $siteSettings->group('seo'));
    $contact = array_merge([
        'hotline' => null,
        'email' => null,
        'address' => null,
        'working_hours' => null,
    ], $siteSettings->group('contact'));
    $headerMenu = $siteSettings->group('header_menu', []);
    $headerMenu = collect($headerMenu)
        ->filter(function (array $item) use ($activePostCategorySlugs, $hasActivePostCategories): bool {
            $url = trim((string) ($item['url'] ?? ''));

            if ($url === '' || ! filled($item['label'] ?? null)) {
                return false;
            }

            if ($url === '/tin-tuc') {
                return $hasActivePostCategories;
            }

            if (str_starts_with($url, '/tin-tuc/')) {
                $slug = trim(\Illuminate\Support\Str::after($url, '/tin-tuc/'), '/');
                $firstSegment = strtok($slug, '/');

                if ($firstSegment) {
                    return in_array($firstSegment, $activePostCategorySlugs, true);
                }
            }

            return true;
        })
        ->values()
        ->all();
    $footer = array_merge([
        'about_title' => 'Tech One',
        'about_links' => [],
        'policy_title' => 'Chính sách',
        'policy_links' => [],
        'support_title' => 'Hỗ trợ',
        'support_links' => [],
        'copyright_text' => null,
    ], $siteSettings->group('footer'));
    $pageTitle = trim($title ?: ($seo['meta_title'] ?? $site['site_name']));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $seo['meta_description'] ?: $site['site_tagline'] }}">
        @if (!empty($seo['meta_keywords']))
            <meta name="keywords" content="{{ $seo['meta_keywords'] }}">
        @endif
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $seo['meta_description'] ?: $site['site_tagline'] }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        @if (!empty($seo['og_image_url']))
            <meta property="og:image" content="{{ $seo['og_image_url'] }}">
        @endif
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if (!empty($site['favicon_url']))
            <link rel="icon" href="{{ $site['favicon_url'] }}">
        @endif
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                background-color: #f4f6fb;
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col">
        <header class="site-shell-header w-full z-50" data-site-header>
            <div class="site-shell-header__top w-full text-white py-3 shadow-md" style="background: linear-gradient(to right, #f95f06, #ff8400);">
                <div class="max-w-[1240px] mx-auto px-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            @if (!empty($site['logo_url']))
                                <img src="{{ $site['logo_url'] }}" alt="{{ $site['logo_alt'] ?: $site['site_name'] }}" class="h-10 w-auto">
                            @else
                                <span class="font-extrabold text-2xl tracking-tighter text-white">{{ $site['site_name'] }}</span>
                            @endif
                        </a>
                        @if (!empty($site['site_tagline']))
                            <span class="hidden md:inline-block text-[10px] uppercase font-bold bg-white/20 px-2 py-0.5 rounded text-white/90">{{ $site['site_tagline'] }}</span>
                        @endif
                    </div>

                    <form class="flex-1 max-w-[460px] relative" action="{{ route('search') }}" method="get">
                        <input
                            type="search"
                            name="s"
                            value="{{ request()->query('s') }}"
                            placeholder="Bạn cần tìm gì..."
                            class="w-full bg-white text-gray-800 placeholder-gray-400 rounded-full py-2 px-4 pr-10 outline-none text-sm shadow-inner focus:ring-2 focus:ring-yellow-300"
                        >
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>

                    <div class="flex items-center gap-3 xl:gap-5 text-xs font-semibold">
                        <a href="{{ route('checkout.search') }}" class="flex flex-col items-center gap-0.5 hover:text-yellow-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3"/></svg>
                            <span>Tra cứu đơn hàng</span>
                        </a>
                        <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-0.5 hover:text-yellow-200 transition relative">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                            <span>Giỏ hàng</span>
                            <span id="cart-count-badge" class="absolute -top-1.5 -right-2 bg-yellow-300 text-gray-900 font-bold text-[9px] min-w-4 h-4 px-1 rounded-full flex items-center justify-center border border-white">{{ $cartCount }}</span>
                        </a>
                        <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 hover:text-yellow-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                            <span>Đăng nhập</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="site-shell-header__nav w-full bg-white border-b border-gray-200 py-2.5">
                <div class="max-w-[1240px] mx-auto px-4 flex items-center gap-6 overflow-x-auto text-sm font-medium text-gray-700">
                    <a href="{{ route('categories.show') }}" class="flex items-center gap-1.5 whitespace-nowrap py-1 hover:text-orange-600 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                        <span>Tất cả sản phẩm</span>
                    </a>

                    @foreach ($headerMenu as $item)
                        @if (!empty($item['label']) && !empty($item['url']))
                            <a href="{{ $item['url'] }}" class="whitespace-nowrap py-1 font-bold text-orange-600 hover:text-orange-700 transition shrink-0">{{ $item['label'] }}</a>
                        @endif
                    @endforeach

                    @foreach ($navCategories as $category)
                        @php
                            $label = is_array($category) ? ($category['name'] ?? $category['label'] ?? null) : ($category->name ?? null);
                            $slug = is_array($category) ? ($category['slug'] ?? null) : ($category->slug ?? null);
                        @endphp
                        @if ($label && $slug)
                            <a href="{{ route('categories.show', $slug) }}" class="whitespace-nowrap py-1 hover:text-orange-600 transition shrink-0">{{ $label }}</a>
                        @elseif (is_string($category))
                            <span class="whitespace-nowrap py-1 shrink-0">{{ $category }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </header>

        <main class="flex-1 max-w-[1240px] w-full mx-auto px-4 py-6">
            {{ $slot }}
        </main>

        <div id="toast-container" class="toast-container"></div>
        <button
            type="button"
            class="scroll-to-top"
            id="scroll-to-top"
            data-scroll-top
            aria-label="Lên đầu trang"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
            </svg>
        </button>

        @if (session('cart_success') || session('success'))
            <div class="hidden" data-flash-message data-type="success" data-message="{{ session('cart_success') ?: session('success') }}"></div>
        @endif
        @if (session('error'))
            <div class="hidden" data-flash-message data-type="error" data-message="{{ session('error') }}"></div>
        @endif
        @if (session('status'))
            <div class="hidden" data-flash-message data-type="info" data-message="{{ session('status') }}"></div>
        @endif

        <footer class="w-full bg-white border-t border-gray-200 mt-16 pt-12 pb-8">
            <div class="max-w-[1240px] mx-auto px-4">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">{{ $footer['about_title'] }}</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            @forelse ($footer['about_links'] as $item)
                                <li><a href="{{ $item['url'] }}" class="hover:text-orange-600 transition">{{ $item['label'] }}</a></li>
                            @empty
                                <li class="text-gray-400">Chưa cấu hình</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">{{ $footer['policy_title'] }}</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            @forelse ($footer['policy_links'] as $item)
                                <li><a href="{{ $item['url'] }}" class="hover:text-orange-600 transition">{{ $item['label'] }}</a></li>
                            @empty
                                <li class="text-gray-400">Chưa cấu hình</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">{{ $footer['support_title'] }}</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            @forelse ($footer['support_links'] as $item)
                                <li><a href="{{ $item['url'] }}" class="hover:text-orange-600 transition">{{ $item['label'] }}</a></li>
                            @empty
                                <li class="text-gray-400">Chưa cấu hình</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Thông tin liên hệ</h3>
                        <ul class="flex flex-col gap-2 text-xs text-gray-600">
                            @if (!empty($contact['hotline']))
                                <li>Hotline: <a href="tel:{{ preg_replace('/\D+/', '', $contact['hotline']) }}" class="font-bold text-gray-900 hover:text-orange-600 transition">{{ $contact['hotline'] }}</a></li>
                            @endif
                            @if (!empty($contact['email']))
                                <li>Email: <a href="mailto:{{ $contact['email'] }}" class="font-bold text-gray-900 hover:text-orange-600 transition">{{ $contact['email'] }}</a></li>
                            @endif
                            @if (!empty($contact['working_hours']))
                                <li>Giờ làm việc: <span class="font-bold text-gray-900">{{ $contact['working_hours'] }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-200 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4 text-[11px] text-gray-500">
                    <p>{{ $footer['copyright_text'] ?: ('© '.date('Y').' '.$site['site_name']) }}</p>
                    <p>{{ $contact['address'] }}</p>
                </div>
            </div>
        </footer>
    </body>
</html>
