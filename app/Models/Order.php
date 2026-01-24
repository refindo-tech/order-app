<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_province',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'paxel_waybill',
        'paxel_tracking',
        'shipped_at',
        'notes',
        'admin_notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'paxel_tracking' => 'array',
        'shipped_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $order->order_code = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Relationship with OrderItems
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship with Payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'payment_verification' => 'Verifikasi Pembayaran',
            'payment_confirmed' => 'Pembayaran Diterima',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Sedang Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending_payment', 'payment_verification']);
    }

    /**
     * Check if order can be shipped
     */
    public function canBeShipped(): bool
    {
        return $this->status === 'payment_confirmed';
    }
}
