<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesPluginsBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_booking_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->string('abstract')->nullable();
            $table->text('description')->nullable();
            $table->longText('cover_photo')->nullable();
            $table->float('price')->nullable();
            $table->float('promo_price')->nullable();
            $table->date('data_promo_start')->nullable();
            $table->date('data_promo_end')->nullable();
            $table->unsignedInteger('qty_min')->nullable();
            $table->unsignedInteger('qty_max')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            $table->boolean('is_active')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });

        Schema::create('plugins_booking_rooms_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_room_id')->nullable();
            $table->longText('image')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            $table->boolean('is_active')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_booking_services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->longText('photo')->nullable();
            $table->float('price_1')->nullable();
            $table->float('price_2')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            $table->boolean('is_active')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_booking_rooms_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_booking_room_id')->nullable();
            $table->unsignedInteger('plugin_booking_service_id')->nullable();
            $table->boolean('is_free')->nullable();
            $table->timestamps();
        });

        Schema::create('plugins_booking_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('active_payment')->nullable();
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
        Schema::dropIfExists('plugins_booking_rooms');
        Schema::dropIfExists('plugins_booking_services');
        Schema::dropIfExists('plugins_booking_rooms_services');
        Schema::dropIfExists('plugins_booking_rooms_images');
        Schema::dropIfExists('plugins_booking_settings');
    }
}
