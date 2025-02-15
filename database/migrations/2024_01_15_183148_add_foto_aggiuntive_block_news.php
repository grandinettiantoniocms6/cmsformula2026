<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoAggiuntiveBlockNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_news', function (Blueprint $table) {
            $table->longText('foto2')->nullable();
            $table->longText('foto3')->nullable();
            $table->longText('foto4')->nullable();
            $table->longText('foto5')->nullable();
            $table->longText('foto6')->nullable();
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
            $table->dropColumn('foto2');
            $table->dropColumn('foto3');
            $table->dropColumn('foto4');
            $table->dropColumn('foto5');
            $table->dropColumn('foto6');
        });
    }
}
