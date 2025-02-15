<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksGridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_grids', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->longText('foto')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            // opzionali
            $table->unsignedInteger("col")->default(2);
            $table->unsignedInteger('style')->default(1);
            $table->string('fullwidth')->nullable();
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
        Schema::dropIfExists('blocks_grids');
    }
}
