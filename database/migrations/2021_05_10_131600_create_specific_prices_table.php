<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_specific_prices', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('reduction', 13, 2)->nullable()->default(0);
            $table->enum('discount_type', array('Amount', 'Percent'));
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->integer('product_id')->unsigned()->nullable();

            $table->unsignedInteger('from_quantity')->nullable();
            $table->unsignedInteger('category_specific_price_id')->nullable();
            $table->boolean('is_forced')->default(0);

        });

        Schema::create('shop_category_specific_prices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('reduction', 13, 2)->nullable()->default(0);
            $table->enum('discount_type', array('Amount', 'Percent'));
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->unsignedInteger('from_quantity')->nullable()->default(0);
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('brand_id')->unsigned()->nullable();
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
        Schema::dropIfExists('shop_specific_prices');
        Schema::dropIfExists('shop_category_specific_prices');
    }
}
