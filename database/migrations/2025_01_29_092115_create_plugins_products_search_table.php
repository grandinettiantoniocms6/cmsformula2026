<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsProductsSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_products_search', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_product_id')->nullable();
            $table->text('categories')->nullable();
            $table->text('langs')->nullable();
            $table->text('attributes')->nullable();
            $table->text('options')->nullable();
            $table->text('brands')->nullable();
            $table->text('tags')->nullable();
            $table->float('price')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->boolean('is_variant')->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('plugins_products_search');
    }
}
