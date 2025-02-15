<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldShopAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_attributes', function (Blueprint $table) {
            $table->unsignedInteger('type_layout')->nullable();
        });

        Schema::table('shop_attributes_options', function (Blueprint $table) {
            $table->string('background_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_attributes', function (Blueprint $table) {
            $table->dropColumn('type_layout');
        });

        Schema::table('shop_attributes_options', function (Blueprint $table) {
            $table->dropColumn('background_color');
        });
    }
}
