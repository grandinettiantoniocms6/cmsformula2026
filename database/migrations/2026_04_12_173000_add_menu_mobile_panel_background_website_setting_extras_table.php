<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenuMobilePanelBackgroundWebsiteSettingExtrasTable extends Migration
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
            if (!Schema::hasColumn('website_setting_extras', 'menu_mobile_panel_background')) {
                $table->text('menu_mobile_panel_background')->nullable();
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
            if (Schema::hasColumn('website_setting_extras', 'menu_mobile_panel_background')) {
                $table->dropColumn('menu_mobile_panel_background');
            }
        });
    }
}

