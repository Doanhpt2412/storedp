<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PromotionCodeController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('manage-users');

        $query = PromotionCode::query()->latest();

        if ($request->filled('q')) {
            $search = trim((string) $request->string('q'));
            $query->where(function ($builder) use ($search) {
                $builder->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->string('status')->toString() === 'active');
        }

        $promotionCodes = $query->paginate(15)->withQueryString();

        return view('admin.promotion-codes.index', compact('promotionCodes'));
    }

    public function create(): View
    {
        Gate::authorize('manage-users');

        return view('admin.promotion-codes.create', [
            'promotionCode' => new PromotionCode([
                'discount_percentage' => 10,
                'minimum_order_value' => 0,
                'is_active' => true,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('manage-users');

        $data = $this->validatedData($request);

        PromotionCode::create($this->payload($data));

        return redirect()->route('admin.promotion-codes.index')->with('success', 'Đã tạo mã khuyến mãi thành công.');
    }

    public function edit(PromotionCode $promotionCode): View
    {
        Gate::authorize('manage-users');

        return view('admin.promotion-codes.edit', compact('promotionCode'));
    }

    public function update(Request $request, PromotionCode $promotionCode): RedirectResponse
    {
        Gate::authorize('manage-users');

        $data = $this->validatedData($request, $promotionCode);

        $promotionCode->update($this->payload($data));

        return redirect()->route('admin.promotion-codes.index')->with('success', 'Đã cập nhật mã khuyến mãi thành công.');
    }

    public function destroy(PromotionCode $promotionCode): RedirectResponse
    {
        Gate::authorize('manage-users');

        $promotionCode->delete();

        return redirect()->route('admin.promotion-codes.index')->with('success', 'Đã xóa mã khuyến mãi thành công.');
    }

    private function validatedData(Request $request, ?PromotionCode $promotionCode = null): array
    {
        return $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('promotion_codes', 'code')->ignore($promotionCode?->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'discount_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'minimum_order_value' => ['nullable', 'integer', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'code.required' => 'Vui lòng nhập mã khuyến mãi.',
            'code.unique' => 'Mã khuyến mãi đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên chương trình.',
            'discount_percentage.required' => 'Vui lòng nhập phần trăm giảm giá.',
            'discount_percentage.min' => 'Phần trăm giảm giá tối thiểu là 1%.',
            'discount_percentage.max' => 'Phần trăm giảm giá tối đa là 100%.',
            'ends_at.after_or_equal' => 'Thời gian kết thúc phải lớn hơn hoặc bằng thời gian bắt đầu.',
        ]);
    }

    private function payload(array $data): array
    {
        return [
            'code' => mb_strtoupper(trim($data['code'])),
            'name' => trim($data['name']),
            'description' => $data['description'] ?? null,
            'discount_percentage' => $data['discount_percentage'],
            'minimum_order_value' => $data['minimum_order_value'] ?? 0,
            'usage_limit' => $data['usage_limit'] ?? null,
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'is_active' => ! empty($data['is_active']),
        ];
    }
}
