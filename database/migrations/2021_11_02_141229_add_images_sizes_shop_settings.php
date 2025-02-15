<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesSizesShopSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->float('list_image_width')->nullable();
            $table->float('list_image_height')->nullable();

            $table->string('list_image_fit')->default("contain");
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
            $table->dropColumn('list_image_width');
            $table->dropColumn('list_image_height');
            $table->dropColumn('list_image_fit');
        });
    }
}
