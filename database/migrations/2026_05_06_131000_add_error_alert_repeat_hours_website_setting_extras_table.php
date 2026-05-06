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
        if (!Schema::hasTable('website_setting_extras')) {
            Schema::create('website_setting_extras', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('website_setting_id')->unique();
                $table->unsignedInteger('error_alert_repeat_hours')->default(4);
                $table->timestamps();
            });
        } else {
            Schema::table('website_setting_extras', function (Blueprint $table) {
                if (!Schema::hasColumn('website_setting_extras', 'error_alert_repeat_hours')) {
                    $table->unsignedInteger('error_alert_repeat_hours')->default(4);
                }
            });
        }

        if (Schema::hasTable('website_settings') && Schema::hasTable('website_setting_extras')) {
            $websiteSettingIds = DB::table('website_settings')->pluck('id');

            foreach ($websiteSettingIds as $websiteSettingId) {
                DB::table('website_setting_extras')->updateOrInsert(
                    ['website_setting_id' => $websiteSettingId],
                    [
                        'error_alert_repeat_hours' => 4,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('website_setting_extras')) {
            return;
        }

        Schema::table('website_setting_extras', function (Blueprint $table) {
            if (Schema::hasColumn('website_setting_extras', 'error_alert_repeat_hours')) {
                $table->dropColumn('error_alert_repeat_hours');
            }
        });
    }
};
