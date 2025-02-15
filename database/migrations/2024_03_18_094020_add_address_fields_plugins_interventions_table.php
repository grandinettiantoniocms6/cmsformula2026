<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldsPluginsInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_interventions_clients', function (Blueprint $table) {
            $table->string('civico')->nullable();
            $table->string('interno')->nullable();
            $table->string('cap')->nullable();
            $table->string('frazione')->nullable();
            $table->string('comune')->nullable();
            $table->string('provincia')->nullable();
            $table->string('regione')->nullable();
        });

        Schema::table('plugins_interventions', function (Blueprint $table) {
            $table->string('civico')->nullable();
            $table->string('interno')->nullable();
            $table->string('cap')->nullable();
            $table->string('frazione')->nullable();
            $table->string('comune')->nullable();
            $table->string('provincia')->nullable();
            $table->string('regione')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_interventions_clients', function (Blueprint $table) {
            $table->dropColumn('civico');
            $table->dropColumn('interno');
            $table->dropColumn('cap');
            $table->dropColumn('frazione');
            $table->dropColumn('comune');
            $table->dropColumn('provincia');
            $table->dropColumn('regione');
        });

        Schema::table('plugins_interventions', function (Blueprint $table) {
            $table->dropColumn('civico');
            $table->dropColumn('interno');
            $table->dropColumn('cap');
            $table->dropColumn('frazione');
            $table->dropColumn('comune');
            $table->dropColumn('provincia');
            $table->dropColumn('regione');
        });
    }
}
