<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateContextPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pages')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'updated_context')) {
                $table->string('updated_context', 20)->nullable()->after('updated_by')->index();
            }

            if (!Schema::hasColumn('pages', 'updated_block_type')) {
                $table->string('updated_block_type', 120)->nullable()->after('updated_context');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('pages')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'updated_block_type')) {
                $table->dropColumn('updated_block_type');
            }

            if (Schema::hasColumn('pages', 'updated_context')) {
                $table->dropColumn('updated_context');
            }
        });
    }
}

