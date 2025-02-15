<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add2xiconSettingWebsiteSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('sizeicon')->nullable();
            $table->string('fa-1x')->nullable();
            $table->string('fa-2x')->nullable();
            $table->string('fa-3x')->nullable();
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
            $table->dropColumn('sizeicon');
            $table->dropColumn('fa-1x');
            $table->dropColumn('fa-2x');
            $table->dropColumn('fa-3x');
        });
    }
}
