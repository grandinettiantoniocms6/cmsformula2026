<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksPluginsTimetables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_plugins_timetables', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('download_pdf')->nullable();
            $table->unsignedInteger('plugin_timetable_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks_plugins_timetables');
    }
}
