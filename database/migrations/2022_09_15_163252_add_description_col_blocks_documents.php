<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionColBlocksDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->unsignedInteger("col")->default(12)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_documents', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('col');
        });
    }
}
