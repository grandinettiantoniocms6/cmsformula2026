<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVetIdsPluginsProductsSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_search', function (Blueprint $table) {
            $table->longText("vet_ids_list")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products_search', function (Blueprint $table) {
            $table->dropColumn('vet_ids_list');
        });
    }
}
