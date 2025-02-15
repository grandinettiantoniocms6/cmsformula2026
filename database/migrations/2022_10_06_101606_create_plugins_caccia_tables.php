<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsCacciaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_caccia_hunters', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('code')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_caccia_chiefs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_caccia_hunters_chiefs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hunter_id')->nullable();
            $table->unsignedInteger('chief_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->date('date_associate')->nullable();
            $table->unsignedInteger('status_id')->nullable();
            $table->unsignedInteger('esito_id')->nullable();
            $table->float('point')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_caccia_hunters_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hunter_id')->nullable();
            $table->unsignedInteger('chief_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('hunter_chief_id')->nullable();

            $table->float('point')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_caccia_settings', function (Blueprint $table) {
            $table->id();
            $table->float('min_points')->default(100);
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
        Schema::dropIfExists('plugins_caccia_hunters');
        Schema::dropIfExists('plugins_caccia_chiefs');
        Schema::dropIfExists('plugins_caccia_hunters_chiefs');
        Schema::dropIfExists('plugins_caccia_hunters_points');
        Schema::dropIfExists('plugins_caccia_settings');
    }
}
