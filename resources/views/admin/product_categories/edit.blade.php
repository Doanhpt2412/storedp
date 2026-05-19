<x-layouts.admin title="Chỉnh sửa danh mục sản phẩm">
    @php
        function getCategoryPath($cat) {
            $path = [];
            $curr = $cat;
            while ($curr) {
                $path[] = $curr->name;
                $curr = $curr->parent;
            }
            return implode(' > ', array_reverse($path));
        }
    @endphp

    <!-- Page Header -->
    <div class="mb-6">
        <a href="{{ route('admin.product-categories.index') }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors inline-flex items-center gap-1.5 mb-2 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Quay lại danh sách
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Chỉnh sửa danh mục</h1>
        <p class="text-sm text-slate-500 mt-1">Cập nhật thông tin chi tiết, cấp bậc hoặc tùy chỉnh hiển thị cho danh mục.</p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/60 overflow-hidden max-w-3xl">
        <form method="POST" action="{{ route('admin.product-categories.update', $category->id) }}" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Tên danh mục <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm @error('name') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                        placeholder="Ví dụ: Điện thoại, Laptop..."
                        value="{{ old('name', $category->name) }}"
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
                        placeholder="dien-thoai-iphone"
                        value="{{ old('slug', $category->slug) }}"
                    >
                    @error('slug')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Parent Category Selection -->
                <div>
                    <label for="parent_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Danh mục cha</label>
                    <select 
                        name="parent_id" 
                        id="parent_id" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm bg-white"
                    >
                        <option value="" {{ is_null($category->parent_id) ? 'selected' : '' }}>Không có (Danh mục gốc)</option>
                        @foreach($parentCategories as $parentCat)
                            <option value="{{ $parentCat->id }}" {{ old('parent_id', $category->parent_id) == $parentCat->id ? 'selected' : '' }}>
                                {{ getCategoryPath($parentCat) }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-slate-400 text-[11px] mt-1">Danh mục hiện tại và các danh mục con của nó đã bị loại bỏ khỏi danh sách để tránh vòng lặp.</p>
                    @error('parent_id')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
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
                        value="{{ old('order', $category->order) }}"
                    >
                    @error('order')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Icon Key -->
                <div>
                    <label for="icon" class="block text-sm font-semibold text-slate-700 mb-1.5">Mã biểu tượng (Icon)</label>
                    <input 
                        type="text" 
                        name="icon" 
                        id="icon" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm font-mono"
                        placeholder="Ví dụ: apple-icon, phone-icon"
                        value="{{ old('icon', $category->icon) }}"
                    >
                    <p class="text-slate-400 text-[11px] mt-1">Nhập chuỗi biểu thị mã CSS hoặc SVG icon.</p>
                </div>

                <!-- Image URL -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-slate-700 mb-1.5">Hình ảnh banner / đại diện (URL)</label>
                    <input 
                        type="text" 
                        name="image" 
                        id="image" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm"
                        placeholder="https://via.placeholder.com/640x360"
                        value="{{ old('image', $category->image) }}"
                    >
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Mô tả chi tiết</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="3" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm @error('description') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                    placeholder="Mô tả thông tin tổng quan về danh mục này..."
                >{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options Toggles -->
            <div class="p-4 bg-slate-50 border border-slate-200/60 rounded-xl flex flex-wrap gap-x-8 gap-y-4">
                <!-- is_active -->
                <label class="inline-flex items-center cursor-pointer select-none">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        class="sr-only peer"
                        {{ old('is_active', $category->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                    >
                    <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-semibold text-slate-700">Trạng thái Hoạt động</span>
                </label>

                <!-- show_in_nav -->
                <label class="inline-flex items-center cursor-pointer select-none">
                    <input 
                        type="checkbox" 
                        name="show_in_nav" 
                        value="1" 
                        class="sr-only peer"
                        {{ old('show_in_nav', $category->show_in_nav ? '1' : '0') == '1' ? 'checked' : '' }}
                    >
                    <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-semibold text-slate-700">Hiển thị trên Menu chính (Navbar)</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.product-categories.index') }}" class="px-4 py-2 rounded-lg text-sm border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium transition-colors">Hủy bỏ</a>
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
