<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoicesFieldsReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->string('business_name')->nullable();
            $table->string('vat')->nullable();
            $table->string('pec')->nullable();
            $table->string('sdi')->nullable();
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
            $table->dropColumn('business_name');
            $table->dropColumn('vat');
            $table->dropColumn('pec');
            $table->dropColumn('sdi');
        });
    }
}
