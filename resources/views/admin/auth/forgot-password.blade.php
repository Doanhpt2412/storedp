<x-layouts.admin-auth title="Quên mật khẩu">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
        <div class="text-center py-8 px-6 bg-slate-50 border-b border-slate-100">
            <a href="{{ route('login') }}" class="inline-block mb-4 text-3xl font-extrabold text-slate-900 tracking-tight">
                <span>Store</span><span class="text-blue-600">Admin</span>
            </a>
            <h1 class="text-xl font-bold text-slate-800">Khôi phục mật khẩu</h1>
            <p class="text-sm text-slate-500 mt-2">Nhập email tài khoản để nhận link đặt lại mật khẩu.</p>
        </div>

        <div class="p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Địa chỉ Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm"
                        placeholder="admin@storedp.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors shadow-md shadow-blue-500/30 flex justify-center items-center gap-2"
                >
                    Gửi link khôi phục
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline font-medium">Quay lại đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin-auth>
