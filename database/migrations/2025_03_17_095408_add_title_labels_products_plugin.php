<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleLabelsProductsPlugin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->longText('title_labels')->nullable();
            $table->longText('description_labels')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->dropColumn('title_labels');
            $table->dropColumn('description_labels');
        });
    }
}
