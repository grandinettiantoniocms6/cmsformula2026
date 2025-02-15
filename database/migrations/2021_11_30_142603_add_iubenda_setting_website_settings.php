<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIubendaSettingWebsiteSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->longText('iubenda_privacy')->nullable();
            $table->longText('iubenda_cookie')->nullable();
            $table->longText('iubenda_cookie_banner')->nullable();
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
            $table->dropColumn('iubenda_privacy');
            $table->dropColumn('iubenda_cookie');
            $table->dropColumn('iubenda_cookie_banner');
        });
    }
}
