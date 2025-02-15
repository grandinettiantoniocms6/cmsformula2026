<?php
$thema = env('TEMA');
$website = \App\Models\WebsiteSetting::first();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$shopSetting = \App\Models\ShopSettings::first();
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")

    @if($adminPlugin->version == 3)
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/fontawesome-free/css/all.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/animate/animate.min.css") }}">

        <!-- Plugins CSS Files -->
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/magnific-popup/magnific-popup.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/owl-carousel/owl.carousel.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/nouislider/nouislider.min.css") }}">

        <!-- Main CSS File -->
        @if($website->style_css_shoppy)
            <link rel="stylesheet" type="text/css" href="{{ url("$website->style_css_shoppy") }}" />
        @else
            <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/css/style.min.css") }}">
        @endif

        <link rel="stylesheet" type="text/css" href="{{ url("css_common/basic_shoppy_fix.css") }}">
        <style>
            .btn-shoppy:hover {
                background-color: {{ $website->btn_hover_background }}!important;
            }
            .box-comparatore {
                width: 260px;
            }
        </style>
    @endif
@endsection

@section('meta')
    @include("$thema.inc.meta")
@endsection
@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @include("$thema.inc.topbar")
    @endsection

@section('topbar_ecommerce')
    @include("$thema.inc.topbar_ecommerce")
