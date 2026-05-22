<x-layouts.admin title="Thêm mã khuyến mãi">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Thêm mã khuyến mãi</h1>
        <p class="mt-1 text-sm text-slate-500">Tạo mã mới để giảm theo % trên tổng bill khi khách thanh toán.</p>
    </div>

    <form method="POST" action="{{ route('admin.promotion-codes.store') }}" class="space-y-6">
        @include('admin.promotion-codes._form', ['promotionCode' => $promotionCode, 'method' => 'POST'])
    </form>
</x-layouts.admin>
