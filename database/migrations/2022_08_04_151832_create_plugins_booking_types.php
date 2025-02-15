<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsBookingTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_booking_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedInteger('type_booking')->nullable();
            $table->timestamps();
        });

        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->unsignedInteger('plugin_booking_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_booking_types');

        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->dropColumn('plugin_booking_type_id');
        });
    }
}
