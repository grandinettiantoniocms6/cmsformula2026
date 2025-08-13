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
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->boolean('is_qta_minima')->default(0);
            $table->boolean('is_caricamento_file')->default(0);
            $table->boolean('is_textarea_message')->default(0);
            $table->boolean('is_services_adding')->default(0);
        });

        Schema::table('plugins_products', function (Blueprint $table) {
            $table->boolean('is_caricamento_file')->default(0);
            $table->boolean('is_textarea_message')->default(0);
            $table->boolean('is_caricamento_file_required')->default(0);
            $table->boolean('is_textarea_message_required')->default(0);
            $table->boolean('is_services_adding_required')->default(0);
        });

        Schema::table('shop_cart', function (Blueprint $table) {
            $table->text('file')->nullable();
            $table->text('message')->nullable();
            $table->text('services')->nullable();
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->text('file')->nullable();
            $table->text('message')->nullable();
            $table->text('services')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->dropColumn('is_qta_minima');
            $table->dropColumn('is_caricamento_file');
            $table->dropColumn('is_textarea_message');
            $table->dropColumn('is_services_adding');
        });

        Schema::table('plugins_products', function (Blueprint $table) {
            $table->dropColumn('is_caricamento_file');
            $table->dropColumn('is_textarea_message');
            $table->dropColumn('is_caricamento_file_required');
            $table->dropColumn('is_textarea_message_file_required');
            $table->dropColumn('is_services_adding_required');
        });

        Schema::table('shop_cart', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->dropColumn('message');
            $table->dropColumn('services');
        });

        Schema::table('shop_order_product', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->dropColumn('message');
            $table->dropColumn('services');
        });
    }
};
