<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->longText('email_pin')->nullable();
            $table->longText('email_sollecito')->nullable();
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
            $table->dropColumn('email_pin');
            $table->dropColumn('email_sollecito');
        });
    }
}
