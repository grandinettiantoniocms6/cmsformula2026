<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBambiniPluginBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->unsignedInteger('min_anni_bambini')->default("0");
            $table->unsignedInteger('max_anni_bambini')->default("0");
            $table->unsignedInteger('qty_bambini')->default("0");
            $table->float('price_bambini')->default("0");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->dropColumn('min_anni_bambini');
            $table->dropColumn('max_anni_bambini');
            $table->dropColumn('qty_bambini');
            $table->dropColumn('price_bambini');
        });
    }
}
