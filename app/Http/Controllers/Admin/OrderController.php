<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.product', 'payment']);

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_code', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => Order::count(),
            'pending_payment' => Order::where('status', 'pending_payment')->count(),
            'payment_verification' => Order::where('status', 'payment_verification')->count(),
            'payment_confirmed' => Order::where('status', 'payment_confirmed')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        return view('admin.orders.index', [
            'orders' => $orders,
            'stats' => $stats,
            'currentStatus' => $request->status,
            'currentSearch' => $request->search,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'payment.verifier']);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending_payment,payment_verification,payment_confirmed,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // If status changed to payment_confirmed, update payment if exists
        if ($request->status === 'payment_confirmed' && $order->payment) {
            $order->payment->update([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
        }

        return redirect()->back()
            ->with('success', "Status order berhasil diubah dari {$oldStatus} menjadi {$request->status}.");
    }

    /**
     * Verify payment
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:verify,reject',
            'rejection_reason' => 'required_if:action,reject',
        ]);

        if (!$order->payment) {
            return redirect()->back()->with('error', 'Order ini belum memiliki bukti pembayaran.');
        }

        if ($request->action === 'verify') {
            $order->payment->update([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            $order->update(['status' => 'payment_confirmed']);

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
        } else {
            $order->payment->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            return redirect()->back()->with('success', 'Pembayaran ditolak.');
        }
    }
}
