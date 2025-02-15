<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemColorBottonActiveBlockReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_references', function (Blueprint $table) {
            $table->string('background_color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('text_color')->nullable();

            $table->string('box_color')->nullable();
            $table->string('title_color')->nullable();
            $table->string('subtitle_color')->nullable();

            $table->string('background_color_cat')->nullable();
            $table->string('border_color_cat')->nullable();
            $table->string('text_color_cat')->nullable();

            $table->string('background_color_btn')->nullable();
            $table->string('border_color_btn')->nullable();
            $table->string('text_color_btn')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_references', function (Blueprint $table) {
            $table->dropColumn('background_color');
            $table->dropColumn('border_color');
            $table->dropColumn('text_color');

            $table->dropColumn('box_color');
            $table->dropColumn('title_color');
            $table->dropColumn('subtitle_color');

            $table->dropColumn('background_color_cat');
            $table->dropColumn('border_color_cat');
            $table->dropColumn('text_color_cat');

            $table->dropColumn('background_color_btn');
            $table->dropColumn('border_color_btn');
            $table->dropColumn('text_color_btn');

        });
    }
}
