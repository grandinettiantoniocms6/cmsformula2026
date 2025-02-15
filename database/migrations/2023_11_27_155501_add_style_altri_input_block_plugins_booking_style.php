<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStyleAltriInputBlockPluginsBookingStyle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_plugin_booking_search_types', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('bgcolor')->nullable();
            $table->string('padding')->nullable();
            $table->longText('foto')->nullable();
            $table->string('alpha')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_plugin_booking_search_types', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('bgcolor');
            $table->dropColumn('padding');
            $table->dropColumn('foto');
            $table->dropColumn('alpha');
            $table->dropColumn('description');

        });
    }
}
