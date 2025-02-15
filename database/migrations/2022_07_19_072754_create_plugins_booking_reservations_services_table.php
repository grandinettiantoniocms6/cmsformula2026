<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsBookingReservationsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_booking_reservations_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_reservation_id')->nullable();
            $table->unsignedInteger('plugin_booking_service_id')->nullable();
            $table->string('name')->nullable();
            $table->float('price')->nullable();
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
        Schema::dropIfExists('plugins_booking_reservations_services');
    }
}
