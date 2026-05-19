<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                background-color: #f4f6fb;
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col justify-between">
        
        <!-- Oneway-style Header -->
        <header class="w-full z-50">
            <!-- Orange/Red Gradient Header Bar -->
            <div style="background: linear-gradient(to right, #f95f06, #ff8400);" class="w-full text-white py-3 shadow-md">
                <div class="max-w-[1240px] mx-auto px-4 flex items-center justify-between gap-4">
                    <!-- Logo -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="flex items-center gap-1">
                            <span class="font-extrabold text-2xl tracking-tighter text-white">Store<span class="text-yellow-300">DP</span></span>
                        </a>
                        <span class="hidden md:inline-block text-[10px] uppercase font-bold bg-white/20 px-2 py-0.5 rounded text-white/90">Authorized Reseller</span>
                    </div>

                    <!-- Location Selector -->
                    <div class="hidden lg:flex items-center gap-1 border border-white/30 bg-white/10 px-3 py-1.5 rounded-lg text-xs cursor-pointer hover:bg-white/20 transition">
                        <span>Xem giá tại:</span>
                        <span class="font-bold">Hồ Chí Minh</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                    </div>

                    <!-- Hotline -->
                    <div class="hidden xl:flex items-center gap-1.5 text-xs">
                        <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                        <span>Gọi tư vấn:</span>
                        <a href="tel:02466819779" class="font-bold text-yellow-300 hover:underline">02466819779</a>
                    </div>

                    <!-- Search Input -->
                    <form class="flex-1 max-w-[450px] relative" action="{{ route('search') }}" method="get">
                        <input type="search" name="s" value="{{ request()->query('s') }}" placeholder="Bạn cần tìm gì..." class="w-full bg-white text-gray-800 placeholder-gray-400 rounded-full py-2 px-4 pr-10 outline-none text-sm shadow-inner transition focus:ring-2 focus:ring-yellow-300">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>

                    <!-- Header Actions -->
                    <div class="flex items-center gap-3 xl:gap-5 text-xs font-semibold">
                        <a href="#" class="hidden md:flex flex-col items-center gap-0.5 hover:text-yellow-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>
                            <span>Cửa hàng</span>
                        </a>
                        <a href="#" class="hidden md:flex flex-col items-center gap-0.5 hover:text-yellow-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Tra cứu đơn</span>
                        </a>
                        <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 hover:text-yellow-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                            <span>Đăng nhập</span>
                        </a>
                        <!-- Cart with Badge bubble -->
                        <a href="#" class="flex flex-col items-center gap-0.5 hover:text-yellow-200 transition relative">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                            <span>Giỏ hàng</span>
                            <span class="absolute -top-1.5 -right-2 bg-yellow-300 text-gray-900 font-bold text-[9px] w-4 h-4 rounded-full flex items-center justify-center border border-white">0</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories White Nav Bar -->
            <div class="w-full bg-white border-b border-gray-200 py-2.5">
                <div class="max-w-[1240px] mx-auto px-4 flex items-center justify-between overflow-x-auto scrollbar-none gap-6 text-sm font-medium text-gray-700">
                    <!-- Menu hamburger -->
                    <div class="flex items-center gap-1.5 cursor-pointer text-gray-800 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                    </div>

                    <!-- Category Items with dynamic/static routes -->
                    @php
                        $icons = [
                            'dien-thoai' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"></svg>',
                            'laptop' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></svg>',
                            'may-cu' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></svg>',
                            'may-tinh-bang' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z"></path></svg>',
                            'dong-ho-thong-minh' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>',
                            'nha-thong-minh' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>',
                            'phu-kien' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>',
                            'am-thanh' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z"></path></svg>',
                            'khuyen-mai' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 003.181 0l5.184-5.183a2.25 2.25 0 000-3.181l-9.582-9.584A2.25 2.25 0 009.568 3z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"></path></svg>',
                        ];
                    @endphp

                    @if(isset($navCategories) && count($navCategories) > 0)
                        @foreach ($navCategories as $category)
                            @php
                                $slug = $category->slug ?? '';
                                $iconHtml = $icons[$slug] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 6h18"></path></svg>';
                                $isActive = request()->is('catalog/' . $slug) || request()->is('catalog/' . $slug . '/*');
                            @endphp
                            <a href="{{ route('categories.show', $slug) }}" class="flex items-center gap-1.5 whitespace-nowrap py-1 hover:text-orange-600 transition shrink-0 {{ $isActive ? 'text-orange-600 font-bold border-b-2 border-orange-600' : 'text-gray-700' }}">
                                {!! $iconHtml !!}
                                <span>{{ $category->name }}</span>
                            </a>
                        @endforeach
                    @else
                        <!-- Fallback static items -->
                        <a href="#" class="flex items-center gap-1.5 py-1 text-orange-600 font-bold border-b-2 border-orange-600 shrink-0">
                            {!! $icons['dien-thoai'] !!}
                            <span>Điện thoại</span>
                        </a>
                        <a href="#" class="flex items-center gap-1.5 py-1 hover:text-orange-600 transition shrink-0">
                            {!! $icons['laptop'] !!}
                            <span>Laptop</span>
                        </a>
                        <a href="#" class="flex items-center gap-1.5 py-1 hover:text-orange-600 transition shrink-0">
                            {!! $icons['may-cu'] !!}
                            <span>Máy cũ</span>
                        </a>
                        <a href="#" class="flex items-center gap-1.5 py-1 hover:text-orange-600 transition shrink-0">
                            {!! $icons['may-tinh-bang'] !!}
                            <span>Máy tính bảng</span>
                        </a>
                        <a href="#" class="flex items-center gap-1.5 py-1 hover:text-orange-600 transition shrink-0">
                            {!! $icons['phu-kien'] !!}
                            <span>Phụ kiện</span>
                        </a>
                    @endif
                    
                    <a href="#" class="flex items-center gap-1.5 py-1 hover:text-orange-600 transition shrink-0 text-red-600">
                        {!! $icons['khuyen-mai'] !!}
                        <span>Deal hời</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main slot content container -->
        <main class="flex-1 max-w-[1240px] w-full mx-auto px-4 py-6">
            {{ $slot }}
        </main>

        <!-- Premium Oneway-style Footer -->
        <footer class="w-full bg-white border-t border-gray-200 mt-16 pt-12 pb-8">
            <div class="max-w-[1240px] mx-auto px-4">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    <!-- Column 1: Intro -->
                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Oneway Mobile</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Giới thiệu công ty</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Hệ thống cửa hàng</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Liên hệ với chúng tôi</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Tuyển dụng</a></li>
                        </ul>
                    </div>

                    <!-- Column 2: Products -->
                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Sản phẩm</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Điện thoại</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Macbook</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Máy tính bảng</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Đồng hồ thông minh</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Nhà thông minh</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Policies -->
                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Chính sách</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Chính sách mua hàng</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Chính sách bảo hành</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Chính sách vận chuyển</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Chính sách bảo mật</a></li>
                        </ul>
                    </div>

                    <!-- Column 4: Help -->
                    <div class="flex flex-col gap-4">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Hỗ trợ khách hàng</h3>
                        <ul class="flex flex-col gap-2.5 text-xs text-gray-600">
                            <li><a href="#" class="hover:text-orange-600 transition">Giải đáp mua hàng Online</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Phương thức thanh toán</a></li>
                            <li><a href="#" class="hover:text-orange-600 transition">Câu hỏi thường gặp</a></li>
                        </ul>
                    </div>

                    <!-- Column 5: Hotline Support -->
                    <div class="flex flex-col gap-4 col-span-2 md:col-span-1">
                        <h3 class="text-gray-900 font-bold text-sm uppercase tracking-wider">Tổng đài hỗ trợ (8h30 - 22h)</h3>
                        <ul class="flex flex-col gap-2 text-xs text-gray-600">
                            <li>Gọi mua hàng: <a href="tel:02466819779" class="font-bold text-gray-900 hover:text-orange-600 transition">0246 6819 779</a></li>
                            <li>Gọi bảo hành: <a href="tel:02466819779" class="font-bold text-gray-900 hover:text-orange-600 transition">0246 6819 779</a></li>
                            <li>Hỗ trợ kỹ thuật: <a href="tel:02466819779" class="font-bold text-gray-900 hover:text-orange-600 transition">0246 6819 779</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Footer Bottom Copyright info bar -->
                <div class="mt-12 pt-8 border-t border-gray-200 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4 text-[11px] text-gray-500">
                    <p>© 2026 StoreDP. Tất cả các quyền được bảo lưu.</p>
                    <p>Địa chỉ: 388 Cầu Giấy - P. Dịch Vọng - Q. Cầu Giấy - TP. Hà Nội | Mã số doanh nghiệp: 0123456789</p>
                </div>
            </div>
        </footer>
    </body>
</html>
