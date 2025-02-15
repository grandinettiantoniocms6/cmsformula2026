<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinMaxPluginsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_products_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('padre_id')->nullable();
            $table->unsignedInteger('figlio_id')->nullable();
            $table->float('price')->nullable();
            $table->string('type_price')->nullable();
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
        Schema::dropIfExists('plugins_products_prices');
    }
}
