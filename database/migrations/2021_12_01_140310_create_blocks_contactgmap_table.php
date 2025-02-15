<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksContactgmapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_contactgmaps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            // questi invece sono gli input che mi servono per il nuovo blocco
            $table->string('bg_box')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('title')->nullable();
            $table->string('color_txt')->nullable();
            $table->longText('description')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->text('address3')->nullable();
            $table->text('phone1')->nullable();
            $table->text('phone2')->nullable();
            $table->text('phone3')->nullable();
            $table->text('fax')->nullable();
            $table->text('email1')->nullable();
            $table->text('email2')->nullable();
            $table->text('email3')->nullable();
            $table->text('pec')->nullable();
            $table->longText('description2')->nullable();
            $table->text('url')->nullable();
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
        Schema::dropIfExists('blocks_contactgmaps');
    }
}
