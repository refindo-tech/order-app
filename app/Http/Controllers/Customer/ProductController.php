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

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('name')->get();
        $categories = Product::active()->distinct()->pluck('category');

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
    public function show(Product $product)
    {
        // Get related products (same category, exclude current)
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
