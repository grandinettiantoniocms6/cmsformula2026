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
        Schema::table('blocks_plugins_products_last', function (Blueprint $table) {
            $table->unsignedInteger("col_span")->default(4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocks_plugins_products_last', function (Blueprint $table) {
            $table->dropColumn("col_span");
        });
    }
};
