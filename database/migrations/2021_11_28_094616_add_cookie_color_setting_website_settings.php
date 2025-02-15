<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCookieColorSettingWebsiteSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('cookie_div_bg')->nullable();
            $table->string('cookie_txt_color')->nullable();
            $table->string('cookie_btn_bg')->nullable();
            $table->string('cookie_position')->nullable();
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
            $table->dropColumn('cookie_div_bg');
            $table->dropColumn('cookie_txt_color');
            $table->dropColumn('cookie_btn_bg');
            $table->dropColumn('cookie_position');
        });
    }
}
