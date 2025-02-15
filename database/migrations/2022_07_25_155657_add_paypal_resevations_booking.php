<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalResevationsBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->float('year')->nullable();
            $table->float('number_invoice')->nullable();
            $table->text('result_paypal')->nullable();
            $table->string('paypal_payment_id')->nullable();
            $table->dateTime('payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->dropColumn('year');
            $table->dropColumn('number_invoice');
            $table->dropColumn('result_paypal');
            $table->dropColumn('paypal_payment_id');
            $table->dropColumn('payment_date');
        });
    }
}
