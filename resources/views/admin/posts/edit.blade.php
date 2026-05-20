<x-layouts.admin title="Sửa Bài viết">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.posts.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sửa Bài viết</h1>
        </div>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @method('PUT')

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-base px-4 py-2 border transition-colors font-semibold @error('title') border-red-500 @enderror" placeholder="Nhập tiêu đề...">
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-slate-700 mb-2">Nội dung chi tiết</label>
                        <textarea name="content" id="editor" class="hidden">{{ old('content', $post->content) }}</textarea>
                        @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <label for="excerpt" class="block text-sm font-medium text-slate-700 mb-1">Đoạn trích (Mô tả ngắn)</label>
                <p class="text-xs text-slate-500 mb-2">Đoạn mô tả ngắn gọn này sẽ hiển thị ở ngoài trang chủ hoặc danh sách bài viết.</p>
                <textarea name="excerpt" id="excerpt" rows="3"
                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border transition-colors @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Xuất bản</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_published" class="ml-2 block text-sm font-medium text-slate-700">Đăng bài (Công khai)</label>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Cập nhật bài viết
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Chuyên mục <span class="text-red-500">*</span></h3>
                
                <div>
                    <select name="post_category_id" id="post_category_id" required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border transition-colors @error('post_category_id') border-red-500 @enderror">
                        <option value="">-- Chọn chuyên mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('post_category_id', $post->post_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('post_category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Ảnh đại diện</h3>
                
                <div class="space-y-4">
                    @if($post->thumbnail)
                        <div class="rounded-lg overflow-hidden border border-slate-200">
                            <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
                        </div>
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                    <p class="text-xs text-slate-500">Tải lên ảnh mới nếu muốn thay đổi.</p>
                    @error('thumbnail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-base font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">SEO / URL</h3>
                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-700 mb-1">Đường dẫn tĩnh</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" required
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border transition-colors bg-slate-50 @error('slug') border-red-500 @enderror">
                    @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <style>
        .ck-editor__editable {
            min-height: 400px;
            font-family: inherit;
        }
    </style>
</x-layouts.admin>
