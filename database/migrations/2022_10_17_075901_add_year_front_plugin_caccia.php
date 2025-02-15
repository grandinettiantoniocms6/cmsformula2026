<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearFrontPluginCaccia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_caccia_settings', function (Blueprint $table) {
            $table->unsignedInteger('year_front')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_caccia_settings', function (Blueprint $table) {
            $table->dropColumn('year_front');
        });
    }
}
