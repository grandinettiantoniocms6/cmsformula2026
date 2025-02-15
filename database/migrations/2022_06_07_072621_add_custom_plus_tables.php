<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomPlusTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_extra', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->float('price')->nullable();
            $table->boolean('is_active')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('shop_cart', function (Blueprint $table) {
            $table->unsignedInteger('extra_id')->nullable();
            $table->string('extra_value')->nullable();
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->unsignedInteger('extra_id')->nullable();
            $table->string('extra_value')->nullable();
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
            $table->dropColumn('extra_id');
            $table->dropColumn('extra_value');
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->dropColumn('extra_id');
            $table->dropColumn('extra_value');
        });

        Schema::dropIfExists('shop_extra');
    }
}
