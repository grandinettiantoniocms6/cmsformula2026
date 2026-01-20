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
            $table->string("cartella")->nullable();
        });

        Schema::table('plugins_products_images', function (Blueprint $table) {
            $table->string("cartella")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->dropColumn("cartella");
        });

        Schema::table('plugins_products_images', function (Blueprint $table) {
            $table->dropColumn("cartella");
        });
    }
};
