<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('site_color_hover')->after('site_color')->nullable();
            $table->string('header_color_hover')->after('header_color')->nullable();
            $table->string('footer_color_hover')->after('footer_color')->nullable();

            $table->string('dati')->nullable();

            $table->string('title_footer_1')->nullable();
            $table->longText('text_footer_1')->nullable();
            $table->string('title_footer_2')->nullable();
            $table->longText('text_footer_2')->nullable();
            $table->string('title_footer_3')->nullable();
            $table->longText('text_footer_3')->nullable();
            $table->string('title_footer_4')->nullable();
            $table->longText('text_footer_4')->nullable();

            $table->longText('photo_credits')->nullable();
            $table->longText('link_credits')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn('site_color_hover');
            $table->dropColumn('header_color_hover');
            $table->dropColumn('footer_color_hover');

            $table->dropColumn('dati');

            $table->dropColumn('title_footer_1');
            $table->dropColumn('text_footer_1');
            $table->dropColumn('title_footer_2');
            $table->dropColumn('text_footer_2');
            $table->dropColumn('title_footer_3');
            $table->dropColumn('text_footer_3');
            $table->dropColumn('title_footer_4');
            $table->dropColumn('text_footer_4');

            $table->dropColumn('photo_credits');
            $table->dropColumn('link_credits');
        });
    }
}
