<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_cart', function (Blueprint $table) {
            $table->dropColumn('extra_id');
            $table->dropColumn('extra_value');
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->dropColumn('extra_id');
            $table->dropColumn('extra_value');
        });

        Schema::create('shop_cart_extra', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cart_id')->nullable();
            $table->unsignedInteger('extra_id')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::create('shop_order_product_extra', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('shop_order_product_id')->nullable();
            $table->unsignedInteger('extra_id')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_cart', function (Blueprint $table) {
            $table->unsignedInteger('extra_id')->nullable();
            $table->string('extra_value')->nullable();
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->unsignedInteger('extra_id')->nullable();
            $table->string('extra_value')->nullable();
        });

        Schema::dropIfExists('shop_cart_extra');
        Schema::dropIfExists('shop_order_product_extra');
    }
}
