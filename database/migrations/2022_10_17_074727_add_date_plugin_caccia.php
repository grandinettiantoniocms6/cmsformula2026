<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatePluginCaccia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_caccia_hunters_chiefs', function (Blueprint $table) {
            $table->date('date_accept')->nullable();
            $table->date("date_esito")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_caccia_hunters_chiefs', function (Blueprint $table) {
            $table->dropColumn('date_accept');
            $table->dropColumn('date_esito');
        });
    }
}
