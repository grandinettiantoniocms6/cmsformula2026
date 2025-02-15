<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsInterventions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_interventions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('laborer_id')->nullable();
            $table->unsignedInteger('status_id')->nullable();

            $table->date('date_intervention')->nullable();
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->boolean('is_all_day')->default(0);

            $table->boolean('is_invoice')->default(0);
            $table->boolean('is_paid')->default(0);

            $table->boolean('is_priority')->default(0);

            $table->longText('note_interne')->nullable();
            $table->longText('note')->nullable();

            $table->dateTime('date_call')->nullable();
            $table->string('referent')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('plugins_interventions_status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('color')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_interventions_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_interventions_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_interventions_laborers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_interventions_clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_interventions');
        Schema::dropIfExists('plugins_interventions_clients');
        Schema::dropIfExists('plugins_interventions_laborers');
        Schema::dropIfExists('plugins_interventions_drivers');
        Schema::dropIfExists('plugins_interventions_status');
        Schema::dropIfExists('plugins_interventions_vehicles');
    }
}
