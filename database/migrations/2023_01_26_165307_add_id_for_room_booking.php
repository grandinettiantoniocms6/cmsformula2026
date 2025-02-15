<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdForRoomBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::table('plugins_booking_rooms_prices', function (Blueprint $table) {
                $table->unsignedInteger('plugin_booking_room_id')->nullable();
            });

            Schema::table('plugins_booking_rooms_promos', function (Blueprint $table) {
                $table->unsignedInteger('plugin_booking_room_id')->nullable();
            });
        } catch (Throwable $e) {
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_rooms_prices', function (Blueprint $table) {
            $table->dropColumn('plugin_booking_room_id');
        });

        Schema::table('plugins_booking_rooms_promos', function (Blueprint $table) {
            $table->dropColumn('plugin_booking_room_id');
        });
    }
}
