@csrf
@if (($method ?? 'POST') !== 'POST')
    @method($method)
@endif

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold text-slate-800">Thông tin chung</h2>
        </div>
        <div class="space-y-5">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Mã khuyến mãi</label>
                <input type="text" name="code" value="{{ old('code', $promotionCode->code) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm uppercase outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="VD: GIAM10">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tên chương trình</label>
                <input type="text" name="name" value="{{ old('name', $promotionCode->name) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Giảm 10% cho đơn từ 2 triệu">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Mô tả</label>
                <textarea name="description" rows="4" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('description', $promotionCode->description) }}</textarea>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold text-slate-800">Điều kiện áp dụng</h2>
        </div>
        <div class="space-y-5">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Giảm theo %</label>
                    <input type="number" name="discount_percentage" min="1" max="100" value="{{ old('discount_percentage', $promotionCode->discount_percentage) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Giá trị đơn tối thiểu</label>
                    <input type="number" name="minimum_order_value" min="0" value="{{ old('minimum_order_value', $promotionCode->minimum_order_value) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Giới hạn lượt dùng</label>
                    <input type="number" name="usage_limit" min="1" value="{{ old('usage_limit', $promotionCode->usage_limit) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Bỏ trống nếu không giới hạn">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Lượt đã dùng</label>
                    <input type="text" value="{{ $promotionCode->usage_count ?? 0 }}" disabled class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-500">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Bắt đầu</label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($promotionCode->starts_at)->format('Y-m-d\\TH:i')) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Kết thúc</label>
                    <input type="datetime-local" name="ends_at" value="{{ old('ends_at', optional($promotionCode->ends_at)->format('Y-m-d\\TH:i')) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>
            </div>
            <label class="inline-flex cursor-pointer items-center">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active', $promotionCode->is_active ?? true))>
                <span class="relative h-6 w-11 rounded-full bg-slate-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-blue-600 peer-checked:after:translate-x-full"></span>
                <span class="ms-3 text-sm font-semibold text-slate-700">Đang kích hoạt</span>
            </label>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
        <div class="font-semibold">Vui lòng kiểm tra lại dữ liệu nhập.</div>
        <ul class="mt-2 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flex justify-end gap-3">
    <a href="{{ route('admin.promotion-codes.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Hủy</a>
    <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700">Lưu mã khuyến mãi</button>
</div>
