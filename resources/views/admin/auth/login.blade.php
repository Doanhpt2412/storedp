<x-layouts.admin-auth title="Đăng nhập Quản trị">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
        <!-- Header -->
        <div class="text-center py-8 px-6 bg-slate-50 border-b border-slate-100">
            <a href="#" class="inline-block mb-4 text-3xl font-extrabold text-slate-900 tracking-tight">
                <span>Store</span><span class="text-blue-600">Admin</span>
            </a>
            <h1 class="text-xl font-bold text-slate-800">Chào mừng trở lại!</h1>
            <p class="text-sm text-slate-500 mt-2">Vui lòng đăng nhập để truy cập trang quản trị.</p>
            @if (session('login_error'))
                <p class="mt-3 text-sm text-rose-600 font-medium">{{ session('login_error') }}</p>
            @endif
        </div>

        <!-- Form -->
        <div class="p-6 sm:p-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-5" novalidate>
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Địa chỉ Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full px-4 py-2.5 rounded-lg border text-sm transition-all outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('email') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @else border-slate-300 @enderror"
                        placeholder="admin@storedp.com"
                        value="{{ old('email') }}"
                        autofocus
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Mật khẩu</label>
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline font-medium">Quên mật khẩu?</a>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-4 py-2.5 rounded-lg border text-sm transition-all outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('password') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @else border-slate-300 @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                    >
                    <label for="remember" class="ml-2 text-sm text-slate-600 cursor-pointer">Ghi nhớ đăng nhập</label>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors shadow-md shadow-blue-500/30 flex justify-center items-center gap-2 mt-2"
                >
                    Đăng nhập
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-slate-50 py-4 text-center border-t border-slate-100">
            <p class="text-xs text-slate-500">© 2026 StoreDP. All rights reserved.</p>
        </div>
    </div>
</x-layouts.admin-auth>
