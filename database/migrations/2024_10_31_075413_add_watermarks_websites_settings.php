<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWatermarksWebsitesSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->text('watermark_url')->nullable();
            $table->string('watermark_position')->nullable();
            $table->unsignedInteger('watermark_x')->nullable();
            $table->unsignedInteger('watermark_y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn('watermark_url');
            $table->dropColumn('watermark_position');
            $table->dropColumn('watermark_x');
            $table->dropColumn('watermark_y');
        });
    }
}
