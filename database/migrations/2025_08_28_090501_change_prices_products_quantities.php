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

        Schema::table('plugins_products_quantities', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('plugins_products_quantities', function (Blueprint $table) {
            $table->float('price', 13, 3);
        });

        Schema::table('shop_attributes_options', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('shop_attributes_options', function (Blueprint $table) {
            $table->float('price', 13, 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plugins_products_quantities', function (Blueprint $table) {
            $table->double('price')->change();
        });

        Schema::table('shop_attributes_options', function (Blueprint $table) {
            $table->double('price')->change();
        });
    }
};
