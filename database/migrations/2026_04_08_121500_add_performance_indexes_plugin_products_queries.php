<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexesPluginProductsQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugins_products', function (Blueprint $table) {
            $table->index(['is_variant', 'is_active', 'brand_id', 'price'], 'pp_idx_variant_active_brand_price');
            $table->index(['group_id', 'is_variant', 'is_active'], 'pp_idx_group_variant_active');
            $table->index(['is_active', 'is_variant', 'qty'], 'pp_idx_active_variant_qty');
        });

        Schema::table('plugins_products_search', function (Blueprint $table) {
            $table->index('plugin_product_id', 'pps_idx_product');
            $table->index(['group_id', 'is_variant', 'is_active', 'plugin_product_id'], 'pps_idx_group_variant_active_product');
        });

        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->index(['is_active', 'parent_id', 'is_purchasable', 'is_in_list_shop_page', 'lft'], 'ppc_idx_active_parent_shop_lft');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->index(['is_in_menu', 'is_active', 'parent_id', 'lft'], 'pages_idx_menu_active_parent_lft');
            $table->index('is_special_shop', 'pages_idx_special_shop');
        });

        Schema::table('shop_attributes_products', function (Blueprint $table) {
            $table->index(['attribute_id', 'option_id', 'product_id'], 'sap_idx_attr_opt_product');
            $table->index(['option_id', 'product_id'], 'sap_idx_opt_product');
        });

        Schema::table('plugins_products_categories_products', function (Blueprint $table) {
            $table->index(['plugin_product_product_id', 'plugin_product_category_id'], 'ppcp_idx_product_category');
        });

        Schema::table('shop_promotions', function (Blueprint $table) {
            $table->index(['is_forced', 'start_date', 'expiration_date'], 'promo_idx_forced_dates');
            $table->index(['category_id', 'start_date', 'expiration_date'], 'promo_idx_category_dates');
            $table->index(['brand_id', 'category_id', 'start_date', 'expiration_date'], 'promo_idx_brand_category_dates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_promotions', function (Blueprint $table) {
            $table->dropIndex('promo_idx_brand_category_dates');
            $table->dropIndex('promo_idx_category_dates');
            $table->dropIndex('promo_idx_forced_dates');
        });

        Schema::table('plugins_products_categories_products', function (Blueprint $table) {
            $table->dropIndex('ppcp_idx_product_category');
        });

        Schema::table('shop_attributes_products', function (Blueprint $table) {
            $table->dropIndex('sap_idx_opt_product');
            $table->dropIndex('sap_idx_attr_opt_product');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex('pages_idx_special_shop');
            $table->dropIndex('pages_idx_menu_active_parent_lft');
        });

        Schema::table('plugins_products_categories', function (Blueprint $table) {
            $table->dropIndex('ppc_idx_active_parent_shop_lft');
        });

        Schema::table('plugins_products_search', function (Blueprint $table) {
            $table->dropIndex('pps_idx_group_variant_active_product');
            $table->dropIndex('pps_idx_product');
        });

        Schema::table('plugins_products', function (Blueprint $table) {
            $table->dropIndex('pp_idx_active_variant_qty');
            $table->dropIndex('pp_idx_group_variant_active');
            $table->dropIndex('pp_idx_variant_active_brand_price');
        });
    }
}

