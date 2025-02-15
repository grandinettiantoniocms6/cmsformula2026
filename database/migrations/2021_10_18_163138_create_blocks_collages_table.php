<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksCollagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_collages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->longText('foto_sx')->nullable();
            $table->string('title_dx')->nullable();
            $table->string('color_title_dx')->nullable();
            $table->text('description_dx')->nullable();
            $table->string('url_dx_interno')->nullable();
            $table->string('type_dx_href')->nullable();
            $table->string('url_dx')->nullable();
            $table->string('button_dx')->nullable();
            $table->string('title_sx')->nullable();
            $table->string('color_title_sx')->nullable();
            $table->text('description_sx')->nullable();
            $table->string('url_sx_interno')->nullable();
            $table->string('type_sx_href')->nullable();
            $table->string('url_sx')->nullable();
            $table->string('button_sx')->nullable();
            $table->longText('foto_dx')->nullable();
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
        Schema::dropIfExists('blocks_collages');
    }
}
