<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected $table = 'hero_banners';

    protected $fillable = [
        'hero_title',
        'hero_description',
    ];

    /**
     * Default title and description (used when no record exists).
     */
    public const DEFAULT_TITLE = 'Harga Terjangkau, Rasa Juara';
    public const DEFAULT_DESCRIPTION = 'Supplier terpercaya untuk kebutuhan bumbu dapur dan ungkep berkualitas. Melayani pengiriman ke seluruh Tangerang dan Luar Tangerang.';

    /**
     * Get the single hero banner instance (singleton). Creates default row if none exists.
     */
    public static function current(): self
    {
        $banner = self::first();
        if (!$banner) {
            $banner = self::create([
                'hero_title' => self::DEFAULT_TITLE,
                'hero_description' => self::DEFAULT_DESCRIPTION,
            ]);
        }
        return $banner;
    }
}
