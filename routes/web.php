<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\TrackingController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;

// Media route - serves files from storage/app/public without symlink (avoids 403 on Hostinger)
Route::get('/media/{path}', [StorageController::class, 'serve'])
    ->where('path', '.*')
    ->name('storage.serve');

// Customer Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/checkout/success/{orderCode}', [CartController::class, 'checkoutSuccess'])->name('cart.checkout-success');
Route::post('/checkout/upload-payment/{orderCode}', [CartController::class, 'uploadPayment'])->name('cart.upload-payment');

// Order Tracking (no login required)
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::get('/tracking/cek', [TrackingController::class, 'show'])->name('tracking.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (with rate limiting)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1'); // 5 attempts per minute
    
    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        
        // Products Management
        Route::resource('products', AdminProductController::class);
        Route::post('products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
        Route::delete('products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('products.force-delete');
        
        // Orders Management
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/{order}/verify-payment', [OrderController::class, 'verifyPayment'])->name('orders.verify-payment');
        Route::post('orders/{order}/create-paxel-shipment', [OrderController::class, 'createPaxelShipment'])->name('orders.create-paxel-shipment');
        Route::post('orders/{order}/refresh-paxel-tracking', [OrderController::class, 'refreshPaxelTracking'])->name('orders.refresh-paxel-tracking');
    });
});
