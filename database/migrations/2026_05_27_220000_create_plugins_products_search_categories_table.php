<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsProductsSearchCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_products_search_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_product_id');
            $table->unsignedInteger('category_id');
            $table->string('lang', 8);
            $table->unsignedInteger('group_id')->nullable();
            $table->boolean('is_variant')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();

            $table->unique(['plugin_product_id', 'category_id', 'lang'], 'ppsc_unique_product_category_lang');
            $table->index(['category_id', 'lang', 'is_active', 'is_variant', 'plugin_product_id'], 'ppsc_idx_category_lang_active_variant_product');
            $table->index(['plugin_product_id'], 'ppsc_idx_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_products_search_categories');
    }
}
