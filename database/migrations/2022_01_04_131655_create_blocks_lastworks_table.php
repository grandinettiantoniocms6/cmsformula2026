<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksLastworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_lastworks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // questi invece sono gli input che mi servono per il nuovo blocco
            $table->string('subtitle')->nullable();
            $table->string('title')->nullable();
            $table->string('color_subtitle')->nullable();
            $table->string('color_title')->nullable();
            $table->string('bg_color')->nullable();
            $table->text('description')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            // qui le 6 foto e link progetti
            $table->longText('foto_1')->nullable();
            $table->string('workname_1')->nullable();
            $table->string('worktype_1')->nullable();
            $table->string('url_interno_1')->nullable();
            $table->string('type_href_1')->nullable();
            $table->string('url_1')->nullable();
            $table->string('button_1')->nullable();
            $table->longText('foto_2')->nullable();
            $table->string('workname_2')->nullable();
            $table->string('worktype_2')->nullable();
            $table->string('url_interno_2')->nullable();
            $table->string('type_href_2')->nullable();
            $table->string('url_2')->nullable();
            $table->string('button_2')->nullable();
            $table->longText('foto_3')->nullable();
            $table->string('workname_3')->nullable();
            $table->string('worktype_3')->nullable();
            $table->string('url_interno_3')->nullable();
            $table->string('type_href_3')->nullable();
            $table->string('url_3')->nullable();
            $table->string('button_3')->nullable();
            $table->longText('foto_4')->nullable();
            $table->string('workname_4')->nullable();
            $table->string('worktype_4')->nullable();
            $table->string('url_interno_4')->nullable();
            $table->string('type_href_4')->nullable();
            $table->string('url_4')->nullable();
            $table->string('button_4')->nullable();
            $table->longText('foto_5')->nullable();
            $table->string('workname_5')->nullable();
            $table->string('worktype_5')->nullable();
            $table->string('url_interno_5')->nullable();
            $table->string('type_href_5')->nullable();
            $table->string('url_5')->nullable();
            $table->string('button_5')->nullable();
            $table->longText('foto_6')->nullable();
            $table->string('workname_6')->nullable();
            $table->string('worktype_6')->nullable();
            $table->string('url_interno_6')->nullable();
            $table->string('type_href_6')->nullable();
            $table->string('url_6')->nullable();
            $table->string('button_6')->nullable();
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
        Schema::dropIfExists('blocks_lastworks');
    }
}
