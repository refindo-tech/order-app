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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_district')->nullable()->after('shipping_province');
            $table->string('shipping_village')->nullable()->after('shipping_district');
            $table->string('paxel_service_type')->nullable()->after('paxel_waybill')->comment('e.g. REGULAR, NEXTDAY');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_district', 'shipping_village', 'paxel_service_type']);
        });
    }
};
