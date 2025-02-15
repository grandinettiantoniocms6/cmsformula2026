<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabelCheckoutTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_booking_types', function (Blueprint $table) {
            $table->text('label_checkout');
            $table->text('info');
            $table->text('info_2');
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
            $table->dropColumn('label_checkout');
            $table->dropColumn('info');
            $table->dropColumn('info_2');
        });
    }
}
