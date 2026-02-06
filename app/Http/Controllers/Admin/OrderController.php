<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaxelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        // Paxel status filter
        if ($request->has('paxel_status')) {
            if ($request->paxel_status === 'has_waybill') {
                $query->whereNotNull('paxel_waybill');
            } elseif ($request->paxel_status === 'no_waybill') {
                $query->whereNull('paxel_waybill');
            }
        }

        // Date filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search (order code, customer name, phone, atau resi Paxel)
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('order_code', 'like', '%' . $searchTerm . '%')
                  ->orWhere('customer_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                  ->orWhere('paxel_waybill', 'like', '%' . $searchTerm . '%');
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
            'has_waybill' => Order::whereNotNull('paxel_waybill')->count(),
            'no_waybill' => Order::whereNull('paxel_waybill')->whereIn('status', ['payment_confirmed', 'processing'])->count(),
        ];

        return view('admin.orders.index', [
            'orders' => $orders,
            'stats' => $stats,
            'currentStatus' => $request->status,
            'currentSearch' => $request->search,
            'currentPaxelStatus' => $request->paxel_status,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
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
        Log::info('[Payment Verification] Start verification process', [
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'action' => $request->action,
            'admin_id' => auth()->id(),
        ]);

        try {
            $request->validate([
                'action' => 'required|in:verify,reject',
                'rejection_reason' => 'required_if:action,reject',
            ], [
                'action.required' => 'Aksi harus dipilih.',
                'action.in' => 'Aksi tidak valid.',
                'rejection_reason.required_if' => 'Alasan penolakan wajib diisi.',
            ]);

            Log::info('[Payment Verification] Validation passed', [
                'action' => $request->action,
            ]);

            if (!$order->payment) {
                Log::warning('[Payment Verification] Order has no payment', [
                    'order_id' => $order->id,
                ]);
                return redirect()->back()->with('error', 'Order ini belum memiliki bukti pembayaran.');
            }

            if ($request->action === 'verify') {
                Log::info('[Payment Verification] Verifying payment');
                $order->payment->update([
                    'status' => 'verified',
                    'verified_by' => auth()->id(),
                    'verified_at' => now(),
                ]);

                $oldStatus = $order->status;
                $order->update(['status' => 'payment_confirmed']);

                Log::info('[Payment Verification] Payment verified successfully', [
                    'order_id' => $order->id,
                    'payment_id' => $order->payment->id,
                    'old_status' => $oldStatus,
                    'new_status' => $order->status,
                ]);

                return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
            } else {
                Log::info('[Payment Verification] Rejecting payment', [
                    'rejection_reason' => $request->rejection_reason,
                ]);
                $order->payment->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                ]);

                Log::info('[Payment Verification] Payment rejected successfully', [
                    'order_id' => $order->id,
                    'payment_id' => $order->payment->id,
                ]);

                return redirect()->back()->with('success', 'Pembayaran ditolak.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('[Payment Verification] Validation failed', [
                'order_id' => $order->id,
                'errors' => $e->errors(),
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('[Payment Verification] Verification failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memverifikasi pembayaran. Silakan coba lagi atau hubungi developer jika masalah berlanjut.');
        }
    }

    /**
     * Create Paxel shipment (generate waybill)
     */
    public function createPaxelShipment(PaxelService $paxelService, Order $order)
    {
        Log::info('[Paxel Shipment] Start creating shipment', [
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'admin_id' => auth()->id(),
            'admin_name' => auth()->user()->name ?? 'Unknown',
            'ip' => request()->ip(),
        ]);

        try {
            $result = $paxelService->createShipment($order);

            if ($result['success']) {
                Log::info('[Paxel Shipment] Shipment created successfully', [
                    'order_id' => $order->id,
                    'order_code' => $order->order_code,
                    'waybill' => $result['waybill'],
                    'admin_id' => auth()->id(),
                ]);

                return redirect()->back()
                    ->with('success', 'Pesanan berhasil dikirim ke Paxel. Nomor resi: ' . $result['waybill']);
            }

            Log::warning('[Paxel Shipment] Shipment creation failed', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'error' => $result['error'] ?? 'Unknown error',
                'admin_id' => auth()->id(),
            ]);

            return redirect()->back()
                ->with('error', 'Gagal membuat shipment Paxel.')
                ->with('paxel_error', $result['error'] ?? 'Unknown error');
        } catch (\Exception $e) {
            Log::error('[Paxel Shipment] Exception occurred', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'admin_id' => auth()->id(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat shipment Paxel.')
                ->with('paxel_error', $e->getMessage());
        }
    }

    /**
     * Refresh tracking status from Paxel API
     */
    public function refreshPaxelTracking(PaxelService $paxelService, Order $order)
    {
        if (!$order->paxel_waybill) {
            return redirect()->back()
                ->with('error', 'Order ini belum memiliki nomor resi Paxel.')
                ->with('tracking_error', 'Nomor resi belum tersedia.');
        }

        Log::info('[Paxel Tracking] Refresh tracking started', [
            'order_id' => $order->id,
            'waybill' => $order->paxel_waybill,
            'admin_id' => auth()->id(),
        ]);

        try {
            $result = $paxelService->trackShipment($order->paxel_waybill);

            if (!$result['success']) {
                Log::warning('[Paxel Tracking] Refresh failed', [
                    'order_id' => $order->id,
                    'waybill' => $order->paxel_waybill,
                    'error' => $result['error'] ?? 'Unknown error',
                ]);
                return redirect()->back()
                    ->with('error', 'Gagal mengambil data tracking.')
                    ->with('tracking_error', $result['error'] ?? 'Gagal mengambil data tracking.');
            }

        $data = $result['data'] ?? [];
        $inner = $data['data'] ?? $data;
        $tracking = $order->paxel_tracking ?? [];
        $statusLabels = [
            'RTP' => 'Kurir dalam perjalanan ke lokasi pickup',
            'COL' => 'Kurir tiba di lokasi pickup',
            'PAPV' => 'Paket sudah dijemput',
            'POL' => 'Paket dalam perjalanan',
            'POD' => 'Kurir dalam perjalanan ke alamat tujuan',
            'COD' => 'Kurir tiba di alamat tujuan',
            'PDO' => 'Paket telah diterima',
        ];

        $latestStatus = $data['latest_status'] ?? $inner['latest_status'] ?? $inner['status'] ?? null;
        $logs = $data['logs'] ?? $inner['logs'] ?? [];
        $logs = is_array($logs) ? (isset($logs['status']) ? [$logs] : $logs) : [];

        $addStatus = function ($status, $desc, $datetime) use (&$tracking, $statusLabels) {
            if ($status && !collect($tracking)->contains('status', $status)) {
                $tracking[] = [
                    'status' => $status,
                    'status_label' => $statusLabels[$status] ?? $status,
                    'description' => $desc ?: $status,
                    'datetime' => $datetime ?? now()->toIso8601String(),
                ];
            }
        };

        if ($latestStatus) {
            $logNote = is_array($data['logs'] ?? null) ? ($data['logs']['note'] ?? $latestStatus) : $latestStatus;
            $addStatus($latestStatus, $logNote, $data['delivery_datetime'] ?? null);
        }

        foreach ($logs as $log) {
            $logStatus = is_array($log) ? ($log['status'] ?? null) : null;
            if ($logStatus) {
                $addStatus($logStatus, $log['note'] ?? null, $log['created_datetime'] ?? null);
            }
        }

        $updates = ['paxel_tracking' => $tracking];
        if (in_array($latestStatus, ['POD', 'PDO'])) {
            $updates['status'] = 'delivered';
        }

            $order->update($updates);

            Log::info('[Paxel Tracking] Refresh completed', [
                'order_id' => $order->id,
                'waybill' => $order->paxel_waybill,
                'latest_status' => $latestStatus,
                'tracking_count' => count($tracking),
            ]);

            return redirect()->back()->with('success', 'Tracking berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('[Paxel Tracking] Exception occurred', [
                'order_id' => $order->id,
                'waybill' => $order->paxel_waybill,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui tracking.')
                ->with('tracking_error', $e->getMessage());
        }
    }
}
