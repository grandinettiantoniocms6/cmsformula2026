<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_brands', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('title_it')->nullable();
            $table->string('txtcolor')->default('#000000');
            $table->string('title_align')->default('center');
            $table->string('url_interno')->nullable();
            $table->string('type_href')->nullable();
            $table->string('url')->nullable();
            $table->longText('foto')->nullable();
            $table->string('button')->nullable();
            $table->unsignedInteger("col")->default(5);
            $table->unsignedInteger('style')->default(1);
            // necessari
            $table->id();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('blocks_brands');
    }
}
