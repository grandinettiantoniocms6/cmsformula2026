<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEuroSettingsParking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_parking_setting', function (Blueprint $table) {
            $table->float('euro_park_scoperto')->default(0);
            $table->float('euro_park_coperto')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_parking_setting', function (Blueprint $table) {
            $table->dropColumn('euro_park_scoperto');
            $table->dropColumn('euro_park_coperto');
        });
    }
}
