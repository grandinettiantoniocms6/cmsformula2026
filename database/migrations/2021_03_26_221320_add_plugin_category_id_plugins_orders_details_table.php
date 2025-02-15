<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPluginCategoryIdPluginsOrdersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_orders_details', function (Blueprint $table) {
            $table->unsignedInteger('plugin_category_id')->after('plugin_product_id')->nullable();
        });

        Schema::table('plugins_orders', function (Blueprint $table) {
            $table->dropColumn('plugin_order_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_orders_details', function (Blueprint $table) {
            $table->dropColumn('plugin_category_id');
        });

        Schema::table('plugins_orders', function (Blueprint $table) {
            $table->unsignedInteger('plugin_order_category_id')->nullable();
        });
    }
}
