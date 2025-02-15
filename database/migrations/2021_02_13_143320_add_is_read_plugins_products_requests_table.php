<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadPluginsProductsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products_requests', function (Blueprint $table) {
            $table->boolean('is_read')->default(0);
            $table->string('processed_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugins_products_requests', function (Blueprint $table) {
            $table->dropColumn('is_read');
            $table->dropColumn('processed_by');
        });
    }
}
