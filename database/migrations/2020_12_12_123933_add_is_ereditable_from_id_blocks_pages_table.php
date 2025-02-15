<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsEreditableFromIdBlocksPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_pages', function (Blueprint $table) {
            $table->unsignedInteger('is_ereditable_from_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_pages', function (Blueprint $table) {
            $table->dropColumn('is_ereditable_from_id');
        });
    }
}
