<x-layouts.admin title="Cập nhật hãng sản xuất">
    <!-- Page Header -->
    <div class="mb-6">
        <a href="{{ route('admin.product-brands.index') }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors inline-flex items-center gap-1.5 mb-2 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Quay lại danh sách
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Cập nhật hãng sản xuất</h1>
        <p class="text-sm text-slate-500 mt-1">Chỉnh sửa thông tin hãng sản xuất / thương hiệu "{{ $brand->name }}".</p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/60 overflow-hidden max-w-3xl">
        <form method="POST" action="{{ route('admin.product-brands.update', $brand->id) }}" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Tên hãng sản xuất <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm @error('name') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                        placeholder="Ví dụ: Apple, Samsung..."
                        value="{{ old('name', $brand->name) }}"
                        required
                        onkeyup="generateSlug()"
                    >
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-semibold text-slate-700 mb-1.5">Đường dẫn SEO (Slug)</label>
                    <input 
                        type="text" 
                        name="slug" 
                        id="slug" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm font-mono @error('slug') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                        placeholder="apple"
                        value="{{ old('slug', $brand->slug) }}"
                    >
                    @error('slug')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo URL or SVG -->
                <div>
                    <label for="logo" class="block text-sm font-semibold text-slate-700 mb-1.5">Mã Logo hoặc SVG (Tùy chọn)</label>
                    <input 
                        type="text" 
                        name="logo" 
                        id="logo" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm"
                        placeholder="Chuỗi CSS class hoặc SVG path"
                        value="{{ old('logo', $brand->logo) }}"
                    >
                </div>

                <!-- Display Order -->
                <div>
                    <label for="order" class="block text-sm font-semibold text-slate-700 mb-1.5">Thứ tự sắp xếp</label>
                    <input 
                        type="number" 
                        name="order" 
                        id="order" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm @error('order') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                        placeholder="0"
                        min="0"
                        value="{{ old('order', $brand->order) }}"
                    >
                    @error('order')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Options Toggles -->
            <div class="p-4 bg-slate-50 border border-slate-200/60 rounded-xl">
                <!-- is_active -->
                <label class="inline-flex items-center cursor-pointer select-none">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        class="sr-only peer"
                        {{ old('is_active', $brand->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                    >
                    <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-semibold text-slate-700">Kích hoạt hoạt động</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.product-brands.index') }}" class="px-4 py-2 rounded-lg text-sm border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium transition-colors">Hủy bỏ</a>
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors shadow-md shadow-blue-500/20"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>

    <!-- Script for automatic slug generation -->
    <script>
        function generateSlug() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            
            let name = nameInput.value;
            
            // Chuyển sang chữ thường
            let slug = name.toLowerCase();
            
            // Thay thế ký tự tiếng Việt có dấu
            slug = slug.replace(/[áàảãạăắằẳẵặâấầẩẫậ]/g, 'a');
            slug = slug.replace(/[éèẻẽẹêếềểễệ]/g, 'e');
            slug = slug.replace(/[íìỉĩị]/g, 'i');
            slug = slug.replace(/[óòỏõọôốồổỗộơớờởỡợ]/g, 'o');
            slug = slug.replace(/[úùủũụưứừửữự]/g, 'u');
            slug = slug.replace(/[ýỳỷỹỵ]/g, 'y');
            slug = slug.replace(/đ/g, 'd');
            
            // Loại bỏ các ký tự đặc biệt
            slug = slug.replace(/[^a-z0-9 -]/g, '')
                       // Thay thế các khoảng trắng liền kề bằng dấu gạch ngang
                       .replace(/\s+/g, '-')
                       // Loại bỏ các dấu gạch ngang liền kề
                       .replace(/-+/g, '-');
            
            // Xóa dấu gạch ngang ở đầu và cuối slug
            if (slug.startsWith('-')) slug = slug.substring(1);
            if (slug.endsWith('-')) slug = slug.substring(0, slug.length - 1);
            
            slugInput.value = slug;
        }
    </script>
</x-layouts.admin>
