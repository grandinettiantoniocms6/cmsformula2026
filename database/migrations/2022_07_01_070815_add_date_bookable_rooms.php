<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateBookableRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->date('data_bookable_start')->nullable();
            $table->date('data_bookable_end')->nullable();
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
            $table->dropColumn('data_bookable_start');
            $table->dropColumn('data_bookable_end');
        });
    }
}
