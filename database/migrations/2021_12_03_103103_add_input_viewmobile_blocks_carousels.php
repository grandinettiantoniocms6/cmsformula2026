<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputViewmobileBlocksCarousels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->string('pc')->nullable();
            $table->string('notebook')->nullable();
            $table->string('tablet')->nullable();
            $table->string('smartphone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_carousels', function (Blueprint $table) {
            $table->dropColumn('pc');
            $table->dropColumn('notebook');
            $table->dropColumn('tablet');
            $table->dropColumn('smartphone');
        });
    }
}
