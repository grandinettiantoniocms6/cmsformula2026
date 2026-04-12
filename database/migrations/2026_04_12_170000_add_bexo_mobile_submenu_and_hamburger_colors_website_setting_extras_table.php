<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBexoMobileSubmenuAndHamburgerColorsWebsiteSettingExtrasTable extends Migration
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
            if (!Schema::hasColumn('website_setting_extras', 'submenu_mobile_bgcolor')) {
                $table->text('submenu_mobile_bgcolor')->nullable();
            }

            if (!Schema::hasColumn('website_setting_extras', 'hamburger_menu_background')) {
                $table->text('hamburger_menu_background')->nullable();
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
            if (Schema::hasColumn('website_setting_extras', 'submenu_mobile_bgcolor')) {
                $table->dropColumn('submenu_mobile_bgcolor');
            }
            if (Schema::hasColumn('website_setting_extras', 'hamburger_menu_background')) {
                $table->dropColumn('hamburger_menu_background');
            }
        });
    }
}

