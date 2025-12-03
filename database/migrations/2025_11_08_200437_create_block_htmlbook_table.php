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
        Schema::create('blocks_htmlbooks', function (Blueprint $table) {
            // questi li crea da solo meno he softDeletes che aggiungo io
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // personalizzati di blocco in blocco
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('color_title')->nullable();
            $table->string('text_align')->default('center');
            $table->string('bgcolor')->nullable();
            $table->longText('foto')->nullable();
            $table->longText('foto2')->nullable();
            $table->longText('foto3')->nullable();
            $table->longText('foto4')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            // opzionali
            $table->unsignedInteger("col")->default(2);
            $table->unsignedInteger('style')->default(1);
            $table->unsignedInteger('pt')->default(0);
            $table->unsignedInteger('mt')->default(0);
            $table->unsignedInteger('mb')->default(0);
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
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks_htmlbooks');
    }
};
