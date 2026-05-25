<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plugin_product_import_run_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plugin_product_import_run_id')->index('plugin_import_steps_run_idx');
            $table->string('step_type', 50);
            $table->string('label');
            $table->string('status', 30)->default('queued')->index();
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('processed_rows')->default(0);
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plugin_product_import_run_steps');
    }
};
