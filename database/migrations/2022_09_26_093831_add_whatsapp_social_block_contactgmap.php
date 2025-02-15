<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhatsappSocialBlockContactgmap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_contactgmaps', function (Blueprint $table) {
            $table->text('whatsapp')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('orari')->nullable();
            $table->longText('come_raggiungerci')->nullable();
            $table->unsignedInteger('style')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_contactgmaps', function (Blueprint $table) {
            $table->dropColumn('whatsapp');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('linkedin');
            $table->dropColumn('orari');
            $table->dropColumn('come_raggiungerci');
            $table->dropColumn('style');

        });
    }
}
