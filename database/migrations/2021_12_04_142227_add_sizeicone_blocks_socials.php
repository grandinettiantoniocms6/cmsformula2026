<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeiconeBlocksSocials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_socials', function (Blueprint $table) {
            $table->string('social_sizeicon')->nullable();
            $table->string('fa-1x')->nullable();
            $table->string('fa-2x')->nullable();
            $table->string('fa-3x')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_socials', function (Blueprint $table) {
            $table->dropColumn('social_sizeicon');
            $table->dropColumn('fa-1x');
            $table->dropColumn('fa-2x');
            $table->dropColumn('fa-3x');
        });
    }
}
