<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\PaxelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingController extends Controller
{
    public function __construct(
        protected PaxelService $paxelService
    ) {}

    /**
     * Get shipping rates for checkout
     */
    public function getRates(Request $request)
    {
        Log::channel('single')->info('[Cek Ongkir] START', [
            'step' => 'request_received',
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
        ]);

        $request->validate([
            'address' => 'required|string|max:350',
            'province' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'district' => 'nullable|string|max:50',
            'village' => 'nullable|string|max:50',
            'zip_code' => 'nullable|string|max:10',
            'weight' => 'nullable|integer|min:1',
            'cart_data' => 'required|json',
        ]);

        $cartData = json_decode($request->cart_data, true);
        $weight = (int) $request->weight;
        if ($weight <= 0 && !empty($cartData)) {
            $productIds = array_unique(array_column($cartData, 'id'));
            $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');
            foreach ($cartData as $item) {
                $product = $products[$item['id']] ?? null;
                $itemWeight = $product?->weight ?? ($item['weight'] ?? 500);
                $weight += $itemWeight * ($item['quantity'] ?? 1);
            }
            $weight = max(500, $weight);
        }
        $weight = max(500, $weight ?: config('paxel.default_weight', 1000));

        Log::channel('single')->info('[Cek Ongkir] Weight calculated', [
            'step' => 'weight',
            'weight_grams' => $weight,
            'paxel_configured' => $this->paxelService->isConfigured(),
        ]);

        $destination = [
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district ?? $request->city,
            'village' => $request->village ?? '',
            'zip_code' => $request->zip_code ?? '',
        ];

        $dimension = config('paxel.default_dimension', '30x25x15');
        $serviceDefs = config('paxel.services', []);
        $disabledServices = config('paxel.disabled_services', []);
        $serviceTypes = array_keys($serviceDefs);

        $rates = [];
        foreach ($serviceTypes as $serviceType) {
            $def = $serviceDefs[$serviceType] ?? [];
            $label = $def['label'] ?? $serviceType;
            $description = $def['description'] ?? '';
            $defaultEtd = $def['etd'] ?? '2-3 hari';
            $isForcedDisabled = in_array($serviceType, $disabledServices, true);

            $result = $this->paxelService->getRates(
                $destination,
                $weight,
                $dimension,
                $serviceType
            );

            Log::channel('single')->info('[Cek Ongkir] Paxel getRates result', [
                'step' => 'paxel_response',
                'service_type' => $serviceType,
                'success' => $result['success'] ?? false,
                'has_data' => isset($result['data']),
                'error' => $result['error'] ?? null,
            ]);

            $price = null;
            $etd = $defaultEtd;
            if ($result['success'] && isset($result['data'])) {
                $data = $result['data'];
                $inner = $data['data'] ?? [];
                $price = $data['actual_price']
                    ?? $data['price']
                    ?? $data['rate']
                    ?? $inner['fixed_price']
                    ?? $inner['custom_price']
                    ?? $inner['large_price']
                    ?? $inner['medium_price']
                    ?? $inner['small_price']
                    ?? null;
                $etd = $data['etd'] ?? $data['estimated_delivery'] ?? $defaultEtd;
            }

            $enabled = !$isForcedDisabled && $price !== null;
            $unavailableReason = null;
            if (!$enabled) {
                if ($isForcedDisabled) {
                    $unavailableReason = 'Belum tersedia';
                } elseif ($result['success'] && $price === null) {
                    $unavailableReason = 'Tarif tidak tersedia untuk area ini';
                } else {
                    $unavailableReason = $result['error'] ?? 'Belum tersedia';
                }
            }

            $rates[] = [
                'service_type' => $serviceType,
                'label' => $label,
                'description' => $description,
                'etd' => $etd,
                'price' => $enabled ? (float) $price : null,
                'enabled' => $enabled,
                'unavailable_reason' => $unavailableReason,
            ];

            if ($enabled) {
                Log::channel('single')->info('[Cek Ongkir] Rate extracted', ['service_type' => $serviceType, 'price' => $price]);
            } else {
                Log::channel('single')->warning('[Cek Ongkir] Service unavailable', [
                    'service_type' => $serviceType,
                    'reason' => $unavailableReason,
                ]);
            }
        }

        // If no enabled rates (all failed/disabled), enable fallback
        $enabledCount = collect($rates)->where('enabled', true)->count();
        if ($enabledCount === 0) {
            $freeThreshold = config('constants.shipping.free_shipping_threshold', 500000);
            $cartData = json_decode($request->cart_data, true);
            $subtotal = collect($cartData)->sum(fn ($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 0));

            $defaultRate = 25000;
            if ($subtotal >= $freeThreshold) {
                $defaultRate = 0;
            }

            Log::channel('single')->warning('[Cek Ongkir] FALLBACK - No Paxel rates, using dummy', [
                'step' => 'fallback',
                'reason' => 'paxel_no_enabled_rates',
                'subtotal' => $subtotal,
                'default_rate' => $defaultRate,
            ]);

            // Set first REGULAR as fallback if exists, else prepend generic fallback
            $regularIdx = null;
            foreach ($rates as $i => $r) {
                if (($r['service_type'] ?? '') === 'REGULAR') {
                    $regularIdx = $i;
                    break;
                }
            }
            if ($regularIdx !== null) {
                $rates[$regularIdx]['enabled'] = true;
                $rates[$regularIdx]['price'] = $defaultRate;
                $rates[$regularIdx]['unavailable_reason'] = null;
                $rates[$regularIdx]['label'] = 'Pengiriman Standar (perkiraan)';
                $rates[$regularIdx]['description'] = 'Perkiraan ongkir — tarif final dapat berubah.';
            } else {
                array_unshift($rates, [
                    'service_type' => 'REGULAR',
                    'label' => 'Pengiriman Standar (perkiraan)',
                    'description' => 'Perkiraan ongkir — tarif final dapat berubah.',
                    'etd' => '2-3 hari',
                    'price' => $defaultRate,
                    'enabled' => true,
                    'unavailable_reason' => null,
                ]);
            }
        } else {
            Log::channel('single')->info('[Cek Ongkir] SUCCESS - Paxel rates used', [
                'step' => 'success',
                'rates_count' => count($rates),
                'enabled_count' => $enabledCount,
            ]);
        }

        Log::channel('single')->info('[Cek Ongkir] END', [
            'step' => 'response',
            'rates' => $rates,
        ]);

        return response()->json([
            'success' => true,
            'rates' => $rates,
        ]);
    }
}
