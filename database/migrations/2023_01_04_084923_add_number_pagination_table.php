<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberPaginationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->unsignedInteger('number_pagination')->default(9);
            $table->boolean('is_pagination')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_gallerys', function (Blueprint $table) {
            $table->dropColumn('number_pagination');
            $table->dropColumn('is_pagination');
        });
    }
}
