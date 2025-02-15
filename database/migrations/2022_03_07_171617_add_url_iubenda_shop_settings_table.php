<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlIubendaShopSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->text('privacy_iubenda')->nullable();
            $table->text('termini_iubenda')->nullable();
            $table->text('cookie_iubenda')->nullable();
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
            $table->dropColumn('privacy_iubenda');
            $table->dropColumn('termini_iubenda');
            $table->dropColumn('cookie_iubenda');
        });
    }
}
