<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksSeparatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_separators', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            // questi invece sono gli input che mi servono per il nuovo blocco che dovranno essere poi uguali nel blocco lato front!!!
            $table->string('title')->nullable();
            $table->string('h_title')->nullable();
            $table->text('color_title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('h_subtitle')->nullable();
            $table->text('color_subtitle')->nullable();
            $table->text('align')->nullable();
            $table->string('height')->nullable();
            $table->longText('foto')->nullable();
            $table->string('alpha')->nullable();
            $table->string('bgcolor')->nullable();
            $table->string('mt')->nullable();
            $table->string('mb')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            $table->text('color_button')->nullable();
            $table->text('color_txt_button')->nullable();
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
        Schema::dropIfExists('blocks_separators');
    }
}
