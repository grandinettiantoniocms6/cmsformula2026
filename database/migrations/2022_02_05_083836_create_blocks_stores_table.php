<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_stores', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            // questi invece sono gli input che mi servono per il nuovo blocco
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->unsignedInteger("col")->default(3);
            $table->string('fullwidth')->nullable();
            $table->string('size_icon')->nullable();
            $table->string('bgcolor')->nullable();
            $table->string('txt_color')->nullable();
            $table->string('title')->nullable();
            $table->string('name_company')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('icon_phone')->nullable();
            $table->string('icon_color_phone')->nullable();
            $table->string('type_href_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('icon_whatsapp')->nullable();
            $table->string('icon_color_whatsapp')->nullable();;
            $table->string('type_href_whatsapp')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            // questi sono obbligatori
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
        Schema::dropIfExists('blocks_stores');
    }
}
