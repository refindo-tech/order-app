<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display shopping cart
     */
    public function index()
    {
        return view('customer.cart.index', [
            'pageTitle' => 'Keranjang Belanja',
        ]);
    }

    /**
     * Add product to cart (AJAX)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // For Phase 2, we'll use localStorage
        // Phase 3 akan menggunakan session atau database

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        // Will be implemented in Phase 3 with actual cart management
        return response()->json(['success' => true]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        // Will be implemented in Phase 3 with actual cart management
        return response()->json(['success' => true]);
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        return view('customer.cart.checkout', [
            'pageTitle' => 'Checkout',
        ]);
    }
}
