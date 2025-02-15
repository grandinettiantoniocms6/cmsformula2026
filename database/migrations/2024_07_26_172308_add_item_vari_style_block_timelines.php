<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemVariStyleBlockTimelines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_timelines', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('title_color')->nullable();
            $table->string('date_color')->nullable();
            $table->string('bg_color')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_timelines', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('title_color');
            $table->dropColumn('date_color');
            $table->dropColumn('bg_color');

        });
    }
}
