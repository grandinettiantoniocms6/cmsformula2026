<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoolFieldsTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->boolean('is_checkin');
            $table->boolean('is_addiction');
        });

        Schema::create('plugins_booking_rooms_addictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_room_id')->nullable();
            $table->unsignedInteger('room_id')->nullable();
            $table->softDeletes();
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
        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->dropColumn('is_checkin');
            $table->dropColumn('is_addiction');
        });

        Schema::dropIfExists('plugins_booking_rooms_addictions');
    }
}
