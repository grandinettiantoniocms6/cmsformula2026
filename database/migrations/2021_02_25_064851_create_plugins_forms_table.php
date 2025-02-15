<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_forms', function (Blueprint $table) {
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

        Schema::create('plugins_forms_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('form_id')->nullable();
            $table->string('email')->nullable();
            $table->string('object')->nullable();
            $table->longText('content')->nullable();
            $table->longText('note')->nullable();
            $table->boolean('is_done')->default(0);
            $table->boolean('is_read')->default(0);
            $table->string('processed_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_forms_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('image')->nullable();
            $table->longText('foto_pdf')->nullable();
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
        Schema::dropIfExists('plugins_forms');
        Schema::dropIfExists('plugins_forms_requests');
        Schema::dropIfExists('plugins_forms_settings');
    }
}
