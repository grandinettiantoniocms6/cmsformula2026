<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageOrIconInputPluginCounter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_counters', function (Blueprint $table) {
            $table->longText('foto')->nullable();
            $table->text('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_counters', function (Blueprint $table) {
            $table->dropColumn('foto');
            $table->dropColumn('icon');
        });
    }
}
