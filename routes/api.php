<?php

use App\Http\Controllers\Api\PaxelWebhookController;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Customer\ShippingController;
use Illuminate\Support\Facades\Route;

// Paxel Webhook (no auth - called by Paxel servers)
Route::post('paxel/webhook', PaxelWebhookController::class)->name('paxel.webhook');

// Shipping rates (for checkout - can be called from frontend)
Route::post('shipping/rates', [ShippingController::class, 'getRates'])->name('shipping.rates');

// Wilayah Indonesia proxy (bypass CORS)
Route::get('wilayah/provinces', [WilayahController::class, 'provinces']);
Route::get('wilayah/regencies/{provinceId}', [WilayahController::class, 'regencies']);
Route::get('wilayah/districts/{regencyId}', [WilayahController::class, 'districts']);
