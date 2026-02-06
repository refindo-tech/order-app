<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            
            // Customer Information (Guest Checkout)
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            
            // Shipping Information
            $table->text('shipping_address');
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_province')->nullable();
            
            // Order Details
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            
            // Status
            $table->enum('status', [
                'pending_payment',
                'payment_verification',
                'payment_confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending_payment');
            
            // Paxel Integration
            $table->string('paxel_waybill')->nullable();
            $table->json('paxel_tracking')->nullable();
            $table->timestamp('shipped_at')->nullable();
            
            // Notes
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
