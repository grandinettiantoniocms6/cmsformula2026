<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInTextBookingRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->text("name")->nullable()->change();
            $table->text("abstract")->nullable()->change();
            $table->text("meta_title")->nullable()->change();
            $table->text("meta_description")->nullable()->change();
            $table->text("meta_key")->nullable()->change();
        });

        Schema::table('plugins_booking_services', function (Blueprint $table) {
            $table->text("name")->nullable()->change();
        });

        Schema::table('plugins_booking_statuses', function (Blueprint $table) {
            $table->text("name")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_booking_rooms', function (Blueprint $table) {
            $table->string("name")->nullable()->change();
            $table->string("abstract")->nullable()->change();
            $table->string("meta_title")->nullable()->change();
            $table->string("meta_description")->nullable()->change();
            $table->string("meta_key")->nullable()->change();
        });

        Schema::table('plugins_booking_services', function (Blueprint $table) {
            $table->string("name")->nullable()->change();
        });

        Schema::table('plugins_booking_statuses', function (Blueprint $table) {
            $table->string("name")->nullable()->change();
        });
    }
}
