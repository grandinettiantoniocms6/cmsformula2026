<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginBookingReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_booking_reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->float('total')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->boolean('is_payed')->default(0);
            $table->string('code')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_booking_reservations_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_reservation_id')->nullable();
            $table->unsignedInteger('plugin_booking_room_id')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
        });

        Schema::create('plugins_booking_reservations_rooms_checkin', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_reservation_room_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('numero_carta_identita')->nullable();
            $table->string('scadenza_carta_identita')->nullable();
            $table->string('comune_carta_identita')->nullable();
            $table->string('fiscal_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_booking_reservations');
        Schema::dropIfExists('plugins_booking_reservations_rooms');
        Schema::dropIfExists('plugins_booking_reservations_rooms_checkin');
    }
}
