<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedByPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pages') || Schema::hasColumn('pages', 'updated_by')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('pages') || !Schema::hasColumn('pages', 'updated_by')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
}

