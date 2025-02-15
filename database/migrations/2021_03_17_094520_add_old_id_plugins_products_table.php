<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldIdPluginsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->string('old_id')->nullable();
        });

        Schema::table('plugins_products_attributes', function (Blueprint $table) {
            $table->string('old_id')->nullable();
        });

        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->string('old_id')->nullable();
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
            $table->dropColumn('old_id');
        });

        Schema::table('plugins_products_attributes', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });
    }
}
