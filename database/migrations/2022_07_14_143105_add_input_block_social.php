<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputBlockSocial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_socials', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('color')->nullable();
            $table->text('align')->nullable();
            $table->text('title2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_socials', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('color');
            $table->dropColumn('align');
            $table->dropColumn('title2');
        });
    }
}
