<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultPbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_htmltwocols', function (Blueprint $table) {
            $table->unsignedInteger('pb')->default(50)->change();
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->unsignedInteger('pb')->default(50)->change();
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->unsignedInteger('pb')->default(50)->change();
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
            $table->unsignedInteger('pb')->nullable()->change();
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->unsignedInteger('pb')->nullable()->change();
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->unsignedInteger('pb')->nullable()->change();
        });
    }
}
