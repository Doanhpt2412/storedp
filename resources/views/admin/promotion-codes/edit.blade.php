<x-layouts.admin title="Cập nhật mã khuyến mãi">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Cập nhật mã khuyến mãi</h1>
        <p class="mt-1 text-sm text-slate-500">Chỉnh sửa điều kiện áp dụng, phần trăm giảm và thời gian hiệu lực.</p>
    </div>

    <form method="POST" action="{{ route('admin.promotion-codes.update', $promotionCode) }}" class="space-y-6">
        @include('admin.promotion-codes._form', ['promotionCode' => $promotionCode, 'method' => 'PUT'])
    </form>
</x-layouts.admin>
