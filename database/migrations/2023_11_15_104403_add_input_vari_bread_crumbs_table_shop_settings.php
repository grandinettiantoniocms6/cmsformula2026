<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputVariBreadCrumbsTableShopSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->boolean('bread_crumbs')->default(0);
            $table->string('height_section_bc')->nullable();
            $table->string('padding_section_bc')->nullable();
            $table->string('bgcolor_bc')->nullable();
            $table->string('text_color_bc')->nullable();
            $table->string('text_size_bc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->dropColumn('bread_crumbs');
            $table->dropColumn('height_section_bc');
            $table->dropColumn('padding_section_bc');
            $table->dropColumn('bgcolor_bc');
            $table->dropColumn('text_color_bc');
            $table->dropColumn('text_size_bc');
        });
    }
}
