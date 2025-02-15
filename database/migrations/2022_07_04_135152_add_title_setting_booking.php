<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleSettingBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->text('image')->nullable();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->unsignedInteger('image_height')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('title');
            $table->dropColumn('subtitle');
            $table->dropColumn('image_height');
            $table->dropColumn('email');
        });
    }
}
