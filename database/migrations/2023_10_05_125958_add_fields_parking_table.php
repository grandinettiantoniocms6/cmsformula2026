<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsParkingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_parking_reservations', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable();
            $table->string('ip')->nullable();
            $table->float('perc_comm')->nullable();
            $table->boolean('is_payed')->nullable();
            $table->date('date_payed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_parking_reservations', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('ip');
            $table->dropColumn('perc_comm');
            $table->dropColumn('is_payed');
            $table->dropColumn('date_payed');
        });
    }
}
