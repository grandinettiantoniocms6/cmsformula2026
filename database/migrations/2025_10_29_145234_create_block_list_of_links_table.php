<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blocks_list_of_links', function (Blueprint $table) {
            // questi li crea da solo meno he softDeletes che aggiungo io
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // personalizzati di blocco in blocco
            $table->string('title')->nullable();
            $table->string('color_title')->nullable();
            $table->string('label')->nullable();
            $table->string('color_label')->nullable();
            $table->string('bgcolor_label')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            // opzionali
            $table->unsignedInteger('style')->default(1);
            $table->unsignedInteger('mt')->default(50);
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
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks_list_of_links');
    }
};
