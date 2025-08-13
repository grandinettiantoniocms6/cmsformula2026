<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plugins_products_quantities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("plugin_product_id")->nullable();
            $table->unsignedInteger("quantity_min")->nullable();
            $table->float('price')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_products_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("plugin_product_id")->nullable();
            $table->text("name")->nullable();
            $table->string("lang")->nullable();
            $table->float('price')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugins_products_quantities');
        Schema::dropIfExists('plugins_products_services');
    }
};
