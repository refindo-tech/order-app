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
        if (! Schema::hasTable('articles')) {
            return;
        }

        if (Schema::hasColumn('articles', 'category')) {
            return;
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->string('category', 100)->nullable()->after('author_name')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('articles') || ! Schema::hasColumn('articles', 'category')) {
            return;
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
