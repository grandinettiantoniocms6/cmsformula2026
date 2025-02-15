<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputColorBlockNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_news', function (Blueprint $table) {
            $table->string('bgcolor')->nullable();
            $table->string('date_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_news', function (Blueprint $table) {
            $table->dropColumn('bgcolor');
            $table->dropColumn('date_color');
        });
    }
}
