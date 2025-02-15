<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressPluginsInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_invitations', function (Blueprint $table) {
            $table->string('ship_name')->nullable();
            $table->string('ship_country_id')->nullable();
            $table->string('ship_address1')->nullable();
            $table->string('ship_county')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_postal_code')->nullable();
            $table->string('ship_phone')->nullable();
            $table->string('ship_mobile_phone')->nullable();
            $table->string('ship_comment')->nullable();


            $table->string('fatt_name')->nullable();
            $table->string('fatt_business_name')->nullable();
            $table->string('fatt_country_id')->nullable();
            $table->string('fatt_address1')->nullable();
            $table->string('fatt_county')->nullable();
            $table->string('fatt_city')->nullable();
            $table->string('fatt_fiscal_code_vat')->nullable();
            $table->string('fatt_pec')->nullable();
            $table->string('fatt_sdi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_invitations', function (Blueprint $table) {
            $table->dropColumn('ship_name');
            $table->dropColumn('ship_country_id');
            $table->dropColumn('ship_address1');
            $table->dropColumn('ship_county');
            $table->dropColumn('ship_city');
            $table->dropColumn('ship_postal_code');
            $table->dropColumn('ship_phone');
            $table->dropColumn('ship_mobile_phone');

            $table->dropColumn('fatt_name');
            $table->dropColumn('fatt_business_name');
            $table->dropColumn('fatt_country_id');
            $table->dropColumn('fatt_address1');
            $table->dropColumn('fatt_county');
            $table->dropColumn('fatt_city');
            $table->dropColumn('fatt_fiscal_code_vat');
            $table->dropColumn('fatt_pec');
            $table->dropColumn('fatt_sdi');
        });
    }
}
