<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemIncNavStyleAdminTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_templates', function (Blueprint $table) {
            $table->string('inc')->nullable();
            $table->string('nav_style')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_templates', function (Blueprint $table) {
            $table->dropColumn('inc');
            $table->dropColumn('nav_style');
        });
    }
}
