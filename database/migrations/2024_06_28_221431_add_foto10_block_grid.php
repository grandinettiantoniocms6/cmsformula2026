<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoto10BlockGrid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->longText('foto2')->nullable();
            $table->longText('foto3')->nullable();
            $table->longText('foto4')->nullable();
            $table->longText('foto5')->nullable();
            $table->longText('foto6')->nullable();
            $table->longText('foto7')->nullable();
            $table->longText('foto8')->nullable();
            $table->longText('foto9')->nullable();

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
            $table->dropColumn('foto2');
            $table->dropColumn('foto3');
            $table->dropColumn('foto4');
            $table->dropColumn('foto5');
            $table->dropColumn('foto6');
            $table->dropColumn('foto7');
            $table->dropColumn('foto8');
            $table->dropColumn('foto9');
        });
    }
}
