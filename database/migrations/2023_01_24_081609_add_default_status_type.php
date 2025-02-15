<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultStatusType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->unsignedInteger('default_status_id')->nullable();
            $table->boolean('is_pin');
            $table->text('email');
            $table->text('email_pin');
            $table->text('email_sollecito');
        });

        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->dropColumn('active_payment');
            $table->dropColumn('default_status_id');
            $table->dropColumn('default_status_payment_id');
            $table->dropColumn('email_pin');
            $table->dropColumn('email_sollecito');
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
            $table->dropColumn('default_status_id');
            $table->dropColumn('is_pin');
            $table->dropColumn('email');
            $table->dropColumn('email_sollecito');
            $table->dropColumn('email_pin');
        });

        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->unsignedInteger('active_payment');
            $table->unsignedInteger('default_status_id');
            $table->unsignedInteger('default_status_payment_id');
            $table->text('email_pin');
            $table->text('email_sollecito');
        });
    }
}
