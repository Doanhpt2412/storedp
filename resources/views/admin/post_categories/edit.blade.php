<x-layouts.admin title="Sửa Chuyên mục">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.post-categories.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sửa Chuyên mục</h1>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.post-categories.update', $postCategory) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Tên chuyên mục <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $postCategory->name) }}" required
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border transition-colors @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-700 mb-1">Đường dẫn (Slug)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $postCategory->slug) }}" required
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border transition-colors bg-slate-50 @error('slug') border-red-500 @enderror">
                    @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Mô tả</label>
                    <textarea name="description" id="description" rows="3"
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border transition-colors @error('description') border-red-500 @enderror">{{ old('description', $postCategory->description) }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $postCategory->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="is_active" class="ml-2 block text-sm font-medium text-slate-700">Kích hoạt hiển thị</label>
                </div>
            </div>

            <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('admin.post-categories.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Hủy
                </a>
                <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Cập nhật chuyên mục
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
