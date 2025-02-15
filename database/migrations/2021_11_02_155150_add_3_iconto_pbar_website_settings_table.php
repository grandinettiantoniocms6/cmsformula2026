<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add3IcontoPbarWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('icon_topbar1')->nullable();
            $table->string('icon_topbar2')->nullable();
            $table->string('icon_topbar3')->nullable();
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
            $table->dropColumn('icon_topbar1');
            $table->dropColumn('icon_topbar2');
            $table->dropColumn('icon_topbar3');
        });
    }
}
