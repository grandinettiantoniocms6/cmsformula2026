<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchInHeaderWebsites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->boolean("is_search_in_header")->default(0);
        });

        Schema::table('shop_settings', function (Blueprint $table) {
            $table->boolean("is_add_to_wishlist")->default(1);
            $table->string("layout_detail")->default("detail");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn('is_search_in_header');
        });

        Schema::table('shop_settings', function (Blueprint $table) {
            $table->dropColumn('is_add_to_wishlist');
            $table->dropColumn('layout_detail');
        });
    }
}
