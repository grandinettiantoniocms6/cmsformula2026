<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeHrefInOtherTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_parallaxs', function (Blueprint $table) {
            $table->string('type_href')->default('_self');
        });

        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->string('type_href')->default('_self');
        });

        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->string('type_href')->default('_self');
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->string('type_href')->default('_self');
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->string('type_href')->default('_self');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_parallaxs', function (Blueprint $table) {
            $table->dropColumn('type_href');
        });

        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->dropColumn('type_href');
        });

        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->dropColumn('type_href');
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->dropColumn('type_href');
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->dropColumn('type_href');
        });
    }
}
