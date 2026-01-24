<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        // Get featured products (first 4 active products)
        $featuredProducts = Product::active()
            ->inStock()
            ->limit(4)
            ->get();

        return view('customer.home.index', [
            'pageTitle' => 'Beranda',
            'pageDescription' => 'Rumah Bumbu & Ungkep - Supplier bumbu dan ungkep berkualitas untuk kebutuhan dapur Anda.',
            'featuredProducts' => $featuredProducts,
        ]);
    }

    /**
     * Display about page (optional, bisa juga di home page)
     */
    public function about()
    {
        return view('customer.home.about', [
            'pageTitle' => 'Tentang Kami',
        ]);
    }

    /**
     * Display contact page (optional, bisa juga di home page)
     */
    public function contact()
    {
        return view('customer.home.contact', [
            'pageTitle' => 'Kontak Kami',
        ]);
    }
}
