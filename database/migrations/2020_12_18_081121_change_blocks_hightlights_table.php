<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBlocksHightlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('tags');

            $table->string('title')->nullable();
            $table->string('abstract')->nullable();
            $table->text('description')->nullable();
            $table->string('background_color')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('url')->nullable();
            $table->longText('foto')->nullable();
            $table->string('button')->nullable();

            $table->unsignedInteger('block_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->longText('content');
            $table->text('tags');

            $table->dropColumn('title');
            $table->dropColumn('abstract');
            $table->dropColumn('description');
            $table->dropColumn('background_color');
            $table->dropColumn('url_interno');
            $table->dropColumn('url');
            $table->dropColumn('foto');
            $table->dropColumn('button');

            $table->dropColumn('block_id');
            $table->dropColumn('parent_id');
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('depth');
        });
    }
}
