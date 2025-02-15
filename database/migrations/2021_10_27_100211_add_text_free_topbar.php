<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextFreeTopbar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->string('color_hover_autocomplete_topbar_ecommerce')->nullable();
            $table->text('html_free_topbar_ecommerce')->nullable();
            $table->string('button_autocomplete_topbar_ecommerce')->nullable();
            $table->string('icon_button_autocomplete_topbar_ecommerce')->nullable();
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
            $table->dropColumn('color_hover_autocomplete_topbar_ecommerce');
            $table->dropColumn('html_free_topbar_ecommerce');
            $table->dropColumn('button_autocomplete_topbar_ecommerce');
            $table->dropColumn('icon_button_autocomplete_topbar_ecommerce');
        });
    }
}
