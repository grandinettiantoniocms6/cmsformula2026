<?php
$shopSetting = \App\Models\ShopSettings::first();
$pluginSetting = \App\Models\PluginProductsSettings::first();
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();

$indexClass = new \App\Http\Controllers\PluginProductsController();
$cartCompare = $indexClass->loading_compare();
$start = microtime(true);

?>

<div class="page-content mb-10 pb-3">
    <div class="container">
        <h5 class="row main-content-wrap gutter-lg">

            @if(count($products))

                @include('common.pluginProducts.inc.sidebar_shop')

                <div class="col-lg-9 main-content">
                <nav class="toolbox sticky-toolbox sticky-content fix-top">
                    <?php
                    $typ = ["id|asc" => @$labels['meno-recente'], "id|desc" => @$labels['piu-recente'], "name|desc" => @$labels['title-za'], "name|asc" => @$labels['title-az']];

                    if($plugin->number_product){
                        $typ_res = [$plugin->number_product *1, $plugin->number_product*2, $plugin->number_product*3];
                    }else{
                        $typ_res = [10, 25, 50];
                    }
                    ?>

                    <div class="toolbox-left">
                        <a href="#" class="toolbox-item left-sidebar-toggle btn btn-sm btn-outline btn-primary btn-rounded btn-icon-right d-lg-none">{{ @$labels['shop-filtri'] }}</a>
                        <div class="toolbox-item toolbox-sort select-box text-dark">
                            <label>{{ @$labels['ordina-per'] }}:</label>
                            <select class="form-control" name="order_by" id="order_by" onchange="reload_list();">
                                @foreach($typ as $t=>$v)
                                    @if($select_order_by == $t)
                                        <option value="{{ $t }}" selected>{{ $v }}</option>
                                    @else
                                        <option value="{{ $t }}">{{ $v }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="toolbox-right">
                        <div class="toolbox-item toolbox-show select-box text-dark">
                            <label>{{ @$labels['mostra'] }}:</label>
                            <select class="form-control" name="show_number" id="show_number" onchange="reload_list();">
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

                 @if($shopSetting->shop_view_list == "list")
                    <div class="col-lg-9 main-content" id="box_result_products">

                        @foreach($products as $product)
                            <?php
                            $cat_prod_name = "";
                            $cat_prod_slug = "no-categoria";
                            $cat_prod = $product->category();
                            if($cat_prod){
                                $cat_prod_name = $cat_prod->name;
                                $cat_prod_slug = $cat_prod->slug;
                            }
                            $cover = $product->getCover();
                            ?>

                                <div class="product-lists product-wrapper">
                                    <div class="product product-list">
                                        <figure class="product-media">
                                            <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}">
                                                 <img class="img-fluid mx-auto" src="{{ $cover }}" alt="" width="260" height="293">
                                                @if($product->getSecondPhoto())
                                                    <img class="img-fluid mx-auto" src="{{ $product->getSecondPhoto() }}" alt="" width="260" height="293">
                                                @endif
                                            </a>
                                            <div class="product-label-group">
                                                @if($product->is_evidenza == 1 && trim(@$labels['shop-in-evidenza']) != "") <label class="product-label label-new" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-in-evidenza'] }}</label> @endif
                                                @if(trim($product->custom_1) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_1 }}">{{ $product->custom_1 }}</label> @endif
                                                @if(trim($product->custom_2) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_2 }}">{{ $product->custom_2 }}</label> @endif
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <div class="product-cat">
                                                <a href="{{ route("pluginProducts.".\App::getLocale(), [$cat_prod_slug]) }}">{{ $cat_prod_name }}</a>
                                            </div>
                                            <h3 class="product-name">
                                                <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="product-price">
                                                <?php
                                                $symbol = "&euro;";
                                                $start_price = $product->price;
                                                if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                                                    if($product->price_dollar){
                                                        $symbol = "&#36;";
                                                        $start_price = $product->price_dollar;
                                                    }
                                                }

                                                if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                                                    if($product->price_2){
                                                        $symbol = "&euro;";
                                                        $start_price = $product->price_2;
                                                    }
                                                }

                                                $promo_price = $product->get_promo_price();

                                                $vat = $product->tax ? $product->tax->value : 22;
                                                $vat_calculate = ($vat / 100) + 1;

                                                $p_temp = $tempProduct;
                                                ?>
                                                @include('common.pluginProducts.shop.calculate_price')
                                            </div>
                                            <p class="product-short-desc">
                                                {!! $product->description_short !!}
                                            </p>
                                            <div class="product-action">
                                                <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}" class="btn-product" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif title="{{ $product->name }}">{{ @$labels['dettaglio-prodotto'] }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                @else
                    <div class="row cols-2  @if(env('PROJECT_NAME') == "Maison-Flaneur") cols-sm-2 @else cols-sm-3 @endif product-wrapper" id="box_result_products">
                        @foreach($products as $product)
                            <?php
                            $vet_ids = [];

                            $cat_prod_name = "";
                            $cat_prod_slug = "no-categoria";
                            $cat_prod = $product->category();
                            if($cat_prod){
                                $cat_prod_name = $cat_prod->name;
                                $cat_prod_slug = $cat_prod->slug;
                            }
                            //$vet_ids = $product->get_vet_ids($shopSetting);
                                $vet_ids = [];
                                if($product->vet_ids_list){
                                    $vet_ids = json_decode($product->vet_ids_list, true);
                                }
                            ?>
                            @include('common.pluginProducts.shop.box_product_grid', ['shopSetting' => $shopSetting])
                        @endforeach
                    </div>
                @endif

                <nav class="toolbox toolbox-pagination" id="box_pagination">
                    {{ $products->links() }}
                </nav>
            </div>
            @else
                <section class="page-section-ptb">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="search-no-result text-left text-sm-center clearfix position-relative">
                                    <div class="bg-title">
                                        <h2>oops</h2>
                                    </div>
                                    <div class="search-icon d-inline-block mr-30 mr-sm-40 position-relative">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <div class="search-contant d-inline-block text-left position-relative mt-20 mt-sm-0">
                                        <h2>{!! @$labels['no-results'] !!}</h2>
                                        <p></p>
                                        <div class="error-info mt-30">
                                            <a class="button xs-mb-10" href="#" onclick="history.go(-1)">{!! @$labels['shop-go-back'] !!}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            @endif
        </div>
    </div>
</div>

<?php
// Execute the query
$time = microtime(true) - $start;
//echo $time;
?>


<script type="text/javascript">

    function filtersCounter() {
        var count = $('#sidebar input:checked').length;
        if (count>0) {
            $('#btn-filter .counter').text('('+count+')');
        } else {
            $('#btn-filter .counter').text('');
        }
    }

</script>
