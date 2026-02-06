<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaxelService
{
    protected string $baseUrl;
    protected ?string $apiKey;
    protected ?string $apiSecret;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('paxel.api_url'), '/');
        $this->apiKey = config('paxel.api_key');
        $this->apiSecret = config('paxel.api_secret');
    }

    /**
     * Check if Paxel integration is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && !empty($this->apiSecret);
    }

    /**
     * Get shipping rates from origin to destination
     *
     * @param array $destination ['address', 'province', 'city', 'district', 'village', 'zip_code', 'longitude', 'latitude']
     * @param int $weight Weight in grams
     * @param string $dimension Format "LxWxH" in cm
     * @param string $serviceType SAMEDAY|NEXTDAY|REGULAR|PAXEL AMPLOP|PAXEL BIG
     * @return array{success: bool, data?: array, error?: string}
     */
    public function getRates(array $destination, int $weight, string $dimension, string $serviceType = 'REGULAR'): array
    {
        if (!$this->isConfigured()) {
            Log::channel('single')->warning('[PaxelService] getRates skipped: API not configured', [
                'has_api_key' => !empty($this->apiKey),
                'has_api_secret' => !empty($this->apiSecret),
            ]);
            return ['success' => false, 'error' => 'Paxel API not configured'];
        }

        $origin = config('paxel.origin');

        $payload = [
            'origin' => [
                'address' => $origin['address'] ?? '',
                'province' => $origin['province'] ?? '',
                'city' => $origin['city'] ?? '',
                'district' => $origin['district'] ?? '',
                'village' => $origin['village'] ?? '',
                'zip_code' => $origin['zip_code'] ?? '',
                'longitude' => $origin['longitude'] ?? null,
                'latitude' => $origin['latitude'] ?? null,
            ],
            'destination' => [
                'address' => $destination['address'] ?? '',
                'province' => $destination['province'] ?? '',
                'city' => $destination['city'] ?? '',
                'district' => $destination['district'] ?? $destination['city'] ?? '',
                'village' => $destination['village'] ?? '',
                'zip_code' => $destination['zip_code'] ?? '',
                'longitude' => $destination['longitude'] ?? null,
                'latitude' => $destination['latitude'] ?? null,
            ],
            'weight' => max(1, $weight),
            'dimension' => $dimension,
            'service_type' => $serviceType,
        ];

        Log::channel('single')->info('[PaxelService] getRates request', [
            'url' => "{$this->baseUrl}/v1/rates/city",
            'origin_city' => $origin['city'] ?? null,
            'origin_province' => $origin['province'] ?? null,
            'destination_city' => $destination['city'] ?? null,
            'destination_province' => $destination['province'] ?? null,
            'weight' => $weight,
            'dimension' => $dimension,
            'service_type' => $serviceType,
        ]);

        try {
            $response = Http::withHeaders([
                'X-Paxel-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/v1/rates/city", $payload);

            $body = $response->json();

            if (!$response->successful()) {
                Log::channel('single')->warning('[PaxelService] getRates HTTP failed', [
                    'status' => $response->status(),
                    'body' => $body,
                    'service_type' => $serviceType,
                ]);
                return [
                    'success' => false,
                    'error' => $body['message'] ?? $body['error'] ?? 'Failed to fetch shipping rates',
                ];
            }

            Log::channel('single')->info('[PaxelService] getRates HTTP success', [
                'service_type' => $serviceType,
                'body_keys' => is_array($body) ? array_keys($body) : 'non-array',
            ]);

            return ['success' => true, 'data' => $body];
        } catch (\Throwable $e) {
            Log::channel('single')->error('[PaxelService] getRates exception', [
                'message' => $e->getMessage(),
                'service_type' => $serviceType,
                'trace' => $e->getTraceAsString(),
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Create shipment in Paxel (generate waybill/resi)
     */
    public function createShipment(Order $order): array
    {
        Log::info('[PaxelService] createShipment started', [
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'current_status' => $order->status,
            'has_waybill' => !empty($order->paxel_waybill),
        ]);

        // Check configuration
        if (!$this->isConfigured()) {
            Log::warning('[PaxelService] API not configured', [
                'order_id' => $order->id,
                'has_api_key' => !empty($this->apiKey),
                'has_api_secret' => !empty($this->apiSecret),
            ]);
            return ['success' => false, 'error' => 'Paxel API not configured'];
        }

        // Check if already has waybill
        if ($order->paxel_waybill) {
            Log::warning('[PaxelService] Order already has waybill', [
                'order_id' => $order->id,
                'existing_waybill' => $order->paxel_waybill,
            ]);
            return ['success' => false, 'error' => 'Order already has Paxel waybill'];
        }

        // Check order status
        if (!$order->canBeShipped()) {
            Log::warning('[PaxelService] Order cannot be shipped', [
                'order_id' => $order->id,
                'current_status' => $order->status,
            ]);
            return ['success' => false, 'error' => 'Order status must be payment_confirmed to ship'];
        }

        Log::info('[PaxelService] Loading order data', ['order_id' => $order->id]);
        $origin = config('paxel.origin');
        $order->load(['items.product']);

        Log::info('[PaxelService] Preparing items data', [
            'order_id' => $order->id,
            'items_count' => $order->items->count(),
        ]);

        $items = [];
        $totalWeight = 0;
        $defaultDimension = config('paxel.default_dimension', '30x25x15');

        foreach ($order->items as $index => $item) {
            $product = $item->product;
            $weight = $product?->weight ?? config('paxel.default_weight', 500);
            $weight = max(100, $weight) * $item->quantity;
            $totalWeight += $weight;

            $dimParts = explode('x', $defaultDimension);
            $length = (int) ($dimParts[0] ?? 20);
            $width = (int) ($dimParts[1] ?? 15);
            $height = (int) ($dimParts[2] ?? 10);

            $itemData = [
                'code' => 'SKU-' . ($product?->id ?? $item->product_id) . '-' . ($index + 1),
                'name' => $item->product_name,
                'category' => $product?->category ?? 'Makanan',
                'is_fragile' => false,
                'price' => (float) $item->product_price * $item->quantity,
                'quantity' => $item->quantity,
                'weight' => $weight,
                'length' => $length,
                'width' => $width,
                'height' => $height,
                'hvs_criteria' => [['name_id' => 'Indonesia', 'name_en' => 'Indonesia']],
            ];

            $items[] = $itemData;

            Log::debug('[PaxelService] Item prepared', [
                'order_id' => $order->id,
                'item_index' => $index,
                'item_code' => $itemData['code'],
                'item_name' => $itemData['name'],
                'quantity' => $itemData['quantity'],
                'weight' => $itemData['weight'],
                'price' => $itemData['price'],
            ]);
        }

        if (empty($items)) {
            Log::error('[PaxelService] Order has no items', ['order_id' => $order->id]);
            return ['success' => false, 'error' => 'Order has no items'];
        }

        $totalWeight = max(config('paxel.default_weight', 500), $totalWeight);
        $dimension = str_replace('x', 'x', $defaultDimension);

        Log::info('[PaxelService] Items preparation completed', [
            'order_id' => $order->id,
            'total_items' => count($items),
            'total_weight' => $totalWeight,
            'dimension' => $dimension,
        ]);

        // Prepare destination data
        $destination = [
            'name' => $order->customer_name,
            'email' => $order->customer_email ?? (config('constants.contact.email') ?: 'noreply@rumahbumbu.com'),
            'phone' => preg_replace('/[^0-9]/', '', $order->customer_phone),
            'address' => $order->shipping_address,
            'note' => $order->notes ?? '-',
            'province' => $order->shipping_province ?? $origin['province'],
            'city' => $order->shipping_city ?? $origin['city'],
            'district' => $order->shipping_district ?? $order->shipping_city ?? $origin['district'],
            'village' => $order->shipping_village ?? '',
            'zip_code' => $order->shipping_postal_code ?? $origin['zip_code'],
        ];

        Log::info('[PaxelService] Destination data prepared', [
            'order_id' => $order->id,
            'destination_name' => $destination['name'],
            'destination_city' => $destination['city'],
            'destination_province' => $destination['province'],
            'destination_phone' => substr($destination['phone'], 0, 4) . '****' . substr($destination['phone'], -4), // Mask phone for privacy
        ]);

        // Prepare payload
        // Paxel mensyaratkan pickup_datetime > current time.
        // Untuk aman terhadap perbedaan timezone antara server kita dan Paxel,
        // kita set pickup ke BESOK jam 09:00 (waktu server) sehingga pasti di masa depan.
        $currentTime = now();
        $pickupMoment = $currentTime->copy()->addDay()->setTime(9, 0, 0);
        $pickupDatetime = $pickupMoment->format('Y-m-d H:i:s');
        $serviceType = $order->paxel_service_type ?? config('paxel.default_service_type', 'REGULAR');

        Log::info('[PaxelService] Pickup datetime calculated', [
            'order_id' => $order->id,
            'current_time' => $currentTime->format('Y-m-d H:i:s'),
            'current_timezone' => $currentTime->timezone->getName(),
            'pickup_datetime' => $pickupDatetime,
            'pickup_timezone' => $pickupMoment->timezone->getName(),
        ]);

        $payload = [
            'invoice_number' => $order->order_code,
            'payment_type' => 'CRD',
            'invoice_value' => (float) $order->total,
            'origin' => [
                'name' => $origin['name'],
                'email' => $origin['email'],
                'phone' => preg_replace('/[^0-9]/', '', $origin['phone']),
                'address' => $origin['address'],
                'note' => 'Pickup dari gudang',
                'longitude' => $origin['longitude'],
                'latitude' => $origin['latitude'],
                'province' => $origin['province'],
                'city' => $origin['city'],
                'district' => $origin['district'],
                'village' => $origin['village'],
                'zip_code' => $origin['zip_code'],
            ],
            'destination' => $destination,
            'items' => $items,
            'is_highvalue' => false,
            'pickup_datetime' => $pickupDatetime,
            'need_insurance' => false,
            'note' => $order->notes ?? 'Pesanan ' . $order->order_code,
            'service_type' => $serviceType,
        ];

        Log::info('[PaxelService] Payload prepared', [
            'order_id' => $order->id,
            'invoice_number' => $payload['invoice_number'],
            'invoice_value' => $payload['invoice_value'],
            'service_type' => $serviceType,
            'pickup_datetime' => $pickupDatetime,
            'items_count' => count($items),
            'origin_city' => $origin['city'],
            'destination_city' => $destination['city'],
        ]);

        // Generate signature
        $signature = $this->generateCreateShipmentSignature(
            $order->order_code,
            $origin['name'],
            $order->customer_name,
            $items[0]['name']
        );

        Log::debug('[PaxelService] Signature generated', [
            'order_id' => $order->id,
            'signature_length' => strlen($signature),
            'signature_preview' => substr($signature, 0, 16) . '...',
        ]);

        // Make API request
        $apiUrl = "{$this->baseUrl}/v1/shipments";
        Log::info('[PaxelService] Sending API request to Paxel', [
            'order_id' => $order->id,
            'url' => $apiUrl,
            'method' => 'POST',
            'has_api_key' => !empty($this->apiKey),
            'has_signature' => !empty($signature),
        ]);

        try {
            $startTime = microtime(true);
            $response = Http::withHeaders([
                'X-Paxel-API-Key' => $this->apiKey,
                'X-Paxel-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($apiUrl, $payload);

            $responseTime = round((microtime(true) - $startTime) * 1000, 2); // in milliseconds
            $body = $response->json();

            Log::info('[PaxelService] API response received', [
                'order_id' => $order->id,
                'status_code' => $response->status(),
                'response_time_ms' => $responseTime,
                'response_successful' => $response->successful(),
                'response_keys' => is_array($body) ? array_keys($body) : 'non-array',
            ]);

            if (!$response->successful()) {
                $errorMessage = $body['message'] ?? $body['error'] ?? 'Failed to create shipment';
                
                Log::warning('[PaxelService] API request failed', [
                    'order_id' => $order->id,
                    'status_code' => $response->status(),
                    'error_message' => $errorMessage,
                    'response_body' => $body,
                    'response_time_ms' => $responseTime,
                    'pickup_datetime_sent' => $pickupDatetime,
                    'current_time_when_sent' => $currentTime->format('Y-m-d H:i:s'),
                    'current_time_when_received' => now()->format('Y-m-d H:i:s'),
                ]);
                
                return [
                    'success' => false,
                    'error' => $errorMessage,
                ];
            }

            // Extract waybill
            $waybill = $body['airwaybill_code'] ?? $body['data']['airwaybill_code'] ?? null;
            if (!$waybill) {
                Log::error('[PaxelService] No waybill in response', [
                    'order_id' => $order->id,
                    'response_body' => $body,
                ]);
                return ['success' => false, 'error' => 'No airwaybill code in response'];
            }

            Log::info('[PaxelService] Waybill received from Paxel', [
                'order_id' => $order->id,
                'waybill' => $waybill,
            ]);

            // Update order
            $oldStatus = $order->status;
            $oldWaybill = $order->paxel_waybill;

            Log::info('[PaxelService] Updating order in database', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => 'shipped',
                'old_waybill' => $oldWaybill,
                'new_waybill' => $waybill,
            ]);

            $order->update([
                'paxel_waybill' => $waybill,
                'status' => 'shipped',
                'shipped_at' => now(),
                'paxel_tracking' => array_merge($order->paxel_tracking ?? [], [
                    [
                        'status' => 'created',
                        'description' => 'Shipment created',
                        'datetime' => now()->toIso8601String(),
                    ],
                ]),
            ]);

            Log::info('[PaxelService] Order updated successfully', [
                'order_id' => $order->id,
                'waybill' => $waybill,
                'status' => 'shipped',
            ]);

            return ['success' => true, 'waybill' => $waybill, 'data' => $body];
        } catch (\Throwable $e) {
            Log::error('[PaxelService] Exception during API call', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'error_type' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Track shipment status
     */
    public function trackShipment(string $airwaybillCode): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'error' => 'Paxel API not configured'];
        }

        try {
            $response = Http::withHeaders([
                'X-Paxel-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->get("{$this->baseUrl}/v1/shipments/" . urlencode($airwaybillCode));

            $body = $response->json();

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'error' => $body['message'] ?? $body['error'] ?? 'Failed to track shipment',
                ];
            }

            return ['success' => true, 'data' => $body];
        } catch (\Throwable $e) {
            Log::error('Paxel trackShipment exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Generate signature for Create Shipment
     * Formula: first 2 chars of invoice_number + first 2 chars of origin.name + first 2 chars of destination.name + first 2 chars of first item name + API secret
     */
    protected function generateCreateShipmentSignature(string $invoiceNumber, string $originName, string $destinationName, string $firstItemName): string
    {
        $str = mb_substr($invoiceNumber, 0, 2)
            . mb_substr($originName, 0, 2)
            . mb_substr($destinationName, 0, 2)
            . mb_substr($firstItemName, 0, 2)
            . $this->apiSecret;

        return hash('sha256', $str);
    }

    /**
     * Generate signature for Webhook verification
     * Formula: last 6 chars of airwaybill_code + first 2 chars of latest_status + API secret
     */
    public function generateWebhookSignature(string $airwaybillCode, string $latestStatus): string
    {
        $airwaybillPart = strlen($airwaybillCode) >= 6 ? substr($airwaybillCode, -6) : $airwaybillCode;
        $statusPart = mb_substr($latestStatus, 0, 2);
        $str = $airwaybillPart . $statusPart . $this->apiSecret;

        return hash('sha256', $str);
    }

    /**
     * Verify webhook signature from Paxel
     */
    public function verifyWebhookSignature(string $receivedSignature, string $airwaybillCode, string $latestStatus): bool
    {
        $expected = $this->generateWebhookSignature($airwaybillCode, $latestStatus);
        return hash_equals($expected, $receivedSignature);
    }
}
