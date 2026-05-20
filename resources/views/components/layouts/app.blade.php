@props([
    'title' => config('app.name'),
    'navCategories' => [],
])

@php
    $cartCount = app(\App\Support\CartManager::class)->count();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <header class="w-full z-50">
            <div class="w-full text-white py-3 shadow-md" style="background: linear-gradient(to right, #f95f06, #ff8400);">
                <div class="max-w-[1240px] mx-auto px-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="flex items-center gap-1">
                            <span class="font-extrabold text-2xl tracking-tighter text-white">Store<span class="text-yellow-300">DP</span></span>
                        </a>
                        <span class="hidden md:inline-block text-[10px] uppercase font-bold bg-white/20 px-2 py-0.5 rounded text-white/90">Tech Store</span>
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
                            <span>Tra cứu</span>
                        </a>
                        <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 hover:text-yellow-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                            <span>Đăng nhập</span>
                        </a>
                        <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-0.5 hover:text-yellow-200 transition relative">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                            <span>Giỏ hàng</span>
                            <span id="cart-count-badge" class="absolute -top-1.5 -right-2 bg-yellow-300 text-gray-900 font-bold text-[9px] min-w-4 h-4 px-1 rounded-full flex items-center justify-center border border-white">{{ $cartCount }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full bg-white border-b border-gray-200 py-2.5">
                <div class="max-w-[1240px] mx-auto px-4 flex items-center gap-6 overflow-x-auto text-sm font-medium text-gray-700">
                    <a href="{{ route('categories.show') }}" class="flex items-center gap-1.5 whitespace-nowrap py-1 hover:text-orange-600 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                        <span>Tất cả danh mục</span>
                    </a>

                    <a href="{{ route('blog.index') }}" class="whitespace-nowrap py-1 font-bold text-orange-600 hover:text-orange-700 transition shrink-0 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                        Tin tức Công nghệ
                    </a>

                    @foreach ($navCategories as $category)
                        @php
                            $label = is_array($category) ? ($category['name'] ?? $category['label'] ?? null) : ($category->name ?? null);
                            $slug = is_array($category) ? ($category['slug'] ?? null) : ($category->slug ?? null);
                        @endphp
                        @if ($label && $slug)
                            <a href="{{ route('categories.show', $slug) }}" class="whitespace-nowrap py-1 hover:text-orange-600 transition shrink-0">
                                {{ $label }}
                            </a>
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

        <!-- Toast Notification Container & Global Session Flash Handlers -->
        <div id="toast-container" class="toast-container"></div>

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
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">StoreDP</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Giới thiệu</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Hệ thống cửa hàng</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Liên hệ</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Tuyển dụng</a></li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Sản phẩm</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Điện thoại</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Macbook</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Máy tính bảng</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Đồng hồ thông minh</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Phụ kiện</a></li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Chính sách</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Mua hàng</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Bảo hành</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Vận chuyển</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Bảo mật</a></li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Hỗ trợ</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Hướng dẫn mua online</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Phương thức thanh toán</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Câu hỏi thường gặp</a></li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4 col-span-2 md:col-span-1">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Tổng đài hỗ trợ</h3>
                        <ul class="flex flex-col gap-2 text-xs text-gray-600">
                            <li>Tư vấn mua hàng: <a href="tel:02466819779" class="font-bold text-gray-900 hover:text-orange-600 transition">0246 6819 779</a></li>
                            <li>Bảo hành: <a href="tel:02466819779" class="font-bold text-gray-900 hover:text-orange-600 transition">0246 6819 779</a></li>
                            <li>Kỹ thuật: <a href="tel:02466819779" class="font-bold text-gray-900 hover:text-orange-600 transition">0246 6819 779</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-200 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4 text-[11px] text-gray-500">
                    <p>© 2026 StoreDP. Tất cả các quyền được bảo lưu.</p>
                    <p>388 Cầu Giấy - P. Dịch Vọng - Q. Cầu Giấy - TP. Hà Nội</p>
                </div>
            </div>
        </footer>
    </body>
</html>
