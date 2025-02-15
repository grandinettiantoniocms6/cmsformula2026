<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsNewPluginsProductsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->boolean('is_price_on_demand')->default(0);
            $table->boolean('is_add_to_cart')->default(1);
            $table->boolean('is_qty_infinite')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->dropColumn('is_price_on_demand');
            $table->dropColumn('is_add_to_cart');
            $table->dropColumn('is_qty_infinite');
        });
    }
}
