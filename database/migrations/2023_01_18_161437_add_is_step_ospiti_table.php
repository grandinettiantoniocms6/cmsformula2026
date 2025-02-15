<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsStepOspitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->boolean('is_step_ospiti')->nullable();
        });

        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('promo_price');
            $table->dropColumn('data_promo_start');
            $table->dropColumn('data_promo_end');
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
            $table->dropColumn('is_step_ospiti');
        });

        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->float('price');
            $table->float('promo_price');
            $table->date('data_promo_start');
            $table->date('data_promo_end');
        });
    }
}
