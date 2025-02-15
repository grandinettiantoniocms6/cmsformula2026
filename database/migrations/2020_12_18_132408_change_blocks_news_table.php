<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBlocksNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_news', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('tags');

            $table->string('title')->nullable();
            $table->text('abstract')->nullable();
            $table->text('description')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('url')->nullable();
            $table->longText('foto')->nullable();
            $table->date('date')->nullable();
            $table->string('category')->nullable();
            $table->string('tag')->nullable();
            $table->string('button')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_default')->default(0);

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
        Schema::table('blocks_news', function (Blueprint $table) {
            $table->longText('content');
            $table->text('tags');

            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('abstract');
            $table->dropColumn('url_interno');
            $table->dropColumn('url');
            $table->dropColumn('foto');
            $table->dropColumn('date');
            $table->dropColumn('category');
            $table->dropColumn('tag');
            $table->dropColumn('button');
            $table->dropColumn('is_active');
            $table->dropColumn('is_default');

            $table->dropColumn('block_id');
            $table->dropColumn('parent_id');
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('depth');
        });
    }
}
