<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // questi invece sono gli input che mi servono per il nuovo blocco
            $table->string('service_intro')->nullable();
            $table->string('license_title')->nullable();
            $table->string('license_subtitle')->nullable();
            $table->string('color_license_title')->nullable();
            $table->string('color_license_subtitle')->nullable();
            $table->longText('foto')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('price_1')->nullable();
            $table->string('price_2')->nullable();
            $table->string('color_price_1')->nullable();
            $table->string('color_price_2')->nullable();
            $table->string('service_title')->nullable();
            $table->string('service_subtitle')->nullable();
            $table->longText('listing')->nullable();
            $table->string('list')->nullable();
            $table->string('description')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            $table->string('license_note')->nullable();
            $table->string('col')->nullable();
            $table->string('color_border')->nullable();
            // questi sono obbligatori
            $table->string('name')->nullable();
            $table->unsignedInteger('block_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks_prices');
    }
}
