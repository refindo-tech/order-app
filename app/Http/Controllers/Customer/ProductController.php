<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display products catalog
     */
    public function index(Request $request)
    {
        // Temporary dummy data - akan diganti dengan model di Phase 3
        $products = collect([
            [
                'id' => 1,
                'name' => 'Bumbu Rendang Padang',
                'slug' => 'bumbu-rendang-padang',
                'description' => 'Bumbu rendang khas Padang dengan rasa autentik dan rempah pilihan.',
                'price' => 25000,
                'image' => $this->generateProductImage('Rendang'),
                'category' => 'Bumbu Masak',
                'stock' => 50,
                'weight' => 250, // gram
            ],
            [
                'id' => 2,
                'name' => 'Bumbu Gulai Ayam',
                'slug' => 'bumbu-gulai-ayam',
                'description' => 'Bumbu gulai dengan santan gurih untuk masakan ayam yang lezat.',
                'price' => 20000,
                'image' => $this->generateProductImage('Gulai'),
                'category' => 'Bumbu Masak',
                'stock' => 35,
                'weight' => 200,
            ],
            [
                'id' => 3,
                'name' => 'Bumbu Opor Lebaran',
                'slug' => 'bumbu-opor-lebaran',
                'description' => 'Bumbu opor spesial untuk masakan opor ayam saat lebaran.',
                'price' => 18000,
                'image' => $this->generateProductImage('Opor'),
                'category' => 'Bumbu Masak',
                'stock' => 45,
                'weight' => 200,
            ],
            [
                'id' => 4,
                'name' => 'Bumbu Rawon Jawa Timur',
                'slug' => 'bumbu-rawon-jawa-timur',
                'description' => 'Bumbu rawon asli Jawa Timur dengan kluwek pilihan.',
                'price' => 22000,
                'image' => $this->generateProductImage('Rawon'),
                'category' => 'Bumbu Masak',
                'stock' => 28,
                'weight' => 250,
            ],
            [
                'id' => 5,
                'name' => 'Ungkep Ayam Kampung',
                'slug' => 'ungkep-ayam-kampung',
                'description' => 'Ayam kampung ungkep siap masak dengan bumbu meresap.',
                'price' => 85000,
                'image' => $this->generateProductImage('Ungkep'),
                'category' => 'Ungkep',
                'stock' => 15,
                'weight' => 1000,
            ],
            [
                'id' => 6,
                'name' => 'Ungkep Bebek Rica',
                'slug' => 'ungkep-bebek-rica',
                'description' => 'Bebek ungkep bumbu rica-rica pedas dan gurih.',
                'price' => 95000,
                'image' => $this->generateProductImage('Bebek'),
                'category' => 'Ungkep',
                'stock' => 12,
                'weight' => 1200,
            ],
        ]);

        // Simple search functionality
        if ($request->has('search') && $request->search) {
            $products = $products->filter(function ($product) use ($request) {
                return stripos($product['name'], $request->search) !== false ||
                       stripos($product['description'], $request->search) !== false;
            });
        }

        // Simple category filter
        if ($request->has('category') && $request->category) {
            $products = $products->where('category', $request->category);
        }

        $categories = $products->pluck('category')->unique()->values();

        return view('customer.products.index', [
            'pageTitle' => 'Katalog Produk',
            'products' => $products,
            'categories' => $categories,
            'currentSearch' => $request->search,
            'currentCategory' => $request->category,
        ]);
    }

    /**
     * Display product details
     */
    public function show($productSlug)
    {
        // Temporary dummy data - akan diganti dengan model di Phase 3
        $products = collect([
            [
                'id' => 1,
                'name' => 'Bumbu Rendang Padang',
                'slug' => 'bumbu-rendang-padang',
                'description' => 'Bumbu rendang khas Padang dengan rasa autentik dan rempah pilihan.',
                'long_description' => 'Bumbu rendang premium yang terbuat dari rempah-rempah pilihan berkualitas tinggi. Dengan komposisi yang pas dan cita rasa autentik khas Padang, bumbu ini akan menghasilkan rendang yang lezat dengan aroma yang menggugah selera. Cocok untuk masakan rumahan maupun komersial.',
                'price' => 25000,
                'image' => $this->generateProductImage('Rendang'),
                'category' => 'Bumbu Masak',
                'stock' => 50,
                'weight' => 250,
                'ingredients' => ['Cabai merah', 'Bawang merah', 'Bawang putih', 'Jahe', 'Kunyit', 'Serai', 'Daun jeruk'],
                'usage' => '1 pack untuk 1 kg daging sapi',
                'shelf_life' => '6 bulan',
            ],
            // Add other products...
        ]);

        $product = $products->where('slug', $productSlug)->first();

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        return view('customer.products.show', [
            'pageTitle' => $product['name'],
            'product' => $product,
        ]);
    }

    /**
     * Generate dummy product image SVG
     */
    private function generateProductImage($productName)
    {
        $colors = [
            'Rendang' => '#dc3545',
            'Gulai' => '#fd7e14',
            'Opor' => '#ffc107',
            'Rawon' => '#6f42c1',
            'Ungkep' => '#198754',
            'Bebek' => '#20c997',
        ];

        $color = $colors[$productName] ?? '#6c757d';
        
        return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300' fill='none'%3E%3Crect width='400' height='300' fill='%23f8f9fa'/%3E%3Crect x='50' y='75' width='300' height='150' fill='" . urlencode($color) . "' fill-opacity='0.2' rx='15'/%3E%3Ctext x='200' y='155' text-anchor='middle' fill='" . urlencode($color) . "' font-family='Arial' font-size='24' font-weight='bold'%3E" . urlencode($productName) . "%3C/text%3E%3C/svg%3E";
    }
}
