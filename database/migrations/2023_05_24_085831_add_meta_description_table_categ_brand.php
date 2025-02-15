<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaDescriptionTableCategBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->text('meta_description')->nullable();
        });

        Schema::table('plugins_products_brands', function (Blueprint $table) {
            $table->text('meta_description')->nullable();
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
            $table->dropColumn('meta_description');
        });

        Schema::table('plugins_products_brands', function (Blueprint $table) {
            $table->dropColumn('meta_description');
        });
    }
}
