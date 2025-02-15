<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartRulesTable extends Migration
{
    /**
     * Run the migrations.
     * @table user_rules
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_cart_rules', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('code', 100);
            $table->tinyInteger('priority');
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->boolean('status')->default(0);
            $table->boolean('highlight')->default(0);
            $table->integer('minimum_amount')->nullable()->default(0);
            $table->boolean('free_delivery')->default(0);
            $table->integer('total_available')->nullable();
            $table->integer('total_available_each_user')->nullable();
            $table->string('promo_label', 255)->nullable();
            $table->string('promo_text', 1000)->nullable();
            $table->integer('multiply_gift')->nullable()->default(1);
            $table->integer('min_nr_products')->nullable()->default(0);
            $table->enum('discount_type', array('Percent - order',
                        'Percent - selected products', 'Percent - cheapest product',
                        'Percent - most expensive product', 'Amount - order'));
            $table->decimal('reduction_amount', 13, 2)->nullable()->default(0);
            $table->integer('reduction_currency_id')->unsigned()->nullable();
            $table->integer('minimum_amount_currency_id')->unsigned()->nullable();
            $table->integer('gift_product_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();

            $table->nullableTimestamps();

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
        Schema::dropIfExists('shop_cart_rules');
    }
}
