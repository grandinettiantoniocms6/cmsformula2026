<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatExcludedPluginsProductsSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_categories', function (Blueprint $table) {
             $table->boolean('is_in_list_shop_page')->default(1);
             $table->text('list_pages')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->dropColumn('is_in_list_shop_page');
            $table->dropColumn('list_pages');
        });
    }
}
