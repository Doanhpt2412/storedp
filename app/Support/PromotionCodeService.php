<?php

namespace App\Support;

use App\Models\PromotionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PromotionCodeService
{
    private const SESSION_KEY = 'checkout_promotion_code';

    public function __construct(private readonly Request $request)
    {
    }

    public function apply(string $code): void
    {
        $this->request->session()->put(self::SESSION_KEY, mb_strtoupper(trim($code)));
    }

    public function clear(): void
    {
        $this->request->session()->forget(self::SESSION_KEY);
    }

    public function currentCode(): ?string
    {
        $code = $this->request->session()->get(self::SESSION_KEY);

        return is_string($code) && $code !== '' ? $code : null;
    }

    public function current(int $subtotal): ?array
    {
        $code = $this->currentCode();

        if (! $code) {
            return null;
        }

        $promotion = PromotionCode::query()
            ->where('code', $code)
            ->first();

        if (! $promotion) {
            $this->clear();

            return null;
        }

        $message = $this->validationMessage($promotion, $subtotal);

        if ($message !== null) {
            $this->clear();

            return null;
        }

        $discountAmount = $this->discountAmount($promotion, $subtotal);

        return [
            'promotion' => $promotion,
            'code' => $promotion->code,
            'name' => $promotion->name,
            'discount_percentage' => $promotion->discount_percentage,
            'discount_amount' => $discountAmount,
            'subtotal' => $subtotal,
            'total' => max(0, $subtotal - $discountAmount),
        ];
    }

    public function validateForApply(string $code, int $subtotal): array
    {
        $promotion = PromotionCode::query()
            ->where('code', mb_strtoupper(trim($code)))
            ->first();

        if (! $promotion) {
            return ['promotion' => null, 'message' => 'Mã khuyến mãi không tồn tại.'];
        }

        $message = $this->validationMessage($promotion, $subtotal);

        return [
            'promotion' => $promotion,
            'message' => $message,
        ];
    }

    public function discountAmount(PromotionCode $promotion, int $subtotal): int
    {
        return (int) floor($subtotal * ($promotion->discount_percentage / 100));
    }

    public function validationMessage(PromotionCode $promotion, int $subtotal): ?string
    {
        $now = Carbon::now();

        if (! $promotion->is_active) {
            return 'Mã khuyến mãi này hiện đang tạm tắt.';
        }

        if ($promotion->starts_at && $promotion->starts_at->gt($now)) {
            return 'Mã khuyến mãi chưa đến thời gian áp dụng.';
        }

        if ($promotion->ends_at && $promotion->ends_at->lt($now)) {
            return 'Mã khuyến mãi đã hết hạn.';
        }

        if ($promotion->usage_limit !== null && $promotion->usage_count >= $promotion->usage_limit) {
            return 'Mã khuyến mãi đã hết lượt sử dụng.';
        }

        if ($subtotal < $promotion->minimum_order_value) {
            return 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã này.';
        }

        return null;
    }
}
