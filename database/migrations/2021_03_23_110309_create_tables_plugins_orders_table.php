<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesPluginsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_order_client_id')->nullable();
            $table->unsignedInteger('plugin_order_status_id')->nullable();
            $table->unsignedInteger('plugin_order_category_id')->nullable();
            $table->float('total')->nullable();
            $table->date('date_delivery')->nullable();
            $table->time('time_delivery')->nullable();
            $table->string('place_ritiro')->nullable();
            $table->text('note')->nullable();

            $table->unsignedInteger('user_id');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_orders_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plugin_order_id')->nullable();
            $table->unsignedInteger('plugin_product_id')->nullable();
            $table->unsignedInteger('qty')->default(1);
            $table->float('price')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_orders_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_orders_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->longText('image')->nullable();
            $table->string('price')->nullable();
            $table->unsignedInteger('plugin_order_category_id')->nullable();
            $table->text('note')->nullable();

            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_orders_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('type_id')->default(0);
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_orders_clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('fiscal_code')->nullable();
            $table->date('birthday')->nullable();
            $table->string('place_birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('business_name')->nullable();
            $table->string('vat')->nullable();
            $table->string('sdi')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->text('note')->nullable();

            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plugins_orders_settings', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();

            $table->time("planning_start")->nullable();
            $table->time("planning_end")->nullable();
            $table->unsignedInteger("planning_slot")->nullable();
            $table->string("planning_view")->nullable();

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
        Schema::dropIfExists('plugins_orders');
        Schema::dropIfExists('plugins_orders_details');
        Schema::dropIfExists('plugins_orders_statuses');
        Schema::dropIfExists('plugins_orders_products');
        Schema::dropIfExists('plugins_orders_categories');
        Schema::dropIfExists('plugins_orders_clients');
        Schema::dropIfExists('plugins_orders_settings');
    }
}
