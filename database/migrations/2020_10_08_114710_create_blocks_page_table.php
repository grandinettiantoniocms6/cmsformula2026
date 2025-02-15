<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_pages', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->unsignedInteger('obj_id')->nullable();
            $table->unsignedInteger('page_id')->nullable();
            $table->string('position')->nullable();
            $table->unsignedInteger('col')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks_pages');
    }
}
