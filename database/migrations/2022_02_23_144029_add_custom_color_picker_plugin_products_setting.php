<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomColorPickerPluginProductsSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->longText('custom_color_1')->nullable();
            $table->longText('custom_color_2')->nullable();
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
            $table->dropColumn('custom_color_1');
            $table->dropColumn('custom_color_2');
        });
    }
}
