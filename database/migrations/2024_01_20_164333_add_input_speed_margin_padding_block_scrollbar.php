<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputSpeedMarginPaddingBlockScrollbar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_scrollbars', function (Blueprint $table) {
            $table->unsignedInteger('speed')->default(1);
            $table->string('margin_top')->nullable();
            $table->string('padding_item')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_scrollbars', function (Blueprint $table) {
            $table->dropColumn('speed');
            $table->dropColumn('margin_top');
            $table->dropColumn('padding_item');
        });
    }
}
