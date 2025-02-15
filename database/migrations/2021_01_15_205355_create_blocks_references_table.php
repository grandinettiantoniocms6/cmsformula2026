<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_references', function (Blueprint $table) {
            $table->id();
            // questi sono gli input che servono per il nuovo blocco e dovranno essere uguali nel blocco front!!!
            $table->string('title')->nullable();
            $table->text('category')->nullable();
            $table->text('description')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->longText('foto')->nullable();
            $table->string('button')->nullable();
            //$table->boolean('is_active')->default(0);
            //$table->boolean('is_default')->default(0);
            // questi sono obbligatori
            $table->string('name')->nullable();
            $table->unsignedInteger('block_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            // copiare anche questo che dovrebbe mancare
            $table->softDeletes();
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
        Schema::dropIfExists('blocks_references');
    }
}
