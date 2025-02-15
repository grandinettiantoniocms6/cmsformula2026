<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsBookingStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_booking_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('class')->nullable();
            $table->string('color_admin')->nullable();
            $table->boolean('is_unblock')->default(0);
            $table->boolean('is_payment')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->unsignedInteger("plugin_booking_status_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_booking_statuses');

        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->dropColumn("plugin_booking_status_id");
        });
    }
}
