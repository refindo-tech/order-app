<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'name',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_vouchers');
    }

    /**
     * Scope: voucher aktif (now between start_date and end_date).
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('start_date', '<=', $now)->where('end_date', '>=', $now);
    }

    /**
     * Hitung potongan untuk suatu subtotal produk.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percent') {
            return round($subtotal * ((float) $this->discount_value / 100), 2);
        }
        return min((float) $this->discount_value, $subtotal);
    }

    /**
     * Label untuk tampilan (Diskon 10% / Diskon Rp10.000).
     */
    public function getDiscountLabelAttribute(): string
    {
        if ($this->discount_type === 'percent') {
            return 'Diskon ' . number_format((float) $this->discount_value, 0) . '%';
        }
        return 'Diskon Rp ' . number_format((float) $this->discount_value, 0, ',', '.');
    }
}
