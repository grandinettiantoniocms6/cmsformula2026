<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBlocksIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('tags');

            $table->string('title')->nullable();
            $table->string('icon')->nullable();
            $table->string('description')->nullable();

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
        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->longText('content');
            $table->text('tags');

            $table->dropColumn('title');
            $table->dropColumn('icon');
            $table->dropColumn('description');

            $table->dropColumn('block_id');
            $table->dropColumn('parent_id');
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('depth');
        });
    }
}
