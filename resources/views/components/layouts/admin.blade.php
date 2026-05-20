<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Dashboard' }} | {{ config('app.name', 'StoreDP') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc; /* Slate 50 */
            color: #0f172a; /* Slate 900 */
        }
        
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb {
            background: #94a3b8;
        }
    </style>
</head>
<body class="antialiased text-slate-800 bg-slate-50 flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex flex-col transition-all duration-300 z-20">
        <!-- Sidebar Header / Logo -->
        <div class="h-16 flex items-center justify-center border-b border-slate-800/60 px-4">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-extrabold text-white tracking-tight flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <span class="text-lg text-white">S</span>
                </div>
                <span>Store<span class="text-blue-500">Admin</span></span>
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <div class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3 space-y-1">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-2">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="font-medium text-sm">Đơn hàng</span>
                @php $pendingCount = \App\Models\Order::where('order_status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto bg-red-500 text-white py-0.5 px-2 rounded-full text-[10px] font-bold shadow-sm shadow-red-500/50">{{ $pendingCount }}</span>
                @endif
            </a>

            @php
                $isProductActive = request()->routeIs('admin.product-categories.*') || request()->routeIs('admin.product-brands.*') || request()->routeIs('admin.products.*');
            @endphp
            
            <details class="group [&_summary::-webkit-details-marker]:hidden" {{ $isProductActive ? 'open' : '' }}>
                <summary class="flex items-center justify-between px-3 py-2.5 rounded-lg {{ $isProductActive ? 'text-white bg-slate-800/80 font-medium' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all cursor-pointer list-none select-none">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                        <span class="font-medium text-sm">Quản lý sản phẩm</span>
                    </div>
                    <span class="transition-transform duration-300 group-open:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </span>
                </summary>
                <div class="mt-1 pl-4 space-y-1">
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.products.*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.products.*') ? 'bg-white' : 'bg-slate-500' }}"></span>
                        Danh sách sản phẩm
                    </a>
                    @can('manage-products')
                    <a href="{{ route('admin.product-categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.product-categories.*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.product-categories.*') ? 'bg-white' : 'bg-slate-500' }}"></span>
                        Danh mục sản phẩm
                    </a>
                    <a href="{{ route('admin.product-brands.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.product-brands.*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.product-brands.*') ? 'bg-white' : 'bg-slate-500' }}"></span>
                        Hãng sản xuất
                    </a>
                    @endcan
                </div>
            </details>

            @php
                $isPostActive = request()->routeIs('admin.post-categories.*') || request()->routeIs('admin.posts.*');
            @endphp
            <details class="group [&_summary::-webkit-details-marker]:hidden" {{ $isPostActive ? 'open' : '' }}>
                <summary class="flex items-center justify-between px-3 py-2.5 rounded-lg {{ $isPostActive ? 'text-white bg-slate-800/80 font-medium' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all cursor-pointer list-none select-none">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                        <span class="font-medium text-sm">Tin tức & Bài viết</span>
                    </div>
                    <span class="transition-transform duration-300 group-open:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </span>
                </summary>
                <div class="mt-1 pl-4 space-y-1">
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.posts.*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.posts.*') ? 'bg-white' : 'bg-slate-500' }}"></span>
                        Tất cả bài viết
                    </a>
                    <a href="{{ route('admin.post-categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.post-categories.*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.post-categories.*') ? 'bg-white' : 'bg-slate-500' }}"></span>
                        Chuyên mục
                    </a>
                </div>
            </details>

            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="font-medium text-sm">Khách hàng</span>
            </a>

            @can('manage-users')
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">Quản trị viên</p>
            
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.users.*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }} transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="font-medium text-sm">Quản lý Tài khoản</span>
            </a>
            @endcan

            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">Settings</p>

            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                <span class="font-medium text-sm">Cài đặt hệ thống</span>
            </a>
        </div>

        <!-- Sidebar Footer / Logout -->
        <div class="p-4 border-t border-slate-800/60">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span class="font-medium text-sm">Đăng xuất</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-10">
            <!-- Left: Mobile Menu Toggle & Search -->
            <div class="flex items-center gap-4 flex-1">
                <button class="md:hidden text-slate-500 hover:text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                </button>
                
                <div class="hidden sm:flex items-center bg-slate-100 rounded-lg px-3 py-2 w-64 border border-slate-200/60 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" placeholder="Tìm kiếm..." class="bg-transparent border-none outline-none w-full ml-2 text-sm text-slate-700 placeholder-slate-400">
                </div>
            </div>

            <!-- Right: Actions & Profile -->
            <div class="flex items-center gap-3 sm:gap-5">
                <!-- Notifications -->
                <button class="relative text-slate-500 hover:text-slate-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>
                
                <div class="w-px h-6 bg-slate-200 mx-1"></div>

                <!-- User Profile -->
                <button class="flex items-center gap-2.5 text-left focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm border border-blue-200">
                        {{ substr(Auth::user()->name ?? 'Admin', 0, 1) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-semibold text-slate-700 leading-none">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 hidden sm:block"><path d="m6 9 6 6 6-6"/></svg>
                </button>
            </div>
        </header>

        <!-- Main Content (Scrollable) -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
