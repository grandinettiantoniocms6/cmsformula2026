<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFPdfPluginsProductsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_settings', function (Blueprint $table) {
            $table->boolean('is_print_pdf')->nullable();
            $table->longText('foto_pdf')->nullable();
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
            $table->dropColumn('is_print_pdf');
            $table->dropColumn('foto_pdf');
        });
    }
}
