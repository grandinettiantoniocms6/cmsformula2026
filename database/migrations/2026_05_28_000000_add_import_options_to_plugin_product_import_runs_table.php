<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plugin_product_import_runs', function (Blueprint $table) {
            $table->longText('import_options')->nullable()->after('imported_product_ids');
        });
    }

    public function down(): void
    {
        Schema::table('plugin_product_import_runs', function (Blueprint $table) {
            $table->dropColumn('import_options');
        });
    }
};
