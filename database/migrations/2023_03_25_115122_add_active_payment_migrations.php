<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivePaymentMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::table('plugins_booking_settings', function (Blueprint $table) {
                $table->unsignedInteger('active_payment');
                $table->unsignedInteger('default_status_id');
                $table->unsignedInteger('default_status_payment_id');
                $table->text('email_pin');
                $table->text('email_sollecito');
            });
        } catch (Throwable $e) {
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            Schema::table('plugins_booking_settings', function (Blueprint $table) {
                $table->dropColumn('active_payment');
                $table->dropColumn('default_status_id');
                $table->dropColumn('default_status_payment_id');
                $table->dropColumn('email_pin');
                $table->dropColumn('email_sollecito');
            });
        } catch (Throwable $e) {
        }
    }
}
