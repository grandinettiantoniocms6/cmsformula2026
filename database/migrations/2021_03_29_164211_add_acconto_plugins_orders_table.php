<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccontoPluginsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_orders', function (Blueprint $table) {
            $table->float('acconto')->after("total")->default(0);
        });

        Schema::table('plugins_orders_details', function (Blueprint $table) {
            $table->unsignedInteger('num')->after("price")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_orders', function (Blueprint $table) {
            $table->dropColumn('acconto');
        });

        Schema::table('plugins_orders_details', function (Blueprint $table) {
            $table->dropColumn('num');
        });
    }
}
