<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariFieldBlocksSlideshow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->unsignedInteger('text_align')->default(1);
            $table->string('bgcolor')->nullable();
            $table->boolean('is_alphabg')->nullable();
            $table->unsignedInteger('alpha_bgtext')->default(30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->dropColumn('text_align');
            $table->dropColumn('bgcolor');
            $table->dropColumn('is_alphabg');
            $table->dropColumn('alpha_bgtext');
        });
    }
}
