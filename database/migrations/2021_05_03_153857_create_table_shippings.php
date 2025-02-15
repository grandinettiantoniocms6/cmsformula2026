<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShippings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('delay_description')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_free')->default(0);
            $table->boolean('is_contrassegno')->default(0);
            $table->unsignedInteger('type_ship')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('shop_shippings_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shipping_id');
            $table->unsignedInteger('area_id');
            $table->float('min');
            $table->float('max');
            $table->float('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_shippings');
        Schema::dropIfExists('shop_shippings_ranges');
    }
}
