<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaxelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaxelWebhookController extends Controller
{
    public function __construct(
        protected PaxelService $paxelService
    ) {}

    /**
     * Handle webhook from Paxel for shipment status updates
     * Endpoint: POST /api/paxel/webhook
     */
    public function __invoke(Request $request)
    {
        $payload = $request->all();

        $airwaybillCode = $payload['airwaybill_code'] ?? null;
        $latestStatus = $payload['latest_status'] ?? null;

        if (!$airwaybillCode || !$latestStatus) {
            Log::warning('Paxel webhook: missing required fields', $payload);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $signature = $request->header('X-Paxel-Signature') ?? $request->header('Paxel-Signature');
        if ($this->paxelService->isConfigured() && $signature) {
            if (!$this->paxelService->verifyWebhookSignature($signature, $airwaybillCode, $latestStatus)) {
                Log::warning('Paxel webhook: invalid signature', ['airwaybill' => $airwaybillCode]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }
        }

        $order = Order::where('paxel_waybill', $airwaybillCode)->first();
        if (!$order) {
            Log::info('Paxel webhook: order not found', ['airwaybill' => $airwaybillCode]);
            return response()->json(['message' => 'OK'], 200);
        }

        $tracking = $order->paxel_tracking ?? [];
        $tracking[] = [
            'status' => $latestStatus,
            'status_label' => $this->getStatusLabel($latestStatus),
            'description' => $payload['logs']['note'] ?? $latestStatus,
            'datetime' => $payload['delivery_datetime'] ?? now()->toIso8601String(),
            'driver_name' => $payload['driver_name'] ?? null,
        ];

        $updates = ['paxel_tracking' => $tracking];

        if (in_array($latestStatus, ['POD', 'PDO'])) {
            $updates['status'] = 'delivered';
        }

        $order->update($updates);

        Log::info('Paxel webhook processed', [
            'order_id' => $order->id,
            'airwaybill' => $airwaybillCode,
            'status' => $latestStatus,
        ]);

        return response()->json(['message' => 'OK'], 200);
    }

    protected function getStatusLabel(string $code): string
    {
        return match ($code) {
            'RTP' => 'Kurir dalam perjalanan ke lokasi pickup',
            'COL' => 'Kurir tiba di lokasi pickup',
            'PRJL' => 'Pickup dibatalkan',
            'RAP' => 'Penjadwalan ulang pickup',
            'PAPV' => 'Paket sudah dijemput',
            'POL' => 'Paket dalam perjalanan',
            'ODL' => 'Paket tiba di locker tujuan',
            'POD' => 'Kurir dalam perjalanan ke alamat tujuan',
            'COD' => 'Kurir tiba di alamat tujuan',
            'PDO' => 'Paket telah diterima',
            default => $code,
        };
    }
}
