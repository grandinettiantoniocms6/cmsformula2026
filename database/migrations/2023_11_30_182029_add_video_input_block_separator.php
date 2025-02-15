<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoInputBlockSeparator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_separators', function (Blueprint $table) {
            $table->string('video')->nullable();
            $table->string('video_height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_separators', function (Blueprint $table) {
            $table->dropColumn('video');
            $table->dropColumn('video_height');
        });
    }
}
