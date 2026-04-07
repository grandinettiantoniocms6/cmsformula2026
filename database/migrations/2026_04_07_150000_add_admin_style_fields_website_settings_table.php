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
        Schema::table('website_settings', function (Blueprint $table) {
            $table->text('admin_topbar_background')->nullable()->after('admin_panel_font');
            $table->text('admin_leftbar_background')->nullable()->after('admin_topbar_background');
            $table->text('admin_login_background')->nullable()->after('admin_leftbar_background');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn('admin_topbar_background');
            $table->dropColumn('admin_leftbar_background');
            $table->dropColumn('admin_login_background');
        });
    }
};
