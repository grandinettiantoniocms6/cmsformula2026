<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactsWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('topbar_contact_email')->nullable();
            $table->string('topbar_contact_mobile')->nullable();
            $table->string('topbar_contact_description')->nullable();
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
            $table->dropColumn('topbar_contact_email');
            $table->dropColumn('topbar_contact_mobile');
            $table->dropColumn('topbar_contact_description');

        });
    }
}
