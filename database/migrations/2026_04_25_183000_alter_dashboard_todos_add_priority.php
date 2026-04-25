<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('dashboard_todos')) {
            return;
        }

        if (!Schema::hasColumn('dashboard_todos', 'priority')) {
            Schema::table('dashboard_todos', function (Blueprint $table) {
                $table->string('priority', 16)->default('media')->index()->after('title');
            });
        }

        DB::table('dashboard_todos')
            ->whereNull('priority')
            ->orWhere('priority', '')
            ->update(['priority' => 'media']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('dashboard_todos')) {
            return;
        }

        if (Schema::hasColumn('dashboard_todos', 'priority')) {
            Schema::table('dashboard_todos', function (Blueprint $table) {
                $table->dropColumn('priority');
            });
        }
    }
};

