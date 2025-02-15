<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullwidthBlockPortfolio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_portfolios', function (Blueprint $table) {
            $table->string('fullwidth')->nullable();
            $table->string('col')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_portfolios', function (Blueprint $table) {
            $table->dropColumn('fullwidth');
            $table->dropColumn('col');
        });
    }
}
