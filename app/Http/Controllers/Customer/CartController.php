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
    public function checkout(Request $request)
    {
        if ($request->isMethod('post')) {
            return $this->processCheckout($request);
        }

        return view('customer.cart.checkout', [
            'pageTitle' => 'Checkout',
        ]);
    }

    /**
     * Process checkout and create order
     */
    private function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:10',
            'shipping_province' => 'nullable|string|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'cart_data' => 'required|json',
        ]);

        $cartData = json_decode($request->cart_data, true);

        if (empty($cartData)) {
            return redirect()->back()
                ->with('error', 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.')
                ->withInput();
        }

        // Calculate totals
        $subtotal = collect($cartData)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        });

        $shippingCost = $request->shipping_cost ?? 0;
        $total = $subtotal + $shippingCost;

        // Create order
        $order = \App\Models\Order::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_postal_code' => $request->shipping_postal_code,
            'shipping_province' => $request->shipping_province,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'status' => 'pending_payment',
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($cartData as $item) {
            $product = \App\Models\Product::find($item['id']);
            
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'] ?? ($product ? $product->name : 'Produk'),
                'product_price' => $item['price'] ?? 0,
                'quantity' => $item['quantity'] ?? 1,
                'subtotal' => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
            ]);
        }

        // Clear cart
        $request->session()->put('cart_cleared', true);

        return redirect()->route('cart.checkout-success', $order->order_code)
            ->with('success', 'Pesanan berhasil dibuat! Silakan upload bukti pembayaran.');
    }

    /**
     * Checkout success page
     */
    public function checkoutSuccess($orderCode)
    {
        $order = \App\Models\Order::where('order_code', $orderCode)->firstOrFail();
        $order->load(['items.product', 'payment']);

        return view('customer.cart.checkout-success', [
            'pageTitle' => 'Pesanan Berhasil',
            'order' => $order,
        ]);
    }

    /**
     * Upload payment proof
     */
    public function uploadPayment(Request $request, $orderCode)
    {
        $order = \App\Models\Order::where('order_code', $orderCode)->firstOrFail();

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Store payment proof
        $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');

        // Create or update payment record
        $payment = \App\Models\Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_proof' => $paymentProofPath,
                'status' => 'pending',
            ]
        );

        // Update order status
        $order->update(['status' => 'payment_verification']);

        return redirect()->back()
            ->with('success', 'Bukti pembayaran berhasil diupload! Admin akan memverifikasi pembayaran Anda.');
    }
}
