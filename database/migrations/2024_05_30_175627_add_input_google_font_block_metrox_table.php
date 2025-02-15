<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputGoogleFontBlockMetroxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks_metroxs', function (Blueprint $table) {
            $table->text('google_font')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('h_subtitle')->nullable();
            $table->string('color_subtitle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks_metroxs', function (Blueprint $table) {
            $table->dropColumn('google_font');
            $table->dropColumn('subtitle');
            $table->dropColumn('h_subtitle');
            $table->dropColumn('color_subtitle');

        });
    }
}
