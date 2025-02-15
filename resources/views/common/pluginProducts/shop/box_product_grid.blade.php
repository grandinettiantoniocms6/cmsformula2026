<?php
//$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
//$shopSetting = \App\Models\ShopSettings::first();
?>

<div class="product-wrap">
    <div class="product">
        <figure class="product-media">
            <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}">
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

                @if(env('local') == 1)
                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="" width="280" height="315" style="{{ $style }}">
                @else
                    @if($product->cover)
                        <img loading="lazy" class="img-fluid mx-auto" src="{{ $product->cover }}" alt="" width="280" height="315" style="{{ $style }}">
                        @if($product->getSecondPhoto())
                            <img loading="lazy" class="img-fluid mx-auto" src="{{ $product->getSecondPhoto() }}" alt="" width="280" height="315" style="{{ $style }}">
                        @endif
                    @else
                        <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="" width="280" height="315" style="{{ $style }}">
                    @endif
                @endif

            </a>
            <div class="product-label-group">
                @if($product->is_evidenza == 1 && trim(@$labels['shop-in-evidenza']) != "") <label class="product-label label-new" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-in-evidenza'] }}</label> @endif
                @if(trim($product->custom_1) != "") <label class="product-label" @if($shopSetting->custom_color_1) style="background-color:{{ $shopSetting->custom_color_1 }}!important;" @endif>{{ $product->custom_1 }}</label> @endif
                @if(trim($product->custom_2) != "") <label class="product-label" @if($shopSetting->custom_color_2) style="background-color:{{ $shopSetting->custom_color_2 }}!important;" @endif>{{ $product->custom_2 }}</label> @endif
            </div>
            <div class="product-action-vertical">
               @if(env('PROJECT_NAME') != "Maison-Flaneur")
                    @if(env('SLUG_COMPARE'))
                        <?php
                        $indexClass = new \App\Http\Controllers\PluginProductsController();
                        $cartCompare = $indexClass->loading_compare();
                        ?>
                        <div id="compare_{{ $product->id }}">
                            @if(!in_array($product->id, $cartCompare))
                                <a href="javascript:add_compare({{ $product->id }})" class="btn-product-icon" data-toggle="tooltip" title="Compara questo articolo"><i class="fas fa-exchange-alt"></i></a>
                            @else
                                <a href="javascript:remove_compare({{ $product->id }})" class="btn-product-icon" data-toggle="tooltip" title="Rimuovi da comparazione"><i class="far fa-minus-square"></i></a>
                            @endif
                        </div>
                    @endif

                    <a class="btn-product-icon" href="javascript:modal_view({{ $product->id }})" class="btn-product" data-toggle="tooltip" title="Visualizzazione rapida di {{ $product->name }}"><i class="fa fa-search"></i></a>
                @endif
            </div>
            <div class="product-action">
                <a class="btn-product" href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}" class="btn-product" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif title="{{ $product->name }}">{{ @$labels['dettaglio-prodotto'] }}</a>
            </div>
        </figure>
        <div class="product-details">
            <div class="product-cat text-center">
                <a href="{{ route("pluginProducts.".\App::getLocale(), [$cat_prod_slug]) }}">{{ $cat_prod_name }}</a>
            </div>
            <h6 class="text-center">
                <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}">{{ $product->name }}</a>
            </h6>
            <div class="product-price text-center">
                @if(env('PROJECT_NAME') == "Maison-Flaneur")
                    <?php
                    $symbol = "&euro;";
                    $type_price = "euro";
                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                        if($product->price_dollar){
                            $symbol = "&#36;";
                            $type_price = "dollar";
                        }
                    }
                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                        if($product->price_2){
                            $symbol = "&euro;";
                            $type_price = "euro_2";
                        }
                    }

                    $min = \App\Models\PluginProductsPrices::where("padre_id", $product->id)
                        ->where("figlio_id", "!=", $product->id)
                        ->where("type_price", $type_price)->orderBy("price", "asc")->first();
                    if(!$min){
                        $symbol = "&euro;";
                        $min = \App\Models\PluginProductsPrices::where("padre_id", $product->id)
                            ->where("figlio_id", "!=", $product->id)
                            ->where("type_price", "euro")->orderBy("price", "asc")->first();
                    }
                    $max = \App\Models\PluginProductsPrices::where("padre_id", $product->id)
                        ->where("figlio_id", "!=", $product->id)
                        ->where("type_price", $type_price)->orderBy("price", "desc")->first();
                    if(!$max){
                        $symbol = "&euro;";
                        $max = \App\Models\PluginProductsPrices::where("padre_id", $product->id)
                            ->where("figlio_id", "!=", $product->id)
                            ->where("type_price", "euro")->orderBy("price", "desc")->first();
                    }
                    ?>
                    @if($min && $max)
                        @if($min->price != $max->price)
                            <?php
                            if(env('VIEW_WITH_IVA') == 1){
                                $minPrice = ($min->price + (($min->price * $product->tax->value)/100));
                                $maxPrice = ($max->price + (($max->price * $product->tax->value)/100));
                            }else{
                                $minPrice = $min->price;
                                $maxPrice = $max->price;
                            }
                            ?>

                           {{ @$labels['maison-da'] }} {{ number_format($minPrice, 2,",", "") }} {!! $symbol !!} {{ @$labels['maison-a'] }} {{ number_format($maxPrice, 2,",", "") }} {!! $symbol !!}
                        @else
                            <?php
                             if(env('VIEW_WITH_IVA') == 1){
                               $minPrice = ($min->price + (($min->price * $product->tax->value)/100));
                             }else{
                                 $minPrice = $min->price;
                             }
                            ?>

                            {{ number_format($minPrice, 2,",", "") }} {!! $symbol !!}
                        @endif
                    @endif
                @endif

                @if($shopSetting->view_variants_in_list == 0)

                    @if(env('PROJECT_NAME') != "Maison-Flaneur")
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

                        $p_temp = $product;
                        ?>
                       @include('common.pluginProducts.shop.calculate_price')
                    @endif
                @else
                        @if(env('PROJECT_NAME') != "Maison-Flaneur")
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

                            $p_temp = $product;
                            ?>
                            @include('common.pluginProducts.shop.calculate_price')
                        @endif

                    @if(count($vet_ids) > 0 && $shopSetting->view_variants_in_list == 1)
                        <br>
                        <a href="javascript:modal_view_list_variant({{ $product->id }});">
                            <u>{{ count($vet_ids) }} {{ @$labels['shop-varianti-disponibili'] }}</u>
                        </a>
                        <div id="box_variants_list_{{ $product->id }}"></div>
                    @else
                            @if(count($vet_ids) > 0 && $shopSetting->view_variants_in_list == 2)
                                 @foreach($vet_ids as $attribute_name => $options)
                                     <div class="box_variants_list">
                                         <span class="variant-title">{{ $attribute_name }}</span>
                                         <ul class="list-variants">
                                             @if($options)
                                                 @foreach($options as $option)
                                                     <?php
                                                     $product_temp = \App\Models\PluginProducts::find($option->product_id);
                                                     if($option->type_layout == 0){
                                                         $type_layout = "checkbox-size";
                                                     }else{
                                                         $type_layout = "checkbox-color";
                                                     }?>
                                                     <li @if(is_numeric($option->type_layout)) class="{{ $type_layout }}" @endif><a @if($option->background_color) style="background: {{ $option->background_color }}" @endif href="{{ route("pluginProducts.choose.".\App::getLocale(), [$product_temp->slug, $option->id]) }}">{{ $option->value }}</a></li>
                                                 @endforeach
                                             @endif
                                         </ul>
                                     </div>
                                @endforeach
                            @endif
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
