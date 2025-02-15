<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsShopOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('shop_order_product_extra', function (Blueprint $table) {
            $table->dropColumn('shop_order_product_id');
            $table->unsignedInteger('shop_order_id');
            $table->unsignedInteger('shop_product_id');
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
            $table->dropTimestamps();
        });

        Schema::table('shop_order_product_extra', function (Blueprint $table) {
            $table->unsignedInteger('shop_order_product_id');
            $table->dropColumn('shop_order_id');
            $table->dropColumn('shop_product_id');
        });
    }
}
