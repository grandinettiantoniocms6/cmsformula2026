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
        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->string('color_title')->nullable();
            $table->string('text_align')->nullable();
            $table->string('bgcolor')->nullable();
            $table->string('color_text_button')->nullable();
            $table->string('color_bg_button')->nullable();
            $table->longText('foto')->nullable();
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();
            // opzionali
            $table->unsignedInteger('style')->default(1);
            $table->string('pt')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->dropColumn('color_title');
            $table->dropColumn('text_align');
            $table->dropColumn('bgcolor');
            $table->dropColumn('color_text_button');
            $table->dropColumn('color_bg_button');
            $table->dropColumn('foto');
            $table->dropColumn('url_interno');
            $table->dropColumn('type_href');
            $table->dropColumn('url');
            $table->dropColumn('button');
            $table->dropColumn('style');
            $table->dropColumn('pt');
        });
    }
};
