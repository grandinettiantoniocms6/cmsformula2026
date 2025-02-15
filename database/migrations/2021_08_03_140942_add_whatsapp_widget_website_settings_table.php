<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhatsappWidgetWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('wapp_css1')->nullable();
            $table->string('wapp_css2')->nullable();
            $table->string('cellulare_wapp1')->nullable();
            $table->string('cellulare_wapp2')->nullable();
            $table->longText('dayonline_wapp1')->nullable();
            $table->longText('dayonline_wapp2')->nullable();
            $table->longText('avatar_wapp1')->nullable();
            $table->longText('avatar_wapp2')->nullable();
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
            $table->dropColumn('wapp_css1');
            $table->dropColumn('wapp_css2');
            $table->dropColumn('cellulare_wapp1');
            $table->dropColumn('cellulare_wapp2');
            $table->dropColumn('dayonline_wapp1');
            $table->dropColumn('dayonline_wapp2');
            $table->dropColumn('avatar_wapp1');
            $table->dropColumn('avatar_wapp2');
        });
    }
}
