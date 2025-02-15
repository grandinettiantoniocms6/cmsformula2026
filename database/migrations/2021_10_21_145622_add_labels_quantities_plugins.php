<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabelsQuantitiesPlugins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->string('label_qty_success')->nullable();
            $table->string('label_qty_error')->nullable();

            $table->boolean('view_topbar_ecommerce')->nullable();
            $table->boolean('autocomplete_topbar_ecommerce')->nullable();
            $table->boolean('categories_topbar_ecommerce')->nullable();
            $table->boolean('view_price_autocomplete_topbar_ecommerce')->nullable();
            $table->boolean('view_addcart_autocomplete_topbar_ecommerce')->nullable();
            $table->string('topbar_background')->nullable();
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
            $table->dropColumn('label_qty_success');
            $table->dropColumn('label_qty_error');

            $table->dropColumn('view_topbar_ecommerce');
            $table->dropColumn('autocomplete_topbar_ecommerce');
            $table->dropColumn('categories_topbar_ecommerce');
            $table->dropColumn('view_price_autocomplete_topbar_ecommerce');
            $table->dropColumn('view_addcart_autocomplete_topbar_ecommerce');
            $table->dropColumn('topbar_background');
        });
    }
}
