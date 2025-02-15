<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlPrivacyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->string('url_privacy')->nullable();
            $table->string('url_condition')->nullable();
            $table->longText('text_privacy')->nullable();
            $table->longText('text_cookie')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('date_newsletter')->nullable();
            $table->longText('text_privacy')->nullable();
            $table->longText('text_cookie')->nullable();
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
            $table->dropColumn('url_privacy');
            $table->dropColumn('url_condition');
            $table->dropColumn('text_privacy');
            $table->dropColumn('text_cookie');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('date_newsletter');
            $table->dropColumn('text_privacy');
            $table->dropColumn('text_cookie');
        });
    }
}
