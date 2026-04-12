<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubmenuTxtColorMobileWebsiteSettingExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('website_setting_extras')) {
            return;
        }

        Schema::table('website_setting_extras', function (Blueprint $table) {
            if (!Schema::hasColumn('website_setting_extras', 'submenu_txt_color_mobile')) {
                $table->text('submenu_txt_color_mobile')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('website_setting_extras')) {
            return;
        }

        Schema::table('website_setting_extras', function (Blueprint $table) {
            if (Schema::hasColumn('website_setting_extras', 'submenu_txt_color_mobile')) {
                $table->dropColumn('submenu_txt_color_mobile');
            }
        });
    }
}

