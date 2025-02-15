<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->unsignedInteger('shipping_id')->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->string('code_referral')->nullable();
            $table->string('code_coupon')->nullable();

            $table->string('paypal_payment_id')->nullable();
            $table->unsignedInteger('number_invoice')->nullable();
            $table->unsignedInteger('year_invoice')->nullable();
            $table->dateTime('payment_date')->nullable();

            $table->string('tracking_code')->nullable();
            $table->unsignedInteger('template_tracking_id')->nullable();
            $table->string('type_order')->default('ecommerce');
            $table->boolean('is_express_checkout')->default(0)->nullable();
            $table->text('result_paypal')->nullable();

            $table->float('total_extra')->nullable();
            $table->float('total_coupon')->default(0);

            $table->float('total_giftcard')->after("total_tax")->default(0);
            $table->string('number_giftcard')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropColumn('shipping_id');
            $table->dropColumn('payment_id');
            $table->dropColumn('code_referral');
            $table->dropColumn('code_coupon');

            $table->dropColumn('paypal_payment_id');
            $table->dropColumn('number_invoice');
            $table->dropColumn('year_invoice');
            $table->dropColumn('payment_date');

            $table->dropColumn('tracking_code');
            $table->dropColumn('template_tracking_id');
            $table->dropColumn('type_order');
            $table->dropColumn('is_express_checkout');
            $table->dropColumn('result_paypal');

            $table->dropColumn('total_extra');
            $table->dropColumn('total_coupon');

            $table->dropColumn('total_giftcard');
            $table->dropColumn('number_giftcard');
        });
    }
}
