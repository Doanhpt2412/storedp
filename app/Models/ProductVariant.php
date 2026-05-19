<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'storage',
        'color_name',
        'color_code',
        'price_original',
        'price_sale',
        'stock',
    ];

    protected $casts = [
        'price_original' => 'decimal:2',
        'price_sale' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
