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
        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->unsignedInteger('number_days_for_acconto')->default(0);
            $table->float('perc_acconto')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plugins_booking_settings', function (Blueprint $table) {
            $table->dropColumn('number_days_for_acconto');
            $table->dropColumn('perc_acconto');
        });
    }
};
