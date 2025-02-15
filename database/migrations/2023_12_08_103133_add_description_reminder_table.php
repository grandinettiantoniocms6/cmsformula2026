<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->longText('description_reminder')->nullable();
        });

        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->unsignedInteger('hours_reminder')->default(24);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->dropColumn('description_reminder');
        });

        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->dropColumn('hours_reminder');
        });
    }
}
