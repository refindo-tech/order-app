<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Bumbu Rendang Padang',
                'slug' => 'bumbu-rendang-padang',
                'description' => 'Bumbu rendang khas Padang dengan rasa autentik dan rempah pilihan.',
                'long_description' => 'Bumbu rendang premium yang terbuat dari rempah-rempah pilihan berkualitas tinggi. Dengan komposisi yang pas dan cita rasa autentik khas Padang, bumbu ini akan menghasilkan rendang yang lezat dengan aroma yang menggugah selera. Cocok untuk masakan rumahan maupun komersial.',
                'price' => 25000,
                'category' => 'Bumbu Masak',
                'stock' => 50,
                'weight' => 250,
                'ingredients' => ['Cabai merah', 'Bawang merah', 'Bawang putih', 'Jahe', 'Kunyit', 'Serai', 'Daun jeruk'],
                'usage' => '1 pack untuk 1 kg daging sapi',
                'shelf_life' => '6 bulan',
                'is_active' => true,
            ],
            [
                'name' => 'Bumbu Gulai Ayam',
                'slug' => 'bumbu-gulai-ayam',
                'description' => 'Bumbu gulai dengan santan gurih untuk masakan ayam yang lezat.',
                'long_description' => 'Bumbu gulai ayam dengan cita rasa gurih dan kaya rempah. Terbuat dari bahan-bahan pilihan yang menghasilkan masakan gulai yang autentik dan lezat.',
                'price' => 20000,
                'category' => 'Bumbu Masak',
                'stock' => 35,
                'weight' => 200,
                'ingredients' => ['Santan', 'Bawang merah', 'Bawang putih', 'Kunyit', 'Jahe', 'Lengkuas'],
                'usage' => '1 pack untuk 1 ekor ayam',
                'shelf_life' => '6 bulan',
                'is_active' => true,
            ],
            [
                'name' => 'Bumbu Opor Lebaran',
                'slug' => 'bumbu-opor-lebaran',
                'description' => 'Bumbu opor spesial untuk masakan opor ayam saat lebaran.',
                'long_description' => 'Bumbu opor lebaran dengan rasa yang khas dan cocok untuk hidangan spesial hari raya. Dijamin membuat opor ayam Anda menjadi lebih istimewa.',
                'price' => 18000,
                'category' => 'Bumbu Masak',
                'stock' => 45,
                'weight' => 200,
                'ingredients' => ['Santan', 'Bawang merah', 'Bawang putih', 'Kemiri', 'Kunyit', 'Ketumbar'],
                'usage' => '1 pack untuk 1 ekor ayam',
                'shelf_life' => '6 bulan',
                'is_active' => true,
            ],
            [
                'name' => 'Bumbu Rawon Jawa Timur',
                'slug' => 'bumbu-rawon-jawa-timur',
                'description' => 'Bumbu rawon asli Jawa Timur dengan kluwek pilihan.',
                'long_description' => 'Bumbu rawon autentik Jawa Timur dengan kluwek pilihan yang menghasilkan warna hitam khas dan rasa yang kaya. Cocok untuk Anda yang menyukai masakan tradisional.',
                'price' => 22000,
                'category' => 'Bumbu Masak',
                'stock' => 28,
                'weight' => 250,
                'ingredients' => ['Kluwek', 'Bawang merah', 'Bawang putih', 'Kemiri', 'Kunyit', 'Lengkuas'],
                'usage' => '1 pack untuk 1 kg daging sapi',
                'shelf_life' => '6 bulan',
                'is_active' => true,
            ],
            [
                'name' => 'Ungkep Ayam Kampung',
                'slug' => 'ungkep-ayam-kampung',
                'description' => 'Ayam kampung ungkep siap masak dengan bumbu meresap.',
                'long_description' => 'Ayam kampung pilihan yang sudah diungkep dengan bumbu rempah yang meresap sempurna. Siap untuk digoreng atau diolah lebih lanjut sesuai selera Anda.',
                'price' => 85000,
                'category' => 'Ungkep',
                'stock' => 15,
                'weight' => 1000,
                'ingredients' => ['Ayam kampung', 'Bawang merah', 'Bawang putih', 'Kunyit', 'Jahe', 'Ketumbar'],
                'usage' => 'Siap digoreng atau diolah lebih lanjut',
                'shelf_life' => '3 hari (simpan di kulkas)',
                'is_active' => true,
            ],
            [
                'name' => 'Ungkep Bebek Rica',
                'slug' => 'ungkep-bebek-rica',
                'description' => 'Bebek ungkep bumbu rica-rica pedas dan gurih.',
                'long_description' => 'Bebek pilihan yang diungkep dengan bumbu rica-rica pedas dan gurih. Cocok untuk Anda yang menyukai masakan dengan cita rasa pedas yang menggugah selera.',
                'price' => 95000,
                'category' => 'Ungkep',
                'stock' => 12,
                'weight' => 1200,
                'ingredients' => ['Bebek', 'Cabai merah', 'Bawang merah', 'Bawang putih', 'Kunyit', 'Jahe'],
                'usage' => 'Siap digoreng atau diolah lebih lanjut',
                'shelf_life' => '3 hari (simpan di kulkas)',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Sample products created successfully!');
    }
}
