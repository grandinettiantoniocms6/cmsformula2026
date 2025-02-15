<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinDayMaxRoomPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_rooms_prices', function (Blueprint $table) {
            $table->unsignedInteger('min_day')->default(1);
            $table->unsignedInteger('max_day')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_rooms_prices', function (Blueprint $table) {
            $table->dropColumn('min_day');
            $table->dropColumn('max_day');
        });
    }
}
