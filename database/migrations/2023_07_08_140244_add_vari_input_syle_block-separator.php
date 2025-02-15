<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariInputSyleBlockSeparator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_separators', function (Blueprint $table) {
            $table->unsignedInteger('style')->default(1);
            $table->longText('foto2')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_separators', function (Blueprint $table) {
            $table->dropColumn('style');
            $table->dropColumn('foto2');

        });
    }
}
