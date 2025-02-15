<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminThumbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_thumbs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('admin_block_id')->nullable();
            $table->string('suffix')->nullable();
            $table->unsignedInteger('width_max')->nullable();
            $table->unsignedInteger('height_max')->nullable();
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
        Schema::dropIfExists('admin_thumbs');
    }
}
