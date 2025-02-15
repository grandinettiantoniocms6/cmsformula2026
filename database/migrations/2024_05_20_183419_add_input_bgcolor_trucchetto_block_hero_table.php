<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputBgcolorTrucchettoBlockHeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::table('blocks_heros', function (Blueprint $table) {
                $table->string('bgcolor')->nullable();
            });
        } catch (Throwable $e) {
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            Schema::table('blocks_heros', function (Blueprint $table) {
                $table->dropColumn('bgcolor');
            });
        } catch (Throwable $e) {
        }
    }
}
