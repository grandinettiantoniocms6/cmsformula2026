<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorpickerBlockIcons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->string('bgcolor')->nullable();
            $table->string('bgcolor_hover')->nullable();
            $table->string('color_icon')->nullable();
            $table->string('bgcolor_button')->nullable();
            $table->string('bgcolor_button_hover')->nullable();
            $table->string('color_text_button')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->dropColumn('bgcolor');
            $table->dropColumn('bgcolor_hover');
            $table->dropColumn('color_icon');
            $table->dropColumn('bgcolor_button');
            $table->dropColumn('bgcolor_button_hover');
            $table->dropColumn('color_text_button');
        });
    }
}
