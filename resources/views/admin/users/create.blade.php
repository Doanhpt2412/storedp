<x-layouts.admin title="Thêm tài khoản">
    <!-- Page Header -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors inline-flex items-center gap-1.5 mb-2 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Quay lại danh sách
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Thêm tài khoản mới</h1>
        <p class="text-sm text-slate-500 mt-1">Tạo một tài khoản quản trị mới và phân vai trò cụ thể.</p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/60 overflow-hidden max-w-2xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Tên tài khoản</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm @error('name') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                    placeholder="Ví dụ: Nguyễn Văn A"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Địa chỉ Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm @error('email') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                    placeholder="user@gmail.com"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Vai trò & Quyền hạn</label>
                <select 
                    name="role" 
                    id="role" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm bg-white @error('role') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                    required
                >
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Chọn vai trò</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Toàn quyền quản trị)</option>
                    <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer (Thêm/Sửa/Xóa sản phẩm & bài viết)</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Chỉ Thêm & Xóa bài viết)</option>
                </select>
                @error('role')
                    <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Passwords -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Mật khẩu</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm @error('password') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                        placeholder="Tối thiểu 8 ký tự"
                        required
                    >
                    @error('password')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Xác nhận mật khẩu</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm"
                        placeholder="Nhập lại mật khẩu"
                        required
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg text-sm border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium transition-colors">Hủy bỏ</a>
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors shadow-md shadow-blue-500/20 inline-flex items-center gap-2"
                >
                    Tạo tài khoản
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
