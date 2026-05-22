<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const DELIVERY_HOME = 'home_delivery';
    const DELIVERY_STORE = 'store_pickup';

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_method',
        'customer_address',
        'customer_note',
        'order_status',
        'promotion_code',
        'promotion_name',
        'discount_percentage',
        'discount_amount',
        'subtotal',
        'total',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $order->order_code = self::generateUniqueOrderCode();
            }
        });
    }

    private static function generateUniqueOrderCode()
    {
        do {
            // Generate DP-XXXXXX format (where X is uppercase letter or number)
            $code = 'DP-' . strtoupper(Str::random(6));
        } while (self::where('order_code', $code)->exists());

        return $code;
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'Chờ xác nhận',
            self::STATUS_PROCESSING => 'Đang xử lý',
            self::STATUS_SHIPPING => 'Đang giao hàng',
            self::STATUS_COMPLETED => 'Đã hoàn thành',
            self::STATUS_CANCELLED => 'Đã hủy',
        ];

        return $statuses[$this->order_status] ?? 'Không xác định';
    }

    public function getDeliveryLabelAttribute()
    {
        $deliveries = [
            self::DELIVERY_HOME => 'Giao tận nhà',
            self::DELIVERY_STORE => 'Nhận tại cửa hàng',
        ];

        return $deliveries[$this->delivery_method] ?? 'Không xác định';
    }
}
