<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'product_normal_price',
        'product_grosir_price',
        'is_grosir_applied',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_normal_price' => 'decimal:2',
        'product_grosir_price' => 'decimal:2',
        'is_grosir_applied' => 'boolean',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relationship with Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship with Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
