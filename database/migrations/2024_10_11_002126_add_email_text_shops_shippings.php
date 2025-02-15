<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailTextShopsShippings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_shippings', function (Blueprint $table) {
            $table->boolean('is_send_email')->default(0);
            $table->longText('email_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_shippings', function (Blueprint $table) {
            $table->dropColumn('is_send_email');
            $table->dropColumn('email_description');
        });
    }
}
