<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemVariBlockPluginCounter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_plugins_counters', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('height')->nullable();
            $table->string('col')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_plugins_counters', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('height');
            $table->dropColumn('col');
        });
    }
}
