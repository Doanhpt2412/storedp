<x-layouts.admin title="Mã khuyến mãi">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Quản lý mã khuyến mãi</h1>
            <p class="mt-1 text-sm text-slate-500">Tạo mã giảm theo % tổng bill, đặt điều kiện áp dụng và kiểm soát số lượt sử dụng.</p>
        </div>
        <a href="{{ route('admin.promotion-codes.create') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Thêm mã khuyến mãi</a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.promotion-codes.index') }}" class="flex flex-col gap-4 md:flex-row">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm theo mã hoặc tên chương trình..." class="block w-full rounded-lg border border-slate-300 px-4 py-2 text-sm md:flex-1">
            <select name="status" class="block w-full rounded-lg border border-slate-300 px-4 py-2 text-sm md:w-56" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="active" @selected(request('status') === 'active')>Đang áp dụng</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Tạm tắt</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Lọc</button>
                @if (request()->filled('q') || request()->filled('status'))
                    <a href="{{ route('admin.promotion-codes.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Xóa lọc</a>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Mã</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Chương trình</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Giảm giá</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Điều kiện</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Lượt dùng</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Trạng thái</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($promotionCodes as $promotionCode)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="font-bold text-blue-600">{{ $promotionCode->code }}</div>
                                <div class="mt-0.5 text-xs text-slate-500">
                                    @if($promotionCode->starts_at)
                                        Bắt đầu: {{ $promotionCode->starts_at->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-slate-900">{{ $promotionCode->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $promotionCode->description }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-emerald-600">{{ $promotionCode->discount_percentage }}%</td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                Đơn từ {{ number_format($promotionCode->minimum_order_value, 0, ',', '.') }}đ
                                @if($promotionCode->ends_at)
                                    <div class="mt-1 text-xs text-slate-500">Hết hạn: {{ $promotionCode->ends_at->format('d/m/Y H:i') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $promotionCode->usage_count }}
                                @if($promotionCode->usage_limit)
                                    / {{ $promotionCode->usage_limit }}
                                @else
                                    / Không giới hạn
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $promotionCode->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $promotionCode->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.promotion-codes.edit', $promotionCode) }}" class="text-blue-600 hover:text-blue-800">Sửa</a>
                                    <form action="{{ route('admin.promotion-codes.destroy', $promotionCode) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa mã khuyến mãi này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">Chưa có mã khuyến mãi nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($promotionCodes->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $promotionCodes->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
