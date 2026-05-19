<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public const STATUS_DRAFT = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_OUT_OF_STOCK = 2;

    protected $fillable = [
        'name',
        'slug',
        'product_brand_id',
        'product_category_id',
        'thumbnail',
        'images',
        'warranty_policy',
        'return_policy',
        'highlights',
        'summary',
        'description',
        'status',
        'is_preorder',
    ];

    protected $casts = [
        'images' => 'array',
        'highlights' => 'array',
        'status' => 'integer',
        'is_preorder' => 'boolean',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Nháp',
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_OUT_OF_STOCK => 'Hết hàng',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(ProductBrand::class, 'product_brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('storage')->orderBy('color_name');
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order')->orderBy('id');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? 'Không rõ';
    }

    public function getDisplayPriceAttribute(): ?float
    {
        $variant = $this->variants->sortBy(fn (ProductVariant $item) => $item->price_sale ?? $item->price_original)->first();

        return $variant?->price_sale ?? $variant?->price_original;
    }
}
