<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotosBlocksHtmlimages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->longText('foto6')->nullable();
            $table->longText('foto7')->nullable();
            $table->longText('foto8')->nullable();
            $table->longText('foto9')->nullable();
            $table->longText('foto10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->dropColumn('foto6');
            $table->dropColumn('foto7');
            $table->dropColumn('foto8');
            $table->dropColumn('foto9');
            $table->dropColumn('foto10');
        });
    }
}
