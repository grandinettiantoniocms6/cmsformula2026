<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputVariBlockCollage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_collages', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('mt')->nullable();
            $table->string('pb')->nullable();
            $table->string('fullwidth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_collages', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('mt');
            $table->dropColumn('pb');
            $table->dropColumn('fullwidth');
        });
    }
}
