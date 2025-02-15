<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$attribute_product = null;

$cont = 0;
$cart_class = new \App\Http\Controllers\CartController();
$my_cart = $cart_class->loading_cart(true);

$v_my_cart = [];
if(count($my_cart)){
    foreach ($my_cart as $mc){
        $v_my_cart[$mc->product_id] = $mc->qty;
    }
}

//prendo il primo attribute in ordine
$attribute_first = \App\Models\ShopAttributes::orderBy("lft", "asc")->first();

//prendo ids varianti
$variants_ids = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)
    ->where("is_variant", 1)
    ->where("is_active", 1)
    ->get()->pluck("id")
    ->toArray();

$attribute_product = null;
$attribute_item_second = null;
$temp_ids = null;
if($attribute_first){
    $attribute_product = \App\Models\ShopAttributesProducts::where("product_id", $itemProduct->id)->where("attribute_id", $attribute_first->id)->first();
    $attribute_item_second = \App\Models\ShopAttributes::where("id", "!=", $attribute_first->id)->orderBy("lft", "asc")->first();

    $temp_ids = \App\Models\PluginProducts::selectRaw("count(*) as tot, code_article, group_concat(id) as ids")
        ->whereIn("id", $variants_ids)
        ->orderBy("code_article", "ASC")
        ->groupBy("code_article")
        ->get();
}

