<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksPluginsProductsLast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_plugins_products_last', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('ultimi_inseriti')->default(0);
            $table->boolean('in_vetrina')->default(0);
            $table->boolean('piu_venduti')->default(0);
            $table->boolean('in_promo')->default(0);
            $table->unsignedInteger('number_items')->default(9);
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
        Schema::dropIfExists('blocks_plugins_products_last');
    }
}
