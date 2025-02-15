<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsBlocksContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_contacts', function (Blueprint $table) {
            $table->string('name_mitt')->nullable();
            $table->string('object_form')->nullable();
            $table->string('message_ringraziamento')->nullable();
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
            $table->dropColumn('name_mitt');
            $table->dropColumn('object_form');
            $table->dropColumn('message_ringraziamento');
        });
    }
}
