<?php $plugin = \App\Models\PluginProductsSettings::first(); ?>
<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$shopSetting = \App\Models\ShopSettings::first();
$vet = [];
if($item){
    $website = \App\Models\WebsiteSetting::first();
    $list_ultimi = [];
    if($item->ultimi_inseriti){
        $vet["ultimi"] = "Ultimi inseriti";
        $list_ultimi = \App\Models\PluginProducts::orderBy("id", "desc")->where("is_active", 1)->take($item->number_items)->get();
    }

    $list_vetrina = [];
    if($item->in_vetrina){
        $vet["vetrina"] = "In vetrina";
        $list_vetrina = \App\Models\PluginProducts::orderBy("id", "desc")->where("is_active", 1)->where("is_evidenza", 1)->take($item->number_items)->get();
    }

    $list_venduti = [];
    if($item->piu_venduti){
        $vet["venduti"] = "Più venduti";

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
            $list_venduti = \App\Models\PluginProducts::orderBy("id", "desc")->where("is_active", 1)->whereIn("id", $ids)->take($item->number_items)->get();
        }

    }


    $list_promo = [];
    if($item->in_promo){
        $vet["promo"] = "In promozione";
        $now = \Carbon\Carbon::now()->toDateString();

        $list_promo = \App\Models\PluginProducts::orderBy("data_promo_end", "asc")
            ->where("is_active", 1)
            ->whereRaw("(data_promo_start <= '$now' and data_promo_end >= '$now')")
            ->whereNotNull("promo_price")->take($item->number_items)->get();
    }
}
?>
@if(count($vet) && $item)
<section class="shop grid page-section-ptb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="isotope-filters">
                    <button data-filter=".all" class="active">Tutti</button>

                    <?php $i = 0; ?>
                    <?php $start = ""; ?>
                    @foreach($vet as $k=>$v)
                        <?php
                        if($i == 0){
                            $start = $k;
                        }
                        ?>

                        @if($k == "venduti" && count($list_venduti))
                            <button data-filter=".{{ $k }}">{{ $v }}</button>
                        @endif
                        @if($k == "promo" && count($list_promo))
                            <button data-filter=".{{ $k }}">{{ $v }}</button>
                        @endif
                        @if($k == "ultimi" && count($list_ultimi))
                            <button data-filter=".{{ $k }}">{{ $v }}</button>
                        @endif
                        @if($k == "vetrina" && count($list_vetrina))
                            <button data-filter=".{{ $k }}">{{ $v }}</button>
                        @endif


                        <?php $i++; ?>
                    @endforeach
                </div>
                <div class="isotope columns-3">
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
                            ?>
                            @include('common.pluginProducts.shop.box_product_grid')
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
                                ?>
                                @include('common.pluginProducts.shop.box_product_grid')
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
                                @include('common.pluginProducts.shop.box_product_grid')
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
                                @include('common.pluginProducts.shop.box_product_grid',['shopSetting' => $shopSetting])
                            </div>
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
    </div>
</section>
@endif
