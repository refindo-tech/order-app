<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'long_description',
        'price',
        'normal_price',
        'minimal_grosir',
        'harga_grosir',
        'category',
        'extra_categories',
        'stock',
        'weight',
        'image',
        'ingredients',
        'usage',
        'shelf_life',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'normal_price' => 'decimal:2',
        'harga_grosir' => 'decimal:2',
        'stock' => 'integer',
        'weight' => 'integer',
        'ingredients' => 'array',
        'extra_categories' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationship with OrderItems
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Vouchers assigned to this product (many-to-many).
     */
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'product_vouchers');
    }

    /**
     * Product media (images/videos), up to 4, ordered by sort_order.
     */
    public function media()
    {
        return $this->hasMany(ProductMedia::class)->orderBy('sort_order');
    }

    /**
     * First image path for thumbnail/backward compatibility (product.image or first media image).
     */
    public function getPrimaryImageAttribute(): ?string
    {
        if ($this->image) {
            return $this->image;
        }
        $first = $this->media()->where('type', 'image')->first();

        return $first ? $first->path : null;
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Whether this product has wholesale pricing configured.
     */
    public function hasGrosir(): bool
    {
        return $this->minimal_grosir !== null
            && $this->minimal_grosir >= 2
            && $this->harga_grosir !== null
            && (float) $this->harga_grosir < (float) $this->price;
    }

    /**
     * Get unit price for a given quantity (grosir applies if qty >= minimal_grosir).
     */
    public function getUnitPriceForQuantity(int $quantity): float
    {
        if ($quantity <= 0) {
            return (float) $this->price;
        }
        if ($this->hasGrosir() && $quantity >= (int) $this->minimal_grosir) {
            return (float) $this->harga_grosir;
        }
        return (float) $this->price;
    }

    /**
     * Check if grosir price applies for given quantity.
     */
    public function isGrosirAppliedForQuantity(int $quantity): bool
    {
        return $this->hasGrosir() && $quantity >= (int) $this->minimal_grosir;
    }
}
