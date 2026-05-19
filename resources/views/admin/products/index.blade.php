<x-layouts.admin title="Quản lý sản phẩm">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Quản lý sản phẩm</h1>
            <p class="mt-1 text-sm text-slate-500">Quản lý sản phẩm cha, biến thể giá bán, tồn kho và thông số kỹ thuật.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/20 transition-colors hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Thêm sản phẩm
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="border-b border-slate-200/60 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Sản phẩm</th>
                        <th class="px-6 py-4">Danh mục</th>
                        <th class="px-6 py-4">Hãng</th>
                        <th class="px-6 py-4">Giá từ</th>
                        <th class="px-6 py-4 text-center">Biến thể</th>
                        <th class="px-6 py-4 text-center">Trạng thái</th>
                        <th class="px-6 py-4 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="text-sm text-slate-700">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                                        @if($product->thumbnail)
                                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $product->name }}</div>
                                        <div class="mt-0.5 font-mono text-xs text-slate-500">{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $product->brand?->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($product->display_price)
                                    <span class="font-semibold text-rose-600">{{ number_format($product->display_price, 0, ',', '.') }}đ</span>
                                @else
                                    <span class="text-slate-400">Chưa có giá</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $product->variants->count() }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $product->status === \App\Models\Product::STATUS_ACTIVE ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $product->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Sửa</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm font-medium text-slate-400">Chưa có sản phẩm nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
