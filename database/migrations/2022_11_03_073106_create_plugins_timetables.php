<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsTimetables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_timetables', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('abstract')->nullable();
            $table->text('logo')->nullable();
            $table->text('foto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_timetables_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_timetable_id')->nullable();
            $table->unsignedInteger('day')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_special')->nullable();
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
        Schema::dropIfExists('plugins_timetables');
        Schema::dropIfExists('plugins_timetables_days');
    }
}
