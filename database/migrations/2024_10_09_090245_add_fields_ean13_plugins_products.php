<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsEan13PluginsProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->string('ean13')->nullable();
            $table->boolean('is_button_for_request')->default(0);
        });

        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->unsignedInteger('type_registration_form')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->dropColumn('ean13');
            $table->dropColumn('is_button_for_request');
        });

        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->dropColumn('type_registration_form');
        });
    }
}
