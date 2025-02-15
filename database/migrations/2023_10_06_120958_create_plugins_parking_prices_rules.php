<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsParkingPricesRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_parking_prices_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_parking_price_id')->nullable();
            $table->float('discount')->nullable();
            $table->unsignedInteger('type_discount')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->unsignedInteger('condition_discount')->nullable();
            $table->unsignedInteger('rule_discount')->nullable();
            $table->unsignedInteger('value_discount')->nullable();
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
        Schema::dropIfExists('plugins_parking_prices_rules');
    }
}
