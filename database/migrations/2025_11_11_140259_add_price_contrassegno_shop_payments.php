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
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->float("price_contrassegno")->default(0);
            $table->float("total_min_cart_contrassegno")->default(0);
            $table->float("total_max_cart_contrassegno")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->dropColumn("price_contrassegno");
            $table->dropColumn("total_min_cart_contrassegno");
            $table->dropColumn("total_max_cart_contrassegno");
        });
    }
};
