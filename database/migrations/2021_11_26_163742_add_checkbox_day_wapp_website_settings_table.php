<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckboxDayWappWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->String('sunday')->nullable();
            $table->String('hsustart')->nullable();
            $table->String('hsuend')->nullable();
            $table->String('monday')->nullable();
            $table->String('hmostart')->nullable();
            $table->String('hmoend')->nullable();
            $table->String('tuesday')->nullable();
            $table->String('htustart')->nullable();
            $table->String('htuend')->nullable();
            $table->String('wednesday')->nullable();
            $table->String('hwestart')->nullable();
            $table->String('hweend')->nullable();
            $table->String('thursday')->nullable();
            $table->String('hthstart')->nullable();
            $table->String('hthend')->nullable();
            $table->String('friday')->nullable();
            $table->String('hfrstart')->nullable();
            $table->String('hfrend')->nullable();
            $table->String('saturday')->nullable();
            $table->String('hsastart')->nullable();
            $table->String('hsaend')->nullable();


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
            $table->dropColumn('sunday');
            $table->dropColumn('hsustart');
            $table->dropColumn('hsuend');
            $table->dropColumn('monday');
            $table->dropColumn('hmostart');
            $table->dropColumn('hmoend');
            $table->dropColumn('tuesday');
            $table->dropColumn('htustart');
            $table->dropColumn('htuend');
            $table->dropColumn('wednesday');
            $table->dropColumn('hwestart');
            $table->dropColumn('hweend');
            $table->dropColumn('thursday');
            $table->dropColumn('hthstart');
            $table->dropColumn('hthend');
            $table->dropColumn('friday');
            $table->dropColumn('hfrstart');
            $table->dropColumn('hfrend');
            $table->dropColumn('saturday');
            $table->dropColumn('hsastart');
            $table->dropColumn('hsaend');

        });
    }
}
