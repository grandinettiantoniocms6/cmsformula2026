<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPurchasablePluginsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->boolean('is_purchasable')->default(1);
        });

        Schema::table('plugins_products_brands', function (Blueprint $table) {
            $table->boolean('is_purchasable')->default(1);
        });

        Schema::table('plugins_products', function (Blueprint $table) {
            $table->boolean('is_purchasable')->default(1);
            $table->renameColumn('qty_year', 'qty_max');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->dropColumn('is_purchasable');
        });

        Schema::table('plugins_products_brands', function (Blueprint $table) {
            $table->dropColumn('is_purchasable');
        });

        Schema::table('plugins_products', function (Blueprint $table) {
            $table->dropColumn('is_purchasable');
            $table->renameColumn('qty_max', 'qty_year');
        });
    }
}
