<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_staffs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // questi invece sono gli input che mi servono per il nuovo blocco
            $table->string('col')->nullable();
            $table->longText('foto')->nullable();
            $table->string('social_1')->nullable();
            $table->string('type_href_1')->nullable();
            $table->string('url_1')->nullable();
            $table->string('social_2')->nullable();
            $table->string('type_href_2')->nullable();
            $table->string('url_2')->nullable();
            $table->string('social_3')->nullable();
            $table->string('type_href_3')->nullable();
            $table->string('url_3')->nullable();
            $table->string('social_4')->nullable();
            $table->string('type_href_4')->nullable();
            $table->string('url_4')->nullable();
            $table->string('name_surname')->nullable();
            $table->string('role')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->string('button')->nullable();

            // questi sono obbligatori
            $table->string('name')->nullable();
            $table->unsignedInteger('block_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks_staffs');
    }
}
