<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        return view('customer.home.index', [
            'pageTitle' => 'Beranda',
            'pageDescription' => 'Rumah Bumbu & Ungkep - Supplier bumbu dan ungkep berkualitas untuk kebutuhan dapur Anda.',
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
