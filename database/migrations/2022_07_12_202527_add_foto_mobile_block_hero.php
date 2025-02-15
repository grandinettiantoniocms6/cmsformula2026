<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoMobileBlockHero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_heros', function (Blueprint $table) {
            $table->longText('foto_mobile_1')->nullable();
            $table->longText('foto_mobile_2')->nullable();
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
            $table->dropColumn('foto_mobile_1');
            $table->dropColumn('foto_mobile_2');
        });
    }
}
