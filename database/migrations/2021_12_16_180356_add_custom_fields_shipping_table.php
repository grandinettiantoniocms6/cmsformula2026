<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->longText('custom_fields_shipping')->nullable();
        });

        Schema::table('shop_addresses', function (Blueprint $table) {
            $table->longText('custom_fields_shipping')->nullable();
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
            $table->dropColumn('custom_fields_shipping');
        });

        Schema::table('shop_addresses', function (Blueprint $table) {
            $table->dropColumn('custom_fields_shipping');
        });
    }
}
