<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputColorPluginInterventionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_interventions', function (Blueprint $table) {
            $table->boolean('is_ricevuta')->default(0);
        });

        Schema::table('plugins_interventions_vehicles', function (Blueprint $table) {
            $table->string('color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_interventions', function (Blueprint $table) {
            $table->dropColumn('is_ricevuta');
        });

        Schema::table('plugins_interventions_vehicles', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
}
