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
        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->string('pt')->default(0);
            $table->string('pb')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocks_grids', function (Blueprint $table) {
            $table->dropColumn('pt');
            $table->dropColumn('pb');
        });
    }
};
