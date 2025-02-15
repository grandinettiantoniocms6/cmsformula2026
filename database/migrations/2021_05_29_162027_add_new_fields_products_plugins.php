<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsProductsPlugins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->string('code_article')->nullable();
            $table->float('price_srp')->nullable();
            $table->float('price_dollar')->nullable();
            $table->float('price_srp_dollar')->nullable();
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
            $table->dropColumn('code_article');
            $table->dropColumn('price_srp');
            $table->dropColumn('price_dollar');
            $table->dropColumn('price_srp_dollar');
        });
    }
}
