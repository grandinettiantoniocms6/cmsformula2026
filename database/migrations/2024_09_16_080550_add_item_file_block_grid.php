<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemFileBlockGrid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->longText('file')->nullable();
            $table->string('box_bgcolor')->nullable();
            $table->string('title_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->dropColumn('box_bgcolor');
            $table->dropColumn('title_color');
        });
    }
}
