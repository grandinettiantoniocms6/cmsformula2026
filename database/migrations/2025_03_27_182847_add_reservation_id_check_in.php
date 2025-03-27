<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReservationIdCheckIn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_reservations_rooms_checkin', function (Blueprint $table) {
            $table->unsignedInteger("plugin_booking_reservation_id")->nullable();
            $table->string("line_code")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_reservations_rooms_checkin', function (Blueprint $table) {
            $table->dropColumn("plugin_booking_reservation_id");
            $table->dropColumn("line_code");
        });
    }
}
