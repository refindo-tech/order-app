<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\HeroBanner;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        // Get featured products (4 products marked as featured & active)
        $featuredProducts = Product::active()
            ->with('vouchers')
            ->where('is_featured', true)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        // Get latest published articles (limit 3)
        $homeArticles = Article::published()
            ->latest('publish_date')
            ->limit(3)
            ->get();

        $banner = HeroBanner::current();

        return view('customer.home.index', [
            'pageTitle' => 'Beranda',
            'pageDescription' => 'Rumah Bumbu & Ungkep - Supplier bumbu dan ungkep berkualitas untuk kebutuhan dapur Anda.',
            'featuredProducts' => $featuredProducts,
            'heroTitle' => $banner->hero_title,
            'heroDescription' => $banner->hero_description ?? '',
            'homeArticles' => $homeArticles,
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
