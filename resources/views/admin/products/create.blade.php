<x-layouts.admin title="Thêm sản phẩm">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="mb-2 inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition-colors hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Quay lại danh sách
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Thêm sản phẩm</h1>
        <p class="mt-1 text-sm text-slate-500">Tạo sản phẩm cha, sau đó nhập các phiên bản SKU, giá và thông số.</p>
    </div>

    @include('admin.products.partials.form', [
        'action' => route('admin.products.store'),
        'method' => 'POST',
    ])
</x-layouts.admin>
