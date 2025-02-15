<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttributesOptionsLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_attributes', function (Blueprint $table) {
            $table->text('name')->change();
        });

        Schema::table('shop_attributes_options', function (Blueprint $table) {
            $table->text('value')->change();
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
            $table->string('name')->change();
        });

        Schema::table('shop_attributes_options', function (Blueprint $table) {
            $table->string('value')->change();
        });
    }
}
