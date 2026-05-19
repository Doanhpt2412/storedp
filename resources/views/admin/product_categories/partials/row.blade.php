<tr class="hover:bg-slate-50/80 transition-colors">
    <!-- Category Name with Hierarchical Indentation -->
    <td class="px-6 py-4 whitespace-nowrap">
        <div style="padding-left: {{ $level * 24 }}px;" class="flex items-center gap-2">
            @if($level > 0)
                <span class="text-slate-300 font-mono select-none">└─</span>
            @endif
            @if($category->icon)
                <span class="inline-flex items-center justify-center w-7 h-7 bg-slate-100 text-slate-500 rounded text-xs" title="Icon: {{ $category->icon }}">
                    <span class="font-semibold font-mono">{{ substr($category->icon, 0, 2) }}</span>
                </span>
            @else
                <span class="inline-flex items-center justify-center w-7 h-7 bg-slate-50 text-slate-300 rounded text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                </span>
            @endif
            <div class="flex flex-col">
                <span class="font-semibold text-slate-700 text-sm">{{ $category->name }}</span>
                @if($category->description)
                    <span class="text-slate-400 text-xs max-w-xs truncate">{{ $category->description }}</span>
                @endif
            </div>
        </div>
    </td>

    <!-- Slug -->
    <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-sm font-mono">
        {{ $category->slug }}
    </td>

    <!-- Show in Nav Toggle Badge -->
    <td class="px-6 py-4 whitespace-nowrap text-center">
        @if($category->show_in_nav)
            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                Navbar
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                Ẩn
            </span>
        @endif
    </td>

    <!-- Active Status -->
    <td class="px-6 py-4 whitespace-nowrap text-center">
        @if($category->is_active)
            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Hoạt động
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                Tạm khóa
            </span>
        @endif
    </td>

    <!-- Order -->
    <td class="px-6 py-4 whitespace-nowrap text-center text-slate-500 text-sm font-medium">
        {{ $category->order }}
    </td>

    <!-- Actions -->
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.product-categories.edit', $category->id) }}" class="text-slate-500 hover:text-blue-600 transition-colors p-1 rounded hover:bg-slate-100" title="Sửa">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            </a>
            
            <form action="{{ route('admin.product-categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Các danh mục con của nó sẽ được nâng lên làm danh mục gốc.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors p-1 rounded hover:bg-slate-100" title="Xóa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                </button>
            </form>
        </div>
    </td>
</tr>

<!-- Recursive rendering of children -->
@if($category->allChildren && $category->allChildren->count() > 0)
    @foreach($category->allChildren as $child)
        @include('admin.product_categories.partials.row', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif
