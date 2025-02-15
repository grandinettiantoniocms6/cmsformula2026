<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add3inputBlocksVideobg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_videobgs', function (Blueprint $table) {
            $table->string('controls')->nullable();
            $table->string('autoplay')->nullable();
            $table->string('mute')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_videobgs', function (Blueprint $table) {
            $table->dropColumn('controls');
            $table->dropColumn('autoplay');
            $table->dropColumn('mute');
        });
    }
}
