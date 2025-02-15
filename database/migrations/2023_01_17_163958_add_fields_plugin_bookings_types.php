<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsPluginBookingsTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->text('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('color_calendar')->nullable();
            $table->boolean('can_payment')->default(0);
            $table->unsignedInteger('number_hours_for_cancellation')->default(24);
            $table->boolean('is_visible')->default(1);
            $table->boolean('is_visible_calendar')->default(1);
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
            $table->dropColumn('image');
            $table->dropColumn('icon');
            $table->dropColumn('color_calendar');
            $table->dropColumn('can_payment');
            $table->dropColumn('number_hours_for_cancellation');
            $table->dropColumn('is_visible');
            $table->dropColumn('is_visible_calendar');
        });
    }
}
