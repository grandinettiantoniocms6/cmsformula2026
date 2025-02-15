<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcnEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->longText('ccn_registered')->nullable();
            $table->longText('ccn_ordered')->nullable();
        });

        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->longText('ccn_registered')->nullable();
            $table->longText('ccn_ordered')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->dropColumn('ccn_registered');
            $table->dropColumn('ccn_ordered');
        });

        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->dropColumn('ccn_registered');
            $table->dropColumn('ccn_ordered');
        });
    }
}
