<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMessaggioRingraziamentoPluginsProductsContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_contacts', function (Blueprint $table) {
            $table->text('message_ringraziamento')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products_contacts', function (Blueprint $table) {
            $table->string('message_ringraziamento')->change();
        });
    }
}
