<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariInputBlockCarousel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('bgcolor')->nullable();
            $table->string('color_title')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('bgcolor');
            $table->dropColumn('color_title');
            $table->dropColumn('description');
        });
    }
}
