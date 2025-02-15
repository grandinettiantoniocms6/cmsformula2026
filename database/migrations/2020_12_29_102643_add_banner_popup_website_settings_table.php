<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerPopupWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->longText('offline_description')->nullable();
            $table->string('popup_title')->nullable();
            $table->longText('popup_text')->nullable();
            $table->date('popup_start')->nullable();
            $table->date('popup_end')->nullable();
            $table->unsignedInteger('popup_pages')->default(1);
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
            $table->dropColumn('offline_description');
            $table->dropColumn('popup_title');
            $table->dropColumn('popup_text');
            $table->dropColumn('popup_start');
            $table->dropColumn('popup_end');
            $table->dropColumn('popup_pages');
        });
    }
}
