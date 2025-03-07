<?php $pluginSetting = \App\Models\PluginProductsSettings::first(); ?>
<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$shopSetting = \App\Models\ShopSettings::first();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$optionsList = \App\Models\ShopAttributesOptions::pluck("icon", "id")->toArray();

$vet = [];
if($item){
    $website = \App\Models\WebsiteSetting::first();
    $list_ultimi = [];
    if($item->ultimi_inseriti){
        $vet["ultimi"] = @$labels['shop-ultimi-inseriti'] ;
        $list_ultimi = \App\Models\PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
            ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
            ->orderBy("plugins_products.id", "desc")
            ->where("plugins_products.is_variant", 0)
            ->where("plugins_products.is_active", 1)->take($item->number_items)->get();
    }

    $list_vetrina = [];
    if($item->in_vetrina){
        $vet["vetrina"] = @$labels['shop-in-vetrina'] ;
        $list_vetrina = \App\Models\PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
            ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
            ->orderBy("plugins_products.id", "desc")
            ->where("plugins_products.is_variant", 0)
            ->where("plugins_products.is_active", 1)->where("is_evidenza", 1)->take($item->number_items)->get();
    }

    $list_venduti = [];
    if($item->piu_venduti){
        $vet["venduti"] = @$labels['shop-piu-venduti'] ;

        $ids = [];
        $orders_details = \App\Models\PluginOrdersDetail::join("plugins_orders", "plugins_orders.id", "plugins_orders_details.plugin_order_id")
            ->whereNull("plugins_orders.deleted_at")
            ->get();

        if($orders_details){
            foreach ($orders_details as $order_detail){
                $ids[] = $order_detail->plugin_product_id;
            }
        }

        if(count($ids)){
            $list_venduti = \App\Models\PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
                ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
                ->orderBy("plugins_products.id", "desc")
                ->where("plugins_products.is_variant", 0)
                ->where("plugins_products.is_active", 1)->whereIn("id", $ids)->take($item->number_items)->get();
        }

    }


    $list_promo = [];
    if($item->in_promo){
        $vet["promo"] = @$labels['shop-in-promozione'] ;
        $now = \Carbon\Carbon::now()->toDateString();

        $list_promo = \App\Models\PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
            ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
            ->orderBy("plugins_products.data_promo_end", "asc")
            ->where("plugins_products.is_active", 1)
            ->where("plugins_products.is_variant", 0)
            ->whereRaw("(data_promo_start <= '$now' and data_promo_end >= '$now')")
            ->whereNotNull("promo_price")->take($item->number_items)->get();
    }
}
?>
@if(count($vet) && $item)
<section class="block-productlast" id="block-productlast-{{ $item->id }}">
    <div class="container">

        <div class="productlast-filters">
            <button data-filter=".all" class="btn btn-primary active" style="background-color: #575656!important;">{{ @$labels['shop-tutti'] }}</button>

            <?php $i = 0; ?>
            @foreach($vet as $k=>$v)
                @if($k == "venduti" && count($list_venduti))
                    <button data-filter=".{{ $k }}" class="btn btn-primary">{{ $v }}</button>
                @endif
                @if($k == "promo" && count($list_promo))
                    <button data-filter=".{{ $k }}" class="btn btn-primary">{{ $v }}</button>
                @endif
                @if($k == "ultimi" && count($list_ultimi))
                    <button data-filter=".{{ $k }}" class="btn btn-primary">{{ $v }}</button>
                @endif
                @if($k == "vetrina" && count($list_vetrina))
                    <button data-filter=".{{ $k }}" class="btn btn-primary">{{ $v }}</button>
                @endif
                <?php $i++; ?>
            @endforeach
        </div>

        <div class="productlast-grid grid-view row row-cols-2 row-cols-sm-2 row-cols-md-{{ $pluginSetting->col_products_for_row }}">
            @if($list_ultimi)
                @foreach($list_ultimi as $product)
                    <div class="grid-item ultimi all">
                        <?php
                        $vet_ids = [];

                        $cat_prod_name = "";
                        $cat_prod_slug = "no-categoria";
                        $cat_prod = $product->category();
                        if($cat_prod){
                            $cat_prod_name = $cat_prod->name;
                            $cat_prod_slug = $cat_prod->slug;
                        }

                        $product->cover = $product->getCover();

                        $vet_ids = [];
                        if($product->vet_ids_list){
                            $vet_ids = json_decode($product->vet_ids_list, true);
                        }
                        ?>
                        @include("Webshop.plugins.pluginProducts.v3.shop.box_product_grid",['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, "optionsList" => $optionsList])
                    </div>
                @endforeach
            @endif

            @if($list_vetrina)
                @foreach($list_vetrina as $product)
                    <div class="grid-item vetrina all">
                        <?php
                        $vet_ids = [];

                        $cat_prod_name = "";
                        $cat_prod_slug = "no-categoria";
                        $cat_prod = $product->category();
                        if($cat_prod){
                            $cat_prod_name = $cat_prod->name;
                            $cat_prod_slug = $cat_prod->slug;
                        }
                        $product->cover = $product->getCover();

                        $vet_ids = $product->get_vet_ids($shopSetting);
                        ?>
                        @include("Webshop.plugins.pluginProducts.v3.shop.box_product_grid", ['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting])
                    </div>
                @endforeach
            @endif

            @if($list_venduti)
                @foreach($list_venduti as $product)
                    <div class="grid-item venduti all">
                        <?php
                        $vet_ids = [];

                        $cat_prod_name = "";
                        $cat_prod_slug = "no-categoria";
                        $cat_prod = $product->category();
                        if($cat_prod){
                            $cat_prod_name = $cat_prod->name;
                            $cat_prod_slug = $cat_prod->slug;
                        }
                        $product->cover = $product->getCover();
                        ?>
                        @include("Webshop.plugins.pluginProducts.v3.shop.box_product_grid",['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, "optionsList" => $optionsList])
                    </div>
                @endforeach
            @endif

            @if($list_promo)
                @foreach($list_promo as $product)
                    <div class="grid-item promo all">
                        <?php
                        $vet_ids = [];

                        $cat_prod_name = "";
                        $cat_prod_slug = "no-categoria";
                        $cat_prod = $product->category();
                        if($cat_prod){
                            $cat_prod_name = $cat_prod->name;
                            $cat_prod_slug = $cat_prod->slug;
                        }
                        $product->cover = $product->getCover();
                        ?>
                        @include("Webshop.plugins.pluginProducts.v3.shop.box_product_grid", ['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, "optionsList" => $optionsList])
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endif
