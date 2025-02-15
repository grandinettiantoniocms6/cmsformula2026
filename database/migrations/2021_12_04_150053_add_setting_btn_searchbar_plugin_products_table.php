<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettingBtnSearchbarPluginProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->string('bg_btn_search_topbar_ecommerce')->nullable();
            $table->string('bg_submenu_search_topbar_ecommerce')->nullable();
            $table->string('alpha_submenu_search_topbar_ecommerce')->nullable();
            $table->string('txtcolor_btn_search_topbar_ecommerce')->nullable();
            $table->string('txtcolor_submenu_search_topbar_ecommerce')->nullable();
            $table->string('size_btn_search_topbar_ecommerce')->nullable();
            $table->string('size_submenu_search_topbar_ecommerce')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->dropColumn('bg_btn_search_topbar_ecommerce');
            $table->dropColumn('bg_submenu_search_topbar_ecommerce');
            $table->dropColumn('alpha_submenu_search_topbar_ecommerce');
            $table->dropColumn('txtcolor_btn_search_topbar_ecommerce');
            $table->dropColumn('txtcolor_submenu_search_topbar_ecommerce');
            $table->dropColumn('size_btn_search_topbar_ecommerce');
            $table->dropColumn('size_submenu_search_topbar_ecommerce');
        });
    }
}
