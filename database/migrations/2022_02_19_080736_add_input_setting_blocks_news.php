<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputSettingBlocksNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_news', function (Blueprint $table) {
            $table->text('col')->nullable();
            $table->string('fullwidth')->nullable();
            $table->string('height')->nullable();
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
            $table->dropColumn('col');
            $table->dropColumn('fullwidth');
            $table->dropColumn('height');
        });
    }
}
