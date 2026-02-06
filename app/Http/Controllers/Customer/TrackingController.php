<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaxelService;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Show tracking page (search by order code)
     */
    public function index()
    {
        return view('customer.tracking.index', [
            'pageTitle' => 'Cek Status Pesanan',
        ]);
    }

    /**
     * Show order tracking result
     */
    public function show(Request $request)
    {
        $orderCode = $request->query('order_code');
        $phone = $request->query('phone');

        if (!$orderCode) {
            return redirect()->route('tracking.index')
                ->with('error', 'Masukkan kode order.');
        }

        $query = Order::where('order_code', $orderCode);

        if ($phone) {
            $phoneClean = preg_replace('/[^0-9]/', '', $phone);
            $query->whereRaw("REPLACE(REPLACE(REPLACE(customer_phone, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . $phoneClean . '%']);
        }

        $order = $query->first();

        if (!$order) {
            return redirect()->route('tracking.index')
                ->with('error', 'Pesanan tidak ditemukan. Periksa kode order dan nomor WhatsApp.')
                ->withInput($request->only('order_code', 'phone'));
        }

        $order->load(['items.product', 'payment']);

        return view('customer.tracking.show', [
            'pageTitle' => 'Status Pesanan ' . $order->order_code,
            'order' => $order,
        ]);
    }
}
