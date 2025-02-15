<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeWebsitesettingField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->text("title")->change();
            $table->text("dati")->change();
            $table->text("title_footer_1")->change();
            $table->text("title_footer_2")->change();
            $table->text("title_footer_3")->change();
            $table->text("title_footer_4")->change();
            $table->text("topbar_contact_description")->change();
            $table->text("popup_title")->change();
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
            $table->string("title")->change();
            $table->string("dati")->change();
            $table->string("title_footer_1")->change();
            $table->string("title_footer_2")->change();
            $table->string("title_footer_3")->change();
            $table->string("title_footer_4")->change();
            $table->string("topbar_contact_description")->change();
            $table->string("popup_title")->change();
        });
    }
}
