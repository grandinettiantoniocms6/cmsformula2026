<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultStatusId extends Migration
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
            $table->unsignedInteger('default_status_payment_id')->nullable();
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
            $table->dropColumn('default_status_payment_id');
        });
    }
}