?>


    <form method="post" action="{{ route('add.cart.product.multiple') }}">
        {{ csrf_field() }}

        <div>
            <div class="product--variations">
                @if($attribute_product && count($temp_ids))
                @foreach($temp_ids as $pp)
                    <?php

                    $info = \App\Models\PluginProducts::whereRaw("id IN ($pp->ids)")->first();
                    $attribute_product_ciclo = \App\Models\ShopAttributesProducts::where("product_id", $info->id)->where("attribute_id", $attribute_first->id)->first();

                    $vet_ids = \App\Models\ShopAttributesProducts::selectRaw("GROUP_CONCAT(product_id) as ids, option_id")->whereRaw("product_id IN ($pp->ids)")
                        ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                        ->where("attribute_id", $attribute_first->id)
                        ->orderBy("shop_attributes_options.value", "asc")
                        ->groupBy("option_id")
                        ->get()
                        ->pluck("ids", "option_id")
                        ->toArray();

                    $vet_ids_final = [];
                    if($vet_ids){
                        foreach ($vet_ids as $k=>$v){
                            //tra gli ids quali ha attribute_shop_id 2 con valore inferiore alfabeticamente?
                            $temp_option = \App\Models\ShopAttributesOptions::find($k);
                            $temp_v = explode(",", $v);

                            $options_p = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_products.product_id")
                                ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                                ->whereIn("product_id", $temp_v)
                                ->where("attribute_id", 2)
                                ->orderBy("shop_attributes_options.value", "asc")
                                ->first();

                            $vet_ids[$k] = $options_p->product_id;
                            $vet_ids_final[$temp_option->value] = $options_p->product_id;
                        }
                    }

                    ksort($vet_ids_final);


                    //prendo prodotti con le stesso colore del padre
                    $v_same = [];

                    $same_color = \App\Models\ShopAttributesProducts::join("plugins_products", "plugins_products.id", "=", "shop_attributes_products.product_id")
                        ->where("option_id", $attribute_product->option_id)
                        ->where("attribute_id", $attribute_product->attribute_id)
                        ->where("group_id", $itemProduct->group_id)
                        ->where("code_article", $info->code_article)
                        ->get();

                    if($same_color){
                        foreach ($same_color as $sc){
                            $v_same[] = $sc->product_id;
                        }
                    }

                    $options = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.value,shop_attributes_products.id, shop_attributes_products.product_id")
                        ->join("shop_attributes_options", "shop_attributes_options.id", "shop_attributes_products.option_id")
                        ->where("attribute_id", $attribute_item_second->id)
                        ->whereIn("product_id", $v_same)
                        ->groupBy("value")
                        ->get();
                    ?>
                    <h5><strong>{{ $info->code_article }}</strong> <small> {!! $info->description_short !!}</small></h5>
                    <div class="product-price">
                        <?php
                        $symbol = "&euro;";
                        $start_price = $info->price;
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                            if($info->price_dollar){
                                $symbol = "&#36;";
                                $start_price = $info->price_dollar;
                            }
                        }
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                            if($info->price_2){
                                $symbol = "&euro;";
                                $start_price = $info->price_2;
                            }
                        }

                        $promo_price = $info->get_promo_price();

                        $vat = $info->tax ? $info->tax->value : 22;
                        $vat_calculate = ($vat / 100) + 1;

                        $p_temp = $info;
                        ?>
                        @include("$thema.plugins.pluginProducts.v3.shop.calculate_price")

                        @if($symbol == "&euro;")
                            <?php
                            $price_srp = $info->price_srp;
                            if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                                $price_srp = $info->price_2_srp;
                            }
                            ?>

                            @if($price_srp != 0)
                                <ins class="new-price">{{ @$labels['shop-srp'] }} {!! $symbol !!}
                                    @if(env('VIEW_WITH_IVA') == 1)
                                        {{ number_format($price_srp * 1.22, 2, ",", ".") }}
                                    @else
                                        {{ number_format($price_srp, 2, ",", ".") }}
                                    @endif
                                </ins>
                            @endif
                        @else
                            @if($info->price_srp_dollar != 0)
                                <ins class="new-price">{{ @$labels['shop-srp'] }} {!! $symbol !!}
                                    @if(env('VIEW_WITH_IVA') == 1)
                                       {{ number_format($info->price_srp_dollar * 1.22, 2, ",", ".") }}
                                    @else
                                        {{ number_format($info->price_srp_dollar, 2, ",", ".") }}
                                    @endif
                                </ins>
                            @endif
                        @endif
                    </div>

                    @include("$thema.plugins.pluginProducts.v3.promo")

                    @foreach($vet_ids_final as $product_id)
                        <?php
                        $tempProduct = \App\Models\PluginProducts::where("id", $product_id)->first();
                        if(!$tempProduct){
                            continue;
                        }

                        $attribute_product_ciclo = \App\Models\ShopAttributesProducts::where("product_id", $product_id)->where("attribute_id", $attribute_first->id)->first();

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

                        $symbol = "&euro;";
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                            if($tempProduct->price_dollar){
                                $symbol = "&#36;";
                            }
                        }
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                            if($tempProduct->price_2){
                                $symbol = "&euro;";
                            }
                        }
                        $promo_price = $tempProduct->get_promo_price();

                        if(env('VIEW_WITH_IVA') == 1){
                            $promo_price_format = number_format($promo_price * 1.22, 2, ",", ".");
                        }else{
                            $promo_price_format = number_format($promo_price, 2, ",", ".");
                        }

                        $url = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug, $tempProduct->slug]);
                        ?>
                        @if($attribute_product->option_id == $attribute_product_ciclo->option_id && $tempProduct->code_article == $itemProduct->code_article)
                            <a class="color color-img selected" rel="popover" data-name="{{ $tempProduct->code_article }} {{ $tempProduct->name_variant }}<br>{{ $promo_price_format }} {{ $symbol }}" data-img="{{ $cover }}"><img src="{{ $cover }}" width="30" height="30"></a>
                        @else
                            <a class="color color-img" href="{{ $url }}" rel="popover" data-name="{{ $tempProduct->code_article }} {{ $tempProduct->name_variant }}<br>{{ $promo_price_format }} {{ $symbol }}" data-img="{{ $cover }}" ><img src="{{ $cover }}" width="30" height="30"></a>
                        @endif
                    @endforeach

                    @if($pp->code_article == $itemProduct->code_article)
                    <div class="product-form product-size">
                        <div class="product-form-group">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th></th>
                                    @if($options)
                                        @foreach($options as $option)
                                            <th>{{ $option->value }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>{{ $attribute_item_second->name }}</th>
                                    @if($options)
                                        @foreach($options as $option)
                                            <?php
                                            $value_qty = 0;
                                            if(key_exists($option->product_id, $v_my_cart)){
                                                $value_qty = $v_my_cart[$option->product_id];
                                                $cont++;
                                            }
                                            $variant_p = \App\Models\PluginProducts::find($option->product_id);
                                            $cover = $variant_p->getCover();
                                            ?>
                                            <td><input class="form-control" type="number" name="variants_ids[{{ $variant_p->id }}]" min="0" max="{{ $variant_p->qty }}" value="<?php echo $value_qty;?>" onfocus="this.value=''"></td>
                                        @endforeach
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                @endforeach

                    @endif

                <button class="btn btn-block my-3">{{ @$labels['shop-add-to-cart'] }}</button>
            </div>
        </div>

    </form>

    @if($cont > 0)
        <a href="{{ route('cart') }}" class="btn btn-lg btn-secondary btn-block my-3"><span class="text">{{ @$labels['shop-varie-hai'] }} {{ @$labels['shop-varie-prodotti-di'] }} <strong>{{ $itemProduct->name_variant }}</strong> {{ @$labels['shop-varie-nel-carrello'] }}</span></a>
    @endif



