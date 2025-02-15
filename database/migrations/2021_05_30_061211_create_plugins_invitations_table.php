<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('city')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->boolean('is_login')->nullable();
            $table->dateTime('login_at')->nullable();
            $table->timestamps();
        });


        Schema::create('plugins_invitations_settings', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->unsignedInteger('role_id')->nullable();
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
        Schema::dropIfExists('plugins_invitations');
        Schema::dropIfExists('plugins_invitations_settings');
    }
}