@endsection

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content')

         <section class="shop py-4 py-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title-name">
                            <h2>{{ @$labels['shop-title-comparatore'] }}</h2>

                            @if($cart)
                                <?php
                                $v_products = [];
                                ?>
                                @foreach($cart as $id)
                                    <?php
                                    $tempProduct = \App\Models\PluginProducts::find($id);
                                    if (!$tempProduct) {
                                        continue;
                                    }
                                    $v_products[] = $tempProduct;
                                    ?>
                                @endforeach


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="bg-light" width="130"></td>
                                            @foreach($v_products as $tempProduct)
                                                <td class="text-center">
                                                    <a href="{{ route('advice.compare.remove', [$tempProduct->id]) }}"
                                                       class="btn btn-danger btn-sm"><i class="las la-times"></i> {{ @$labels['shop-rimuovi-comparatore'] }}</a>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Prodotto</td>
                                            @foreach($v_products as $tempProduct)
                                                <?php
                                                if(env("PROJECT_NAME") == "Maison-Flaneur"){
                                                    $cover = $tempProduct->getLastPhoto();
                                                }else{
                                                    $cover = $tempProduct->getCover();
                                                }

                                                $cat_prod_name = "";
                                                $cat_prod_slug = "no-categoria";

                                                $cat_prod = $tempProduct->category();
                                                if($cat_prod){
                                                    $cat_prod_name = $cat_prod->name;
                                                    $cat_prod_slug = $cat_prod->slug;
                                                }

                                                $url = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug, $tempProduct->slug])
                                                ?>

                                                <?php
                                                if(!$shopSetting->list_image_width){
                                                    $width = 1;
                                                }else{
                                                    $width = $shopSetting->list_image_width;
                                                }
                                                if(!$shopSetting->list_image_height){
                                                    $height = 1;
                                                }else{
                                                    $height = $shopSetting->list_image_height;
                                                }
                                                $style = "aspect-ratio: $width /$height; object-fit: $shopSetting->list_image_fit;";
                                                ?>
                                                <td class="text-center" width="300">
                                                    <div class="box-comparatore">
                                                        <a class="d-block" href="{{ $url }}">
                                                            <img class="img-fluid" src="{{ $cover }}" width="280" height="315" style="{{ $style }}">
                                                        </a>
                                                        <h3 class="product-name text-center px-0">
                                                            <a href="{{ $url }}">{{ $tempProduct->name }}</a>
                                                        </h3>
                                                        @if(!$tempProduct->in_cart())
                                                            <form method="post" action="{{ route('add.cart.product') }}">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $tempProduct->id }}">
                                                                <div class="product-form product-qty">
                                                                    <div class="product-form-group">
                                                                        <input type="hidden" name="qty" value="1">
                                                                        <button class="btn btn-product btn-shoppy text-normal ls-normal font-weight-semi-bold" type="submit" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};"><i class="fas fa-shopping-cart" style="color: {{ $website->btn_txt_color }}"></i> <span class="pl-2" style="color: {{ $website->btn_txt_color }}">{{ @$labels['shop-add-to-cart'] }}</span></button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Codice</td>
                                            @foreach($v_products as $tempProduct)
                                                <td class="text-center">{{ $tempProduct->sku }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Prezzo</td>
                                            @foreach($v_products as $tempProduct)
                                                <td class="text-center">
                                                    <?php
                                                    $symbol = "&euro;";
                                                    $start_price = $tempProduct->price;
                                                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                                                        if($tempProduct->price_dollar){
                                                            $symbol = "&#36;";
                                                            $start_price = $tempProduct->price_dollar;
                                                        }
                                                    }
                                                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                                                        if($tempProduct->price_2){
                                                            $symbol = "&euro;";
                                                            $start_price = $tempProduct->price_2;
                                                        }
                                                    }
                                                    $promo_price = $tempProduct->get_promo_price();

                                                    $vat = $tempProduct->tax ? $tempProduct->tax->value : 22;
                                                    $vat_calculate = ($vat / 100) + 1;

                                                    $p_temp = $tempProduct;
                                                    ?>
                                                    @include('common.pluginProducts.shop.calculate_price')
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Categoria</td>
                                            @foreach($v_products as $tempProduct)
                                                <?php
                                                $cat_prod_name = "";
                                                $cat_prod_slug = "no-categoria";

                                                $cat_prod = $tempProduct->category();
                                                if($cat_prod){
                                                    $cat_prod_name = $cat_prod->name;
                                                    $cat_prod_slug = $cat_prod->slug;
                                                }
                                                ?>
                                                <td class="text-center">{{ $cat_prod_name }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Brand</td>
                                            @foreach($v_products as $tempProduct)
                                                <?php
                                                $cat_brand = $tempProduct->brand;
                                                ?>
                                                <td class="text-center">
                                                    @if($cat_brand)
                                                    {{ $cat_brand->name }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Descrizione</td>
                                            @foreach($v_products as $tempProduct)
                                                <td class="text-center">
                                                    <?php $text = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $tempProduct->description); ?>
                                                    {!! $text !!}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="bg-light">{{ @$labels['shop-proprieta-comparatore'] }}</td>
                                            @foreach($v_products as $tempProduct)
                                                <?php
                                                $tempProduct->options = \App\Models\PluginProductsOptions::selectRaw("plugins_products_attributes.name, plugins_products_options.attribute_id, plugins_products_options.value")
                                                    ->join("plugins_products_attributes", "plugins_products_attributes.id", "=", "plugins_products_options.attribute_id")
                                                    ->where("product_id", $tempProduct->id)
                                                    ->orderBy("plugins_products_options.lft", "asc")
                                                    ->get();
                                                ?>
                                                <td class="text-center">
                                                    @if(count($tempProduct->options))
                                                        @if(count($tempProduct->options))
                                                            <figure class="size-table mt-4 mb-4">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                    @foreach($tempProduct->options as $option)
                                                                        <?php
                                                                        $name = json_decode($option->name, true);
                                                                        if(!key_exists(\App::getLocale(), $name)){
                                                                            continue;
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <th scope="row"> {{ $name[\App::getLocale()] }}</th>
                                                                            <td>{{ $option->value }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </figure>
                                                        @endif
                                                    @else
                                                        {{ @$labels['shop-nessuna-comparatore'] }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @else
                                <div class="text-center p-3">{{ @$labels['shop-no-prod-sel-comparatore'] }}</div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endsection

    @section('content_footer')
        <?php  $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif

@section('after_scripts')
    @if($adminPlugin->version == 3)
        <script src="{{ url("templates/Shoppy/vendor_plugins/sticky/sticky.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/imagesloaded/imagesloaded.pkgd.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/elevatezoom/jquery.elevatezoom.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/magnific-popup/jquery.magnific-popup.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/owl-carousel/owl.carousel.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/nouislider/nouislider.min.js") }}"></script>
        <!-- Main JS File -->
       <script src="{{ url("templates/Shoppy/js/basicshop.js") }}"></script>
    @endif
@endsection
