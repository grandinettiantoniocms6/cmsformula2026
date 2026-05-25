<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plugin_product_import_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plugin_product_import_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_extension', 10)->nullable();
            $table->string('status', 30)->default('queued')->index();
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('processed_rows')->default(0);
            $table->longText('imported_product_ids')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plugin_product_import_runs');
    }
};
