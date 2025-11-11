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
        Schema::create('blocks_scrolling_texts', function (Blueprint $table) {
            // questi li crea da solo meno he softDeletes che aggiungo io
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // personalizzati di blocco in blocco
            $table->string('title')->nullable();
            $table->string('color_title')->nullable();
            $table->boolean('text_outline')->default(0);
            //$table->string("text_outline")->nullable();
            $table->string('color_text_outline')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            // da ingranaggio
            $table->string('bgcolor')->nullable();
            $table->unsignedInteger('fs')->default(150);
            $table->unsignedInteger('speed')->default(5000);
            $table->unsignedInteger('spacebetween')->default(50);
            $table->unsignedInteger('pt')->default(0);
            $table->unsignedInteger('style')->default(1);
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
        Schema::dropIfExists('blocks_scrolling_texts');
    }
};
