<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_key')->nullable();
            $table->text('description_short')->nullable();
            $table->text('description')->nullable();
            $table->longText('attachments')->nullable();
            $table->longText('tags')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_evidenza')->nullable();

            $table->float('price')->nullable();
            $table->text('video')->nullable();
            $table->unsignedInteger('qty')->nullable();
            $table->unsignedInteger('qty_year')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_products_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->nullable();
            $table->longText('image')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_products_related', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('product_related_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_products_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('tag')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_products_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->longText('image')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_active')->nullable();

            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_products_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('image')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_active')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_products_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number_product')->default(12);
            $table->boolean('show_prices')->default(0);
            $table->boolean('show_quantities')->default(0);
            $table->boolean('show_form_contact')->default(0);
            $table->boolean('show_catalog')->default(0);
            $table->boolean('show_attributes_form_contact')->default(0);
            $table->boolean('show_related_products')->default(0);
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('image')->nullable();
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
        Schema::dropIfExists('plugins_products');
        Schema::dropIfExists('plugins_products_images');
        Schema::dropIfExists('plugins_products_related');
        Schema::dropIfExists('plugins_products_tags');
        Schema::dropIfExists('plugins_products_categories');
        Schema::dropIfExists('plugins_products_brands');
        Schema::dropIfExists('plugins_products_settings');

    }
}
