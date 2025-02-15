<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputPbBlockhtmltwocol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_htmltwocols', function (Blueprint $table) {
            $table->unsignedInteger('pb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_htmltwocols', function (Blueprint $table) {
            $table->dropColumn('pb');
        });
    }
}
