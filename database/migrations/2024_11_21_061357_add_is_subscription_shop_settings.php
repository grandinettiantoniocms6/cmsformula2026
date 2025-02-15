<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSubscriptionShopSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->boolean('is_subscriptions')->default(0);
            $table->unsignedInteger('gg_before_subscriptions')->default(5);
            $table->boolean('is_subscriptions_email')->default(0);
            $table->longText('email_subscriptions');

        });

        Schema::table('plugins_products', function (Blueprint $table) {
            $table->boolean('is_subscription')->default(0);
        });

        Schema::create('users_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->dateTime('last_email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->dropColumn('is_subscriptions');
            $table->dropColumn('gg_before_subscriptions');
            $table->dropColumn('is_subscriptions_email');
            $table->dropColumn('email_subscriptions');
        });

        Schema::table('plugins_products', function (Blueprint $table) {
            $table->dropColumn('is_subscription');
        });

        Schema::dropIfExists('users_subscriptions');
    }
}
