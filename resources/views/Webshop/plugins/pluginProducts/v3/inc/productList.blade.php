<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$agent = new \Jenssegers\Agent\Agent();
?>
@if(count($products))
    <div class="row" id="filters-bar">
        <div class="col-auto d-lg-none">
            <button class="btn btn-light btn-sm px-2 py-1" id="btn-filter" data-toggle="show" data-target="#sidebar-shop">
                <i class="fa fa-filter"></i><span class="pl-1">{{ @$labels['shop-filtri'] }}</span>
            </button>
        </div>
        <div class="col">
            <ul class="nav nav-pills justify-content-lg-start justify-content-end">
                <li class="nav-item">
                    <span class="nav-link cursor-pointer px-2 py-1 active" href="#" onclick="view(this, 'list')">
                        <i class="fa fa-bars"></i>
                        <span class="pl-1 d-none d-lg-inline">{{ @$labels['lista-pulsante'] }}</span>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link cursor-pointer px-2 py-1" href="#" onclick="view(this, 'grid')">
                        <i class="fa fa-th-large"></i>
                        <span class="pl-1 d-none d-lg-inline">{{ @$labels['lista-griglia'] }}</span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="col-12 my-2 d-lg-none"></div>

        <?php
        $typ = ["id|asc" => @$labels['meno-recente'], "id|desc" => @$labels['piu-recente'], "name|desc" => @$labels['title-za'], "name|asc" => @$labels['title-az'], "price|asc" => @$labels['price-az'], "price|desc" => @$labels['price-za']];

        if($agent->isMobile() || $agent->isTablet()){
            if($plugin->number_product_mobile){
                $typ_res = [$plugin->number_product_mobile *1, $plugin->number_product_mobile*2, $plugin->number_product_mobile*3];
            }else{
                $typ_res = [10, 25, 50];
            }
        }else{
            if($plugin->number_product){
                $typ_res = [$plugin->number_product *1, $plugin->number_product*2, $plugin->number_product*3];
            }else{
                $typ_res = [10, 25, 50];
            }
        }


        ?>
        <div class="col col-lg-auto d-flex align-items-center">
            <span class="px-2 small text-nowrap">{{ @$labels['ordina-per'] }}</span>
            <select class="custom-select custom-select-sm my-0" name="order_by" id="order_by" onchange="reload_list();">
                @foreach($typ as $t=>$v)
                    @if($select_order_by == $t)
                        <option value="{{ $t }}" selected>{{ $v }}</option>
                    @else
                        <option value="{{ $t }}">{{ $v }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-auto d-flex align-items-center">
            <span class="px-2 small text-nowrap">{{ @$labels['mostra'] }}</span>
            <select class="custom-select custom-select-sm my-0" name="show_number" id="show_number" onchange="reload_list();">
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
    <div class="list my-4">
        <div class="row">
            @foreach($products as $product)
                <div class="product listing list-view col-12 mb-4">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 product-image-col">
                            <div class="product-image">
                                <?php
                                $cat_prod_name = "";
                                $cat_prod_slug = "no-categoria";
                                $cat_prod = $product->category();
                                if($cat_prod){
                                    $cat_prod_name = $cat_prod->name;
                                    $cat_prod_slug = $cat_prod->slug;
                                }
                                ?>
                                <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}">
                                    @if($product->cover)
                                        <img class="img-fluid mx-auto" src="{{ $product->cover }}" alt="{{ $product->name }}">
                                    @else
                                        <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $product->name }}">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 product-des-col">
                            <div class="product-des">
                                <div class="product-title">
                                    @if($product->is_evidenza == 1) <i class="fas fa-star"></i> @endif
                                    <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}">{{ $product->name }}</a>
                                </div>
                                @if($plugin->show_prices && $product->price !== null && trim($product->price) != "")
                                    <div class="product-price">
                                        @if($product->in_promo == 1)
                                            @if($product->promo_price < $product->price)
                                                <ins>&euro; {{ number_format($product->promo_price, 2, ",", ".") }}</ins>
                                                <del class="badge badge-primary badge-size-normal badge-weight-normal">&euro; {{ number_format($product->price, 2, ",", ".") }}</del>
                                            @else
                                                <ins>&euro; {{ number_format($product->price, 2, ",", ".") }}</ins>
                                            @endif
                                        @else
                                            <ins>&euro; {{ number_format($product->price, 2, ",", ".") }}</ins>
                                        @endif
                                    </div>
                                @endif
                                <div class="product-info">
                                    <p class="mt-2">{!! $product->description_short !!}</p>
                                    <a class="btn" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};" href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}"><span style="color: {{ $website->btn_txt_color }}"> {{ @$labels['dettaglio-prodotto'] }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $products->links() }}
    </div>
    <script>
        function reload_list(){
            var order_by = $("#order_by").val();
            var show_number =  $("#show_number").val();

            @if(isset($_GET['search']))
                location.href = "?search={{ $_GET['search'] }}&order_by="+order_by+"&show_number="+show_number;
            @else
                location.href = "?order_by="+order_by+"&show_number="+show_number;
            @endif
        }
    </script>
@else
    {!! $plugin->no_results !!}
@endif
