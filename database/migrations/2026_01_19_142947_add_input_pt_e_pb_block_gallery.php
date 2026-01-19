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
        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->string('pt')->default(5);
            $table->string('pb')->default(5);
            $table->string('color_title')->nullable();
            $table->string('text_align')->default('center');
            $table->string('bgcolor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->dropColumn('pt');
            $table->dropColumn('pb');
            $table->dropColumn('color_title');
            $table->dropColumn('text_align');
            $table->dropColumn('bgcolor');
        });
    }
};
