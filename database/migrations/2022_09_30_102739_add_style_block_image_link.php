<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStyleBlockImageLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->string('bgcolor')->nullable();
            $table->string('txtcolor')->nullable();
            $table->string('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('bgcolor');
            $table->dropColumn('txtcolor');
            $table->dropColumn('icon');
        });
    }
}
