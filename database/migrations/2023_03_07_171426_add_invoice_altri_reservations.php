<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceAltriReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable();
            $table->string('vat')->nullable();
            $table->string('pec')->nullable();
            $table->string('sdi')->nullable();

            $table->string('address_invoice')->nullable();
            $table->string('street_invoice')->nullable();
            $table->string('zip_invoice')->nullable();
            $table->string('city_invoice')->nullable();
            $table->string('province_invoice')->nullable();
            $table->string('state_invoice')->nullable();
        });

        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->string('address_invoice')->nullable();
            $table->string('street_invoice')->nullable();
            $table->string('zip_invoice')->nullable();
            $table->string('city_invoice')->nullable();
            $table->string('province_invoice')->nullable();
            $table->string('state_invoice')->nullable();
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
            $table->dropColumn('address_invoice');
            $table->dropColumn('street_invoice');
            $table->dropColumn('zip_invoice');
            $table->dropColumn('city_invoice');
            $table->dropColumn('province_invoice');
            $table->dropColumn('state_invoice');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('business_name');
            $table->dropColumn('vat');
            $table->dropColumn('pec');
            $table->dropColumn('sdi');

            $table->dropColumn('address_invoice');
            $table->dropColumn('street_invoice');
            $table->dropColumn('zip_invoice');
            $table->dropColumn('city_invoice');
            $table->dropColumn('province_invoice');
            $table->dropColumn('state_invoice');
        });
    }
}
