<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenuLinkVisitedColorWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('website_setting_extras')) {
            Schema::create('website_setting_extras', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('website_setting_id')->unique();
                $table->text('menu_link_visited_color')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_setting_extras');
    }
}
