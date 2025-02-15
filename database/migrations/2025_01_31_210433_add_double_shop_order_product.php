<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoubleShopOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->float('price', 13, 3)->change();
            $table->float('price_with_tax', 13, 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->float('price', 13, 2)->change();
            $table->float('price_with_tax', 13, 2)->change();
        });
    }
}
