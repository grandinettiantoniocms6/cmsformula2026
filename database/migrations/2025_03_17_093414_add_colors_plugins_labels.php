<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorsPluginsLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_labels', function (Blueprint $table) {
            $table->unsignedInteger('plugin_product_id')->nullable();
        });

        Schema::table('plugins_labels_settings', function (Blueprint $table) {
            $table->text('photo')->nullable();
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_labels', function (Blueprint $table) {
            $table->dropColumn('plugin_product_id');
        });

        Schema::table('plugins_labels_settings', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('background_color');
            $table->dropColumn('text_color');
        });
    }
}
