<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputMarginBlocksContactgmap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_contactgmaps', function (Blueprint $table) {
            $table->text('margin_top')->nullable();
            $table->text('margin_bottom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_contactgmaps', function (Blueprint $table) {
            $table->dropColumn('margin_top');
            $table->dropColumn('margin_bottom');
        });
    }
}
