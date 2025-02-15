<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesPluginsParking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_parking_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('number_flight')->nullable();
            $table->unsignedInteger('number_partecipants')->nullable();
            $table->string('targa')->nullable();
            $table->unsignedInteger('type_park')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->unsignedInteger('number_days')->nullable();
            $table->float('total')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_blacklist')->default(0);
            $table->string('old_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_parking_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('day')->nullable();
            $table->float('price_scoperto')->nullable();
            $table->float('price_coperto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_parking_setting', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('total_park_scoperto')->nullable();
            $table->unsignedInteger('total_park_coperto')->nullable();
            $table->string('email')->nullable();
            $table->text('ccn_email')->nullable();
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
        Schema::dropIfExists('plugins_parking_reservations');
        Schema::dropIfExists('plugins_parking_setting');
        Schema::dropIfExists('plugins_parking_prices');
    }
}
