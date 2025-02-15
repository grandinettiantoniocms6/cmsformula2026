<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsV3PluginsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->float('promo_price')->nullable();
            $table->date('data_promo_start')->nullable();
            $table->date('data_promo_end')->nullable();

            $table->string('custom_1')->nullable();
            $table->string('custom_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->dropColumn('promo_price');
            $table->dropColumn('data_promo_start');
            $table->dropColumn('data_promo_end');

            $table->dropColumn('custom_1');
            $table->dropColumn('custom_2');
        });
    }
}
