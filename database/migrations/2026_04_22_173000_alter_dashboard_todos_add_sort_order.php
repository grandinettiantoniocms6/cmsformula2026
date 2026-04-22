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

        if (!Schema::hasColumn('dashboard_todos', 'sort_order')) {
            Schema::table('dashboard_todos', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->index()->after('is_done');
            });
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE dashboard_todos MODIFY title TEXT NOT NULL');
        }

        $rows = DB::table('dashboard_todos')
            ->select('id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        foreach ($rows as $index => $row) {
            DB::table('dashboard_todos')
                ->where('id', $row->id)
                ->update(['sort_order' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('dashboard_todos')) {
            return;
        }

        if (Schema::hasColumn('dashboard_todos', 'sort_order')) {
            Schema::table('dashboard_todos', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
};

