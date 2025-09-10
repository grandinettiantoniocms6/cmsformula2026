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
        Schema::table('shop_cart', function (Blueprint $table) {
            $table->float('price_unit', 13, 3);
            $table->float('price_add', 13, 3);
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->float('price_unit', 13, 3);
            $table->float('price_add', 13, 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_cart', function (Blueprint $table) {
            $table->dropColumn('price_unit');
            $table->dropColumn('price_add');
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->dropColumn('price_unit');
            $table->dropColumn('price_add');
        });
    }
};
