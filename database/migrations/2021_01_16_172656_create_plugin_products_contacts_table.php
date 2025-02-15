<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginProductsContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_products_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('cc')->nullable();
            $table->text('ccn')->nullable();
            $table->longText('content')->nullable();

            $table->string('name_mitt')->nullable();
            $table->string('object_form')->nullable();
            $table->string('message_ringraziamento')->nullable();
            $table->text('title_form')->nullable();
            $table->text('subtitle_form')->nullable();

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
        Schema::dropIfExists('plugins_products_contacts');
    }
}
