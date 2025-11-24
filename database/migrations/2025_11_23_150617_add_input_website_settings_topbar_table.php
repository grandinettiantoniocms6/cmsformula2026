<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('topbar_address_icon')->nullable();
            $table->text('topbar_address_text')->nullable();
            $table->boolean('is_extra_button_menu')->nullable();
            $table->longText('label_extra_button_menu')->nullable();
            $table->longText('link_extra_button_menu')->nullable();
            $table->string('txtcolor_extra_button_menu')->nullable();
            $table->string('bgcolor_extra_button_menu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn("topbar_address_icon");
            $table->dropColumn("topbar_address_text");
            $table->dropColumn("is_extra_button_menu");
            $table->dropColumn("label_extra_button_menu");
            $table->dropColumn("link_extra_button_menu");
            $table->dropColumn("txtcolor_extra_button_menu");
            $table->dropColumn("bgcolor_extra_button_menu");
        });
    }
};
