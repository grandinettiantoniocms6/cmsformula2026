<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckboxDayWapp2WebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->longText('sunday2')->nullable();
            $table->longText('hsu2start')->nullable();
            $table->longText('hsu2end')->nullable();
            $table->longText('monday2')->nullable();
            $table->longText('hmo2start')->nullable();
            $table->longText('hmo2end')->nullable();
            $table->longText('tuesday2')->nullable();
            $table->longText('htu2start')->nullable();
            $table->longText('htu2end')->nullable();
            $table->longText('wednesday2')->nullable();
            $table->longText('hwe2start')->nullable();
            $table->longText('hwe2end')->nullable();
            $table->longText('thursday2')->nullable();
            $table->longText('hth2start')->nullable();
            $table->longText('hth2end')->nullable();
            $table->longText('friday2')->nullable();
            $table->longText('hfr2start')->nullable();
            $table->longText('hfr2end')->nullable();
            $table->longText('saturday2')->nullable();
            $table->longText('hsa2start')->nullable();
            $table->longText('hsa2end')->nullable();
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
            $table->dropColumn('sunday2');
            $table->dropColumn('hsu2start');
            $table->dropColumn('hsu2end');
            $table->dropColumn('monday2');
            $table->dropColumn('hmo2start');
            $table->dropColumn('hmo2end');
            $table->dropColumn('tuesday2');
            $table->dropColumn('htu2start');
            $table->dropColumn('htu2end');
            $table->dropColumn('wednesday2');
            $table->dropColumn('hwe2start');
            $table->dropColumn('hwe2end');
            $table->dropColumn('thursday2');
            $table->dropColumn('hth2start');
            $table->dropColumn('hth2end');
            $table->dropColumn('friday2');
            $table->dropColumn('hfr2start');
            $table->dropColumn('hfr2end');
            $table->dropColumn('saturday2');
            $table->dropColumn('hsa2start');
            $table->dropColumn('hsa2end');
        });
    }
}
