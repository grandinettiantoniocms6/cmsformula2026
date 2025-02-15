<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariInputFormBookingBlockSlideshow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->string('form_booking_bgcolor')->nullable();
            $table->string('form_booking_top')->nullable();
            $table->string('form_booking_border_radius')->nullable();
            $table->string('form_booking_border_color')->nullable();
            $table->string('form_booking_border_width')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->dropColumn('form_booking_bgcolor');
            $table->dropColumn('form_booking_top');
            $table->dropColumn('form_booking_border_radius');
            $table->dropColumn('form_booking_border_color');
            $table->dropColumn('form_booking_border_width');
        });
    }
}
