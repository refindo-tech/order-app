<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paxel API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Paxel eCommerce API integration.
    | Staging: https://stage-commerce-api.paxel.co
    | Production: Contact Paxel support for URL
    |
    */

    'api_url' => env('PAXEL_API_URL', 'https://stage-commerce-api.paxel.co'),
    'api_key' => env('PAXEL_API_KEY'),
    'api_secret' => env('PAXEL_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Default Service Type
    |--------------------------------------------------------------------------
    |
    | Options: SAMEDAY, NEXTDAY, REGULAR, PAXEL AMPLOP, PAXEL BIG, INSTANT GOSEND
    | REGULAR recommended for food/bumbu delivery across Indonesia
    |
    */

    'default_service_type' => env('PAXEL_DEFAULT_SERVICE', 'REGULAR'),

    /*
    |--------------------------------------------------------------------------
    | Service Definitions (label, description, etd)
    |--------------------------------------------------------------------------
    */
    'services' => [
        'SAMEDAY' => [
            'label' => 'Paxel Same Day',
            'description' => 'Dikirim di hari yang sama, pesan sebelum batas waktu maka paket tiba hari itu juga.',
            'etd' => 'Hari yang sama',
        ],
        'NEXTDAY' => [
            'label' => 'Paxel Next Day',
            'description' => 'Pesanan dikirim besok, pengiriman lebih cepat ke tujuan pada hari berikutnya.',
            'etd' => '1 sampai 2 hari',
        ],
        'REGULAR' => [
            'label' => 'Paxel Regular',
            'description' => 'Layanan standar nasional yang ekonomis serta dapat diandalkan.',
            'etd' => '2 sampai 3 hari',
        ],
        'PAXEL BIG' => [
            'label' => 'Paxel Big',
            'description' => 'Diperuntukkan bagi paket berukuran besar atau berat dengan dimensi dan bobot lebih tinggi.',
            'etd' => '2 sampai 4 hari',
        ],
        'INSTANT GOSEND' => [
            'label' => 'Paxel Instant (GoSend)',
            'description' => 'Pengiriman instan setiap waktu, paket sampai di hari yang sama dalam beberapa jam. Terdapat batas volumetrik total paket (estimasi dari dimensi default × jumlah barang).',
            'etd' => '1 sampai 4 jam',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Disabled Services (belum bisa dipilih)
    |--------------------------------------------------------------------------
    | Layanan yang dinonaktifkan akan tetap ditampilkan tapi disabled dengan
    | badge "Belum tersedia". Pisahkan dengan koma, contoh: REGULAR,SAMEDAY
    */
    'disabled_services' => array_filter(array_map('trim', explode(',', env('PAXEL_DISABLED_SERVICES', 'REGULAR')))),

    /*
    |--------------------------------------------------------------------------
    | Origin Address (Store/Warehouse)
    |--------------------------------------------------------------------------
    |
    | Pickup location for Paxel. Must match Paxel coverage area.
    |
    */

    'origin' => [
        'name' => env('PAXEL_ORIGIN_NAME', 'Rumah Bumbu & Ungkep'),
        'phone' => env('PAXEL_ORIGIN_PHONE', '6285129964902'),
        'email' => env('PAXEL_ORIGIN_EMAIL', 'info@rumahbumbu.com'),
        'address' => env('PAXEL_ORIGIN_ADDRESS', 'Rajeg Gardenia, Blk. D5, Rajeg Mulya'),
        'province' => env('PAXEL_ORIGIN_PROVINCE', 'Banten'),
        'city' => env('PAXEL_ORIGIN_CITY', 'Kabupaten Tangerang'),
        'district' => env('PAXEL_ORIGIN_DISTRICT', 'Rajeg'),
        'village' => env('PAXEL_ORIGIN_VILLAGE', 'Rajeg Mulya'),
        'zip_code' => env('PAXEL_ORIGIN_ZIP_CODE', '15540'),
        // Empty .env value must not become (float) '' => 0 (breaks Paxel Instant rates/shipment).
        'longitude' => (($lon = env('PAXEL_ORIGIN_LONGITUDE')) !== null && $lon !== '') ? (float) $lon : 106.5274704,
        'latitude' => (($lat = env('PAXEL_ORIGIN_LATITUDE')) !== null && $lat !== '') ? (float) $lat : -6.1120778,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Package Dimensions (cm)
    |--------------------------------------------------------------------------
    | Used when product dimensions not available. Format: LxWxH
    */

    'default_dimension' => env('PAXEL_DEFAULT_DIMENSION', '30x25x15'),

    /*
    |--------------------------------------------------------------------------
    | Instant (GoSend) — max volumetric (cm³)
    |--------------------------------------------------------------------------
    | Paxel create shipment rejects Instant if total volumetric exceeds this
    | (default per Paxel: 125000). Estimated as sum of (L×W×H × qty) per line
    | using default_dimension, matching createShipment item packing.
    */
    'instant_max_volumetric_cm3' => (int) env('PAXEL_INSTANT_MAX_VOLUMETRIC_CM3', 125000),

    /*
    |--------------------------------------------------------------------------
    | Default Weight (grams)
    |--------------------------------------------------------------------------
    | Fallback when total weight cannot be calculated
    */

    'default_weight' => (int) env('PAXEL_DEFAULT_WEIGHT', 1000),

    /*
    |--------------------------------------------------------------------------
    | Paxel Tracking URL (public)
    |--------------------------------------------------------------------------
    | URL untuk customer cek tracking di website Paxel
    */
    'tracking_url' => env('PAXEL_TRACKING_URL', 'https://paxel.co/id/track-shipments'),
];
