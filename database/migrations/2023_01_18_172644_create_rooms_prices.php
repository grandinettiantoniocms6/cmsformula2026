<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_booking_rooms_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_room_id')->nullable();
            $table->float('price')->nullable();
            $table->unsignedInteger('min')->nullable();
            $table->unsignedInteger('max')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_booking_rooms_promos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_room_id')->nullable();
            $table->float('discount')->nullable();
            $table->unsignedInteger('type_discount')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->unsignedInteger('condition_discount')->nullable();
            $table->unsignedInteger('rule_discount')->nullable();
            $table->unsignedInteger('value_discount')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('plugins_booking_rooms_services', function (Blueprint $table) {
            $table->unsignedInteger('lft')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_booking_rooms_prices');
        Schema::dropIfExists('plugins_booking_rooms_promos');

        Schema::table('plugins_booking_rooms_services', function (Blueprint $table) {
            $table->dropColumn('lft');
        });
    }
}
