<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockOnePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_one_photos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // questi del blocco
            $table->string('title')->nullable();
            $table->string('h_title')->nullable();
            $table->string('color_title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('h_subtitle')->nullable();
            $table->string('color_subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('text_align')->default(1);
            $table->string('height')->nullable();
            $table->string('height_mobile')->nullable();
            $table->longText('foto')->nullable();
            $table->unsignedInteger('alpha')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            $table->string('color_button')->nullable();
            $table->string('color_txt_button')->nullable();
            $table->unsignedInteger('speed')->nullable();
            $table->unsignedInteger('style')->nullable();
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
        Schema::dropIfExists('blocks_one_photos');
    }
}
