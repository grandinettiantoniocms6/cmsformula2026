<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plugin_product_import_runs', function (Blueprint $table) {
            $table->unsignedBigInteger('queue_job_id')->nullable()->index()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('plugin_product_import_runs', function (Blueprint $table) {
            $table->dropColumn('queue_job_id');
        });
    }
};
