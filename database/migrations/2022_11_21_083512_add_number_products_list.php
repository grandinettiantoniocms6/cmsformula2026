<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberProductsList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->unsignedInteger('number_product_mobile')->default(12);
            $table->unsignedInteger('col_products_for_row')->default(4);
            $table->boolean('show_banner')->default(1);
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
            $table->dropColumn('col_products_for_row');
            $table->dropColumn('number_product_mobile');
            $table->dropColumn('show_banner');
        });
    }
}
