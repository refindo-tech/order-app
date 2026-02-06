<?php

return [
    'company' => [
        'name' => 'Order App',
        'full_name' => 'Rumah Bumbu & Ungkep',
        'tagline' => 'Supplier bumbu dan ungkep berkualitas untuk kebutuhan dapur Anda',
        'founded_year' => '2020',
        'description' => 'Rumah Bumbu & Ungkep adalah supplier terpercaya untuk kebutuhan bumbu dan ungkep berkualitas tinggi. Kami melayani pengiriman ke seluruh Indonesia dengan kualitas terjamin.',
        'logo' => 'images/rumah-bumbu-ungkep.png',
    ],

    'contact' => [
        'phone' => '082297754535',
        'whatsapp' => '6282297754535',
        'email' => 'info@rumahbumbu.com',
        'address' => [
            'street' => 'Rajeg Gardenia, Blk. D5, Rajeg Mulya, Kec. Rajeg',
            'city' => 'Kabupaten Tangerang',
            'country' => 'Indonesia',
        ],
        'business_hours' => 'Senin - Sabtu: 08:00 - 17:00 WIB',
    ],

    'shipping' => [
        'free_shipping_threshold' => 500000, // Rp 500.000
        'provider' => 'Paxel',
        'estimated_delivery' => '1-3 hari kerja',
        'coverage' => 'Seluruh Indonesia',
        // Paxel origin - override via PAXEL_ORIGIN_* in .env
        'origin' => [
            'address' => 'Rajeg Gardenia, Blk. D5, Rajeg Mulya',
            'province' => 'Banten',
            'city' => 'Kabupaten Tangerang',
            'district' => 'Rajeg',
            'village' => 'Rajeg Mulya',
            'zip_code' => '15540',
            'longitude' => 106.5274704,
            'latitude' => -6.1120778,
        ],
    ],

    'social_media' => [
        'facebook' => 'https://shopee.co.id/rumah_bumbu_ungkep?entryPoint=ShopByPDP',
        'instagram' => 'https://www.instagram.com/rumahbumbu.ungkep/',
        'whatsapp' => 'https://wa.me/6282297754535',
    ],

    'payment' => [
        'banks' => [
            [
                'name' => 'Bank BCA',
                'account_number' => '1234567890',
                'account_name' => 'Rumah Bumbu & Ungkep',
                'icon' => 'bi-bank',
            ],
            [
                'name' => 'Bank Mandiri',
                'account_number' => '9876543210',
                'account_name' => 'Rumah Bumbu & Ungkep',
                'icon' => 'bi-bank',
            ],
            [
                'name' => 'Bank BRI',
                'account_number' => '5555555555',
                'account_name' => 'Rumah Bumbu & Ungkep',
                'icon' => 'bi-bank',
            ],
        ],
        'ewallets' => [
            [
                'name' => 'DANA',
                'account_number' => '082297754535',
                'account_name' => 'Rumah Bumbu & Ungkep',
                'icon' => 'bi-wallet2',
            ],
            [
                'name' => 'OVO',
                'account_number' => '082297754535',
                'account_name' => 'Rumah Bumbu & Ungkep',
                'icon' => 'bi-wallet2',
            ],
            [
                'name' => 'GoPay',
                'account_number' => '082297754535',
                'account_name' => 'Rumah Bumbu & Ungkep',
                'icon' => 'bi-wallet2',
            ],
            [
                'name' => 'ShopeePay',
                'account_number' => '082297754535',
                'account_name' => 'Rumah Bumbu & Ungkep',
                'icon' => 'bi-wallet2',
            ],
        ],
        'qr_code' => [
            'enabled' => true,
            'image' => 'images/qr-payment.png', // Path ke gambar QR code
            'description' => 'Scan QR Code untuk pembayaran cepat',
        ],
    ],
];