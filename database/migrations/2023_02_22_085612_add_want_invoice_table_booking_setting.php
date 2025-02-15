<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWantInvoiceTableBookingSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->boolean("want_invoice")->default(0);
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
            $table->dropColumn('want_invoice');
        });
    }
}
