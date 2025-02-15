<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemTextIconBlockImageLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->text('text_box_icon')->nullable();
            $table->longText('foto3')->nullable();
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
            $table->dropColumn('text_box_icon');
            $table->dropColumn('foto3');
        });
    }
}
