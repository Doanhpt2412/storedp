<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_percentage',
        'minimum_order_value',
        'usage_limit',
        'usage_count',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'discount_percentage' => 'integer',
        'minimum_order_value' => 'integer',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Đang áp dụng' : 'Tạm tắt';
    }
}
