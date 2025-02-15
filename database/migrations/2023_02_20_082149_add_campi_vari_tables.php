<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampiVariTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->boolean('is_processed')->default(0);
        });

        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->longText('description_post_register')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->dropColumn('is_processed');
        });

        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->dropColumn('description_post_register');
        });
    }
}
