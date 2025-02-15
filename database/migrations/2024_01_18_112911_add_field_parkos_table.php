<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldParkosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_parking_reservations', function (Blueprint $table) {
            $table->string("from")->nullable();
            $table->string("parkos_code")->nullable();
            $table->string("parkos_parking_type")->nullable();
            $table->string("parkos_airport")->nullable();
            $table->string("merchant")->nullable();
            $table->string("merchant_id")->nullable();
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
            $table->dropColumn("from");
            $table->dropColumn("parkos_code");
            $table->dropColumn("parkos_parking_type");
            $table->dropColumn("parkos_airport");
            $table->dropColumn("merchant");
            $table->dropColumn("merchant_id");
        });
    }
}
