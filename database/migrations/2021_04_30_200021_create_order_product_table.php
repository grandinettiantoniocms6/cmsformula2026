<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     * @table order_product
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->string('name', 255)->nullable()->default(null);
            $table->string('sku', 100);
            $table->decimal('price', 13, 2)->nullable()->default(null);
            $table->decimal('price_with_tax', 13, 2)->nullable()->default(null);
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('shop_order_product');
     }
}
