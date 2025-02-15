<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemVariPluginCounter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_counters', function (Blueprint $table) {
            $table->string('number_color')->nullable();
            $table->string('title_color')->nullable();
            $table->string('subtitle_color')->nullable();
            $table->string('icon_color')->nullable();
            $table->string('icon_size')->nullable();
            $table->string('text_align')->nullable();
            $table->string('counter_size')->nullable();
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
            $table->dropColumn('number_color');
            $table->dropColumn('title_color');
            $table->dropColumn('subtitle_color');
            $table->dropColumn('icon_color');
            $table->dropColumn('icon_size');
            $table->dropColumn('text_align');
            $table->dropColumn('counter_size');

        });
    }
}
