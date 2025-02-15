<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariInputBlockTab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_tabs', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('bgcolor')->nullable();
            $table->string('btn_color_active')->nullable();
            $table->string('btn_color_hover')->nullable();
            $table->string('btn_txt_color')->nullable();
            $table->string('mt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_tabs', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('bgcolor');
            $table->dropColumn('btn_color_active');
            $table->dropColumn('btn_color_hover');
            $table->dropColumn('btn_txt_color');
            $table->dropColumn('mt');
        });
    }
}
