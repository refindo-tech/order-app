<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display products catalog
     */
    public function index(Request $request)
    {
        $query = Product::active();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter (special category: "Diskon" => produk yang punya voucher aktif)
        $currentCategory = $request->category;
        if ($currentCategory) {
            if ($currentCategory === 'Diskon') {
                $query->whereHas('vouchers', function ($q) {
                    $q->active();
                });
            } else {
                $query->where('category', $currentCategory);
            }
        }

        $products = $query
            ->with(['vouchers' => fn ($q) => $q->active()])
            ->orderBy('name')
            ->get();

        // Daftar kategori asli dari produk
        $categories = Product::active()->distinct()->pluck('category');
        // Hitung produk yang punya voucher aktif (kategori virtual \"Diskon\")
        $discountCategoryCount = Product::active()
            ->whereHas('vouchers', fn ($q) => $q->active())
            ->count();
        if ($discountCategoryCount > 0 && ! $categories->contains('Diskon')) {
            $categories->push('Diskon');
        }

        return view('customer.products.index', [
            'pageTitle' => 'Katalog Produk',
            'products' => $products,
            'categories' => $categories,
            'discountCategoryCount' => $discountCategoryCount,
            'currentSearch' => $request->search,
            'currentCategory' => $currentCategory,
        ]);
    }

    /**
     * Display product details
     */
    public function show(Product $product)
    {
        $product->load(['vouchers' => function ($q) {
            $q->active();
        }]);

        $relatedProducts = Product::active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        return view('customer.products.show', [
            'pageTitle' => $product->name,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
