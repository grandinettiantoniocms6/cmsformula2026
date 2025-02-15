<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('logo')->nullable();
            $table->longText('logo2')->nullable();
            $table->string('site_background')->nullable();
            $table->string('site_color')->nullable();
            $table->string('title')->nullable();
            $table->text('description_header')->nullable();
            $table->longText('photo_header')->nullable();
            $table->text('description_footer')->nullable();
            $table->longText('photo_footer')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('description_404')->nullable();
            $table->string('header_background')->nullable();
            $table->string('header_color')->nullable();
            $table->string('menu_background')->nullable();
            $table->string('menu_color')->nullable();
            $table->string('footer_background')->nullable();
            $table->string('footer_color')->nullable();
            $table->longText('analytics')->nullable();
            $table->longText('shinystat')->nullable();
            $table->boolean('is_share_social')->nullable();
            $table->boolean('is_online')->default(1);
            $table->timestamps();
        });

        Schema::create('website_socials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_settings');
        Schema::dropIfExists('website_socials');
    }
}
