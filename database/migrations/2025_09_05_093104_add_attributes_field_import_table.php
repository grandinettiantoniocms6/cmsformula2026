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
        Schema::table('plugins_products_import', function (Blueprint $table) {
            $table->string("name_attribute_1")->nullable();
            $table->string("name_attribute_2")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plugins_products_import', function (Blueprint $table) {
            $table->dropColumn("name_attribute_1");
            $table->dropColumn("name_attribute_2");
        });
    }
};
