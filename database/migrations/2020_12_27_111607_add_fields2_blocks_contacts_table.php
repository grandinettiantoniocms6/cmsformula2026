<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFields2BlocksContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_contacts', function (Blueprint $table) {
            $table->text('title_form')->nullable();
            $table->text('subtitle_form')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_contacts', function (Blueprint $table) {
            $table->dropColumn('title_form');
            $table->dropColumn('subtitle_form');
        });
    }
}
