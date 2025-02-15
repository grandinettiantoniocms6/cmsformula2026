<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputEtichettaTableBlockGrid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->text('text_etichetta')->nullable();
            $table->string('bgcolor')->nullable();
            $table->string('txtcolor')->nullable();
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
            $table->dropColumn('text_etichetta');
            $table->dropColumn('bgcolor');
            $table->dropColumn('txtcolor');
        });
    }
}
