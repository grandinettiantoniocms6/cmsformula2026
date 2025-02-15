<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_contacts', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_html', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_images', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_news', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_parallaxs', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_socials', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });

        Schema::table('blocks_tabs', function (Blueprint $table) {
            $table->string('label')->nullable();
            $table->boolean('reorder')->default(0);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_contacts', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_html', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_images', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_news', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_parallaxs', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_socials', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });

        Schema::table('blocks_tabs', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn('reorder');
        });


    }
}
