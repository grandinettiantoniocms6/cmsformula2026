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
        Schema::create('blocks_countdowns', function (Blueprint $table) {
            // questi li crea da solo meno he softDeletes che aggiungo io
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // personalizzati di blocco in blocco
            $table->string('title')->nullable();
            $table->string('color_title')->nullable();
            $table->longText('description')->nullable();
            $table->string('color_text_outline')->nullable();
            // da ingranaggio
            $table->string('fullwidth')->nullable();
            $table->string('bgcolor')->nullable();
            $table->longText('foto')->nullable();
            $table->string('height')->nullable();
            $table->string('alpha')->nullable();
            $table->unsignedInteger('year')->default(26);
            $table->unsignedInteger('mounth')->default(01);
            $table->unsignedInteger('day')->default(01);
            $table->unsignedInteger('hours')->default(00);
            $table->unsignedInteger('minutes')->default(00);
            $table->unsignedInteger('pt')->default(5);
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
        Schema::dropIfExists('blocks_countdowns');
    }
};
