<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsCheckoutShopSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->longText('custom_fields_checkout')->nullable();
        });

        Schema::table('shop_companies', function (Blueprint $table) {
            $table->longText('custom_fields_checkout')->nullable();
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
            $table->dropColumn('custom_fields_checkout');
        });

        Schema::table('shop_companies', function (Blueprint $table) {
            $table->dropColumn('custom_fields_checkout');
        });
    }
}
