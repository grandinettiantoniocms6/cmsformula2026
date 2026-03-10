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
        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->float('total_acconto')->after("total")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plugins_booking_reservations', function (Blueprint $table) {
            $table->dropColumn('total_acconto');
        });
    }
};
