<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksScrollbarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_scrollbars', function (Blueprint $table) {
            // necessari
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            // ingranaggio
            $table->string('name')->nullable();
            $table->string('pc')->nullable();
            $table->string('notebook')->nullable();
            $table->string('tablet')->nullable();
            $table->string('smartphone')->nullable();
            $table->unsignedInteger('style')->default(1);
            $table->string('color_title')->nullable();
            $table->string('bgcolor')->nullable();
            $table->unsignedInteger('height')->nullable();
            // obbligatori
            $table->unsignedInteger('block_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            // che ciclano multilingua
            $table->longText('foto')->nullable();
            $table->string('icon')->nullable();
            $table->string('icon_color')->nullable();
            $table->string('icon_bgcolor')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks_scrollbars');
    }
}
