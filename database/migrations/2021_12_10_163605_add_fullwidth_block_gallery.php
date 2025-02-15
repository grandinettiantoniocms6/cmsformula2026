<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullwidthBlockGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->string('normal')->nullable();
            $table->string('fullwidth')->nullable();
            //$table->string('col')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->dropColumn('normal');
            $table->dropColumn('fullwidth');
            //$table->dropColumn('col');
        });
    }
}
