<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewSettingsPluginsProductsSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->boolean('show_attributes_sidebar')->default(1);
        });

        Schema::table('shop_settings', function (Blueprint $table) {
            $table->unsignedInteger('mouseover_image_number')->default(2);
            $table->boolean('view_variants_in_list')->default(1);
        });

        Schema::table('plugins_invitations_settings', function (Blueprint $table) {
            $table->longText('logo')->nullable();
            $table->longText('description')->nullable();
            $table->longText('cover')->nullable();
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
            $table->dropColumn('show_attributes_sidebar');
        });

        Schema::table('shop_settings', function (Blueprint $table) {
            $table->dropColumn('mouseover_image_number');
            $table->dropColumn('view_variants_in_list');
        });

        Schema::table('plugins_invitations_settings', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('description');
            $table->dropColumn('cover');
        });
    }
}
