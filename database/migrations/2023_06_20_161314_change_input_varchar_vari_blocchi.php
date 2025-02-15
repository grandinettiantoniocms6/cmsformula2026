<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInputVarcharVariBlocchi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_news', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('slug')->nullable()->change();
            $table->text('category')->nullable()->change();
            $table->text('tag')->nullable()->change();
        });

        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->text('name')->nullable()->change();
            $table->text('label')->nullable()->change();
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_heros', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
        });

        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('abstract')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_contacts', function (Blueprint $table) {
            $table->text('object_form')->nullable()->change();
            $table->text('message_ringraziamento')->nullable()->change();
        });

        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_tabs', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
        });

        Schema::table('blocks_parallaxs', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('abstract')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_portfolio2s', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
        });

        Schema::table('blocks_references', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_banners', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_metros', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_htmltwocols', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_collages', function (Blueprint $table) {
            $table->text('title_dx')->nullable()->change();
            $table->text('title_sx')->nullable()->change();
            $table->text('url_dx_interno')->nullable()->change();
            $table->text('url_dx')->nullable()->change();
            $table->text('button_dx')->nullable()->change();
            $table->text('url_sx_interno')->nullable()->change();
            $table->text('url_sx')->nullable()->change();
            $table->text('button_sx')->nullable()->change();
        });

        Schema::table('blocks_flussos', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_timelines', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('date')->nullable()->change();
        });

        Schema::table('blocks_staffs', function (Blueprint $table) {
            $table->text('name_surname')->nullable()->change();
            $table->text('role')->nullable()->change();
            $table->text('phone')->nullable()->change();
            $table->text('email')->nullable()->change();
            $table->text('social_1')->nullable()->change();
            $table->text('social_2')->nullable()->change();
            $table->text('social_3')->nullable()->change();
            $table->text('social_4')->nullable()->change();
            $table->text('url_1')->nullable()->change();
            $table->text('url_2')->nullable()->change();
            $table->text('url_3')->nullable()->change();
            $table->text('url_4')->nullable()->change();
            $table->text('button')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_contactgmaps', function (Blueprint $table) {
            $table->text('subtitle')->nullable()->change();
            $table->text('title')->nullable()->change();
        });

        Schema::table('blocks_videotuts', function (Blueprint $table) {
            $table->text('subtitle')->nullable()->change();
            $table->text('title')->nullable()->change();
        });

        Schema::table('blocks_lastworks', function (Blueprint $table) {
            $table->text('subtitle')->nullable()->change();
            $table->text('title')->nullable()->change();
            $table->text('workname_1')->nullable()->change();
            $table->text('worktype_1')->nullable()->change();
            $table->text('url_interno_1')->nullable()->change();
            $table->text('url_1')->nullable()->change();
            $table->text('button_1')->nullable()->change();

            $table->text('workname_2')->nullable()->change();
            $table->text('worktype_2')->nullable()->change();
            $table->text('url_interno_2')->nullable()->change();
            $table->text('url_2')->nullable()->change();
            $table->text('button_2')->nullable()->change();

            $table->text('workname_3')->nullable()->change();
            $table->text('worktype_3')->nullable()->change();
            $table->text('url_interno_3')->nullable()->change();
            $table->text('url_3')->nullable()->change();
            $table->text('button_3')->nullable()->change();

            $table->text('workname_4')->nullable()->change();
            $table->text('worktype_4')->nullable()->change();
            $table->text('url_interno_4')->nullable()->change();
            $table->text('url_4')->nullable()->change();
            $table->text('button_4')->nullable()->change();

            $table->text('workname_5')->nullable()->change();
            $table->text('worktype_5')->nullable()->change();
            $table->text('url_interno_5')->nullable()->change();
            $table->text('url_5')->nullable()->change();
            $table->text('button_5')->nullable()->change();

            $table->text('workname_6')->nullable()->change();
            $table->text('worktype_6')->nullable()->change();
            $table->text('url_interno_6')->nullable()->change();
            $table->text('url_6')->nullable()->change();
            $table->text('button_6')->nullable()->change();

            $table->text('button')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_stores', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('name_company')->nullable()->change();
            $table->text('location')->nullable()->change();
            $table->text('category')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_brands', function (Blueprint $table) {
            $table->text('url')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
        });

        Schema::table('blocks_prices', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('license_subtitle')->nullable()->change();
            $table->text('service_title')->nullable()->change();
            $table->text('service_subtitle')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->text('license_note')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
        });

        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('url_interno')->nullable()->change();
            $table->text('url')->nullable()->change();
            $table->text('button')->nullable()->change();
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
            $table->string('title')->nullable()->change();
            $table->string('slug')->nullable()->change();
            $table->string('category')->nullable()->change();
            $table->string('tag')->nullable()->change();
        });

        Schema::table('blocks_slideshows', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('label')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_heros', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });

        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('abstract')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_contacts', function (Blueprint $table) {
            $table->string('object_form')->nullable()->change();
            $table->string('message_ringraziamento')->nullable()->change();
        });

        Schema::table('blocks_icons', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_htmlimages', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_images_links', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_tabs', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });

        Schema::table('blocks_parallaxs', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_hightlights', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('abstract')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_portfolio2s', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });

        Schema::table('blocks_references', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_banners', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_metros', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_htmltwocols', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_collages', function (Blueprint $table) {
            $table->string('title_dx')->nullable()->change();
            $table->string('title_sx')->nullable()->change();
            $table->string('url_dx_interno')->nullable()->change();
            $table->string('url_dx')->nullable()->change();
            $table->string('button_dx')->nullable()->change();
            $table->string('url_sx_interno')->nullable()->change();
            $table->string('url_sx')->nullable()->change();
            $table->string('button_sx')->nullable()->change();
        });

        Schema::table('blocks_flussos', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_timelines', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('date')->nullable()->change();
        });

        Schema::table('blocks_staffs', function (Blueprint $table) {
            $table->string('name_surname')->nullable()->change();
            $table->string('role')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('social_1')->nullable()->change();
            $table->string('social_2')->nullable()->change();
            $table->string('social_3')->nullable()->change();
            $table->string('social_4')->nullable()->change();
            $table->string('url_1')->nullable()->change();
            $table->string('url_2')->nullable()->change();
            $table->string('url_3')->nullable()->change();
            $table->string('url_4')->nullable()->change();
            $table->string('button')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_contactgmaps', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->change();
            $table->string('title')->nullable()->change();
        });

        Schema::table('blocks_videotuts', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->change();
            $table->string('title')->nullable()->change();
        });

        Schema::table('blocks_lastworks', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('workname_1')->nullable()->change();
            $table->string('worktype_1')->nullable()->change();
            $table->string('url_interno_1')->nullable()->change();
            $table->string('url_1')->nullable()->change();
            $table->string('button_1')->nullable()->change();

            $table->string('workname_2')->nullable()->change();
            $table->string('worktype_2')->nullable()->change();
            $table->string('url_interno_2')->nullable()->change();
            $table->string('url_2')->nullable()->change();
            $table->string('button_2')->nullable()->change();

            $table->string('workname_3')->nullable()->change();
            $table->string('worktype_3')->nullable()->change();
            $table->string('url_interno_3')->nullable()->change();
            $table->string('url_3')->nullable()->change();
            $table->string('button_3')->nullable()->change();

            $table->string('workname_4')->nullable()->change();
            $table->string('worktype_4')->nullable()->change();
            $table->string('url_interno_4')->nullable()->change();
            $table->string('url_4')->nullable()->change();
            $table->string('button_4')->nullable()->change();

            $table->string('workname_5')->nullable()->change();
            $table->string('worktype_5')->nullable()->change();
            $table->string('url_interno_5')->nullable()->change();
            $table->string('url_5')->nullable()->change();
            $table->string('button_5')->nullable()->change();

            $table->string('workname_6')->nullable()->change();
            $table->string('worktype_6')->nullable()->change();
            $table->string('url_interno_6')->nullable()->change();
            $table->string('url_6')->nullable()->change();
            $table->string('button_6')->nullable()->change();

            $table->string('button')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_stores', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('name_company')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->string('category')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_brands', function (Blueprint $table) {
            $table->string('url')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
        });

        Schema::table('blocks_prices', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('license_subtitle')->nullable()->change();
            $table->string('service_title')->nullable()->change();
            $table->string('service_subtitle')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('license_note')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });

        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('url_interno')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('button')->nullable()->change();
        });




    }
}
