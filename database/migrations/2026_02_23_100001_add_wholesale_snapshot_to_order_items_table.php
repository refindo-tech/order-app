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
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('product_normal_price', 12, 2)->nullable()->after('product_price');
            $table->decimal('product_grosir_price', 12, 2)->nullable()->after('product_normal_price');
            $table->boolean('is_grosir_applied')->default(false)->after('product_grosir_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['product_normal_price', 'product_grosir_price', 'is_grosir_applied']);
        });
    }
};
