<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsEtichetteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_labels', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('format')->nullable();
            $table->string('lang')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('description')->nullable();
            $table->text('table_nutr')->nullable();
            $table->string('qrcode_link')->nullable();
            $table->boolean('is_product_lab')->default(0);
            $table->boolean('is_address_footer')->default(0);
            $table->boolean('is_logo_header')->default(0);
            $table->text('barcode')->nullable();
            $table->text('weight')->nullable();
            $table->text('production')->nullable();
            $table->text('end_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_labels_settings', function (Blueprint $table) {
            $table->id();
            $table->text('logo')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('plugins_labels');
        Schema::dropIfExists('plugins_labels_settings');
    }
}
