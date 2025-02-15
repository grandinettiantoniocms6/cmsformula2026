<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTitleSeparatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_separators', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('subtitle')->nullable()->change();
        });

        Schema::table('blocks_faqs', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
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
            $table->string('title')->nullable()->change();
            $table->string('subtitle')->nullable()->change();
        });

        Schema::table('blocks_faqs', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });
    }
}
