<?php
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$shopSetting = \App\Models\ShopSettings::first();
$pluginSetting = \App\Models\PluginProductsSettings::first();
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();

$indexClass = new \App\Http\Controllers\PluginProductsController();
$cartCompare = $indexClass->loading_compare();
$start = microtime(true);
$agent = new \Jenssegers\Agent\Agent();

$optionsList = \App\Models\ShopAttributesOptions::pluck("icon", "id")->toArray();

?>

<section class="page-shop">
    <div class="container-fluid container-2xl">
        @if(count($products))
        <div class="row gx-2xl-5 mb-3">
            <div class="col-lg-3 d-none d-lg-block">
                <button type="button" class="btn btn-primary w-100" onclick="toggle_class('#sidebar-shop','show-lg')">{{ @$labels['shop-filtri'] }}</button>
            </div>
            <div class="col-lg">
                <?php
                $typ = ["id|asc" => @$labels['meno-recente'], "id|desc" => @$labels['piu-recente'], "name|desc" => @$labels['title-za'], "name|asc" => @$labels['title-az'], "price|asc" => @$labels['price-az'], "price|desc" => @$labels['price-za']];

                if($agent->isMobile() || $agent->isTablet()){
                    if($pluginSetting->number_product_mobile){
                        $typ_res = [$pluginSetting->number_product_mobile *1, $pluginSetting->number_product_mobile*2, $pluginSetting->number_product_mobile*3];
                    }else{
                        $typ_res = [10, 25, 50];
                    }
                }else{
                    if($pluginSetting->number_product){
                        $typ_res = [$pluginSetting->number_product *1, $pluginSetting->number_product*2, $pluginSetting->number_product*3];
                    }else{
                        $typ_res = [10, 25, 50];
                    }
                }
                ?>
                <nav class="navbar navbar-expand py-0">
                    <div class="row flex-grow-1 gx-1 align-items-center flex-nowrap">
                        <div class="col-auto d-lg-none">
                            <button class="btn btn-sm btn-primary open-navbar" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-shop">
                                {{ @$labels['shop-filtri'] }}
                            </button>
                        </div>

                        <div class="col-auto">
                            <nav class="nav nav-pills" id="nav-view">
                                <button class="nav-link @if($shopSetting->shop_view_list == "grid") active @endif" href="#" aria-label="{{ @$labels['lista-griglia'] }}" onclick="view_products(this,'grid','row-cols-1 list-view','row-cols-2 row-cols-sm-2 row-cols-md-{{ $pluginSetting->col_products_for_row }} grid-view')">
                                    <i class="fa fa-th-large"></i>
                                    <span>{{ @$labels['lista-griglia'] }}</span>
                                </button>

                                <button class="nav-link @if($shopSetting->shop_view_list == "list") active @endif" href="#" aria-label="{{ @$labels['lista-pulsante'] }}" onclick="view_products(this,'list','row-cols-2 row-cols-sm-2 row-cols-md-{{ $pluginSetting->col_products_for_row }} grid-view','row-cols-1 list-view')">
                                    <i class="fa fa-bars"></i>
                                    <span>{{ @$labels['lista-pulsante'] }}</span>
                                </button>

                            </nav>
                        </div>

                        <div class="col d-none d-sm-block"></div>


                            <div class="col-auto d-none d-lg-block">
                                <label class="form-label mb-0">{{ @$labels['ordina-per'] }}:</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select form-select-sm" name="order_by" id="order_by" onchange="reload_list()">
                                    @foreach($typ as $t=>$v)
                                        @if($select_order_by == $t)
                                            <option value="{{ $t }}" selected>{{ $v }}</option>
                                        @else
                                            <option value="{{ $t }}">{{ $v }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        <div class="col-auto d-none d-lg-block">
                            <label class="form-label mb-0">{{ @$labels['mostra'] }}:</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm" name="show_number" id="show_number" onchange="reload_list();">
                                @foreach($typ_res as $t=>$v)
                                    @if($select_show_number == $v)
                                        <option value="{{ $v }}" selected>{{ $v }}</option>
                                    @else
                                        <option value="{{ $v }}">{{ $v }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        @endif

        <div class="row gx-2xl-5">
            @if(count($products))

                @if($adminPlugin->version == 3)
                    @include("$thema.plugins.pluginProducts.v3.inc.sidebar_shop")
                @else
                    @include("$thema.plugins.pluginProducts.v3.inc.sidebar")
                @endif


                <div class="col-lg main-content">
                     @if($shopSetting->shop_view_list != "list")
                        <div class="listing row gx-2 gx-lg-3 @if($shopSetting->shop_view_list == "list") row-cols-1 list-view @else row-cols-2 row-cols-sm-2 row-cols-md-{{ $pluginSetting->col_products_for_row }} grid-view @endif" id="box_result_products">

                            @foreach($products as $product)
                                    <?php
                                    $vet_ids = [];


                                    $cat_prod_name = "";
                                    $cat_prod_slug = "no-categoria";

                                    if(@$category){
                                        $cat_prod = $category;
                                    }else{
                                        $cat_prod = $product->category();
                                    }
                                    if($cat_prod){
                                        $cat_prod_name = $cat_prod->name;
                                        $cat_prod_slug = $cat_prod->slug;
                                    }

                                     $vet_ids = [];
                                     if($product->vet_ids_list){
                                         $vet_ids = json_decode($product->vet_ids_list, true);
                                     }
                                    ?>
                                    @include("$thema.plugins.pluginProducts.v3.shop.box_product_list", ['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, 'pluginSetting' => $pluginSetting, "optionsList" => $optionsList])
                            @endforeach

                        </div>
                    @else
                        <div class="listing row gx-2 gx-lg-3 row-cols-2 row-cols-sm-2 row-cols-md-{{ $pluginSetting->col_products_for_row }} grid-view" id="box_result_products">
                            @foreach($products as $product)
                                <?php
                                $vet_ids = [];

                                $cat_prod_name = "";
                                $cat_prod_slug = "no-categoria";
                                if(@$category){
                                    $cat_prod = $category;
                                }else{
                                    $cat_prod = $product->category();
                                }
                                if($cat_prod){
                                    $cat_prod_name = $cat_prod->name;
                                    $cat_prod_slug = $cat_prod->slug;
                                }

                                $vet_ids = [];
                                if($product->vet_ids_list){
                                    $vet_ids = json_decode($product->vet_ids_list, true);
                                }
                                ?>
                                @include("$thema.plugins.pluginProducts.v3.shop.box_product_grid", ['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, 'pluginSetting' => $pluginSetting, "optionsList" => $optionsList])
                            @endforeach
                        </div>
                    @endif

                    <div id="box_pagination" class="w-100">
                        {{ $products->links() }}
                    </div>

                    {!! $pluginSetting->message_info_list_products !!}
                </div>
            @else
                <div class="card-body text-center">
                    <div class="font-5xl"><i class="bi bi-exclamation-octagon"></i></div>
                    <h3 class="mb-4">{!! @$labels['no-results'] !!}</h3>
                    <a class="btn btn-primary px-4" href="#" onclick="history.go(-1)">{!! @$labels['shop-go-back'] !!}</a>
                </div>
            @endif
        </div>
    </div>
</section>



<?php
    $time = microtime(true) - $start;
//echo $time;
?>
