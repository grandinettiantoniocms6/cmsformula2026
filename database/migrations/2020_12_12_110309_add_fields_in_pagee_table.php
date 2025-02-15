<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInPageeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('title_page')->nullable();
            $table->string('subtitle_page')->nullable();
            $table->string('color_title_page')->nullable();
            $table->string('color_subtitle_page')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('title_page');
            $table->dropColumn('subtitle_page');
            $table->dropColumn('color_title_page');
            $table->dropColumn('color_subtitle_page');
        });
    }
}
