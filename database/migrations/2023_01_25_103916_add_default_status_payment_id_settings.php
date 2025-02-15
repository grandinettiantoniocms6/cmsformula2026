<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultStatusPaymentIdSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->unsignedInteger('default_status_id')->nullable();
            $table->boolean('is_pin')->nullable();
            $table->boolean('is_payment')->nullable();
            $table->boolean('is_checkin')->nullable();
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
            $table->dropColumn('default_status_id');
            $table->dropColumn('is_pin');
            $table->dropColumn('is_payment');
            $table->dropColumn('is_checkin');
        });
    }
}
