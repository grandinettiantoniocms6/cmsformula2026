<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMigliorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->boolean('search_with_price')->nullable();
        });


        Schema::table('admin_languages', function (Blueprint $table) {
            $table->boolean('is_frontend')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->dropColumn('search_with_price');
        });

        Schema::table('admin_languages', function (Blueprint $table) {
            $table->dropColumn('is_frontend');
        });
    }
}
