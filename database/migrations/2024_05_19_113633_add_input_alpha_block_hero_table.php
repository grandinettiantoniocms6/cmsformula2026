<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputAlphaBlockHeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_heros', function (Blueprint $table) {
            $table->string('alpha')->nullable();
            $table->string('bgcolor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_heros', function (Blueprint $table) {
            $table->dropColumn('alpha');
            $table->dropColumn('bgcolor');
        });
    }
}
