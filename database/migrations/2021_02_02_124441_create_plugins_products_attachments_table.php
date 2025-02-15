<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsProductsAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_products_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('file')->nullable();
            $table->unsignedInteger('product_id')->nullable();

            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::dropIfExists('plugins_products_tags');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_products_attachments');

        Schema::create('plugins_products_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('tag')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
