<div class="product-wrap">
    <div class="product product-grid">
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
                $style = "";

                ?>
                @if(env('local') == 1)
                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $product->name }}" width="360" height="420" style="{{ $style }}">
                @else
                    <img loading="lazy" class="img-fluid mx-auto" src="{{ $product->getCover() }}" alt="{{ $product->name }}" width="360" height="420" style="{{ $style }}">
                    @if($product->getSecondPhoto())
                        <img loading="lazy" class="img-fluid mx-auto" src="{{ $product->getSecondPhoto() }}" alt="{{ $product->name }}" width="360" height="420" style="{{ $style }}">
                    @endif
                @endif
            </a>
            <div class="product-label-group">
                @if($product->is_evidenza == 1 && trim(@$labels['shop-in-evidenza']) != "") <label class="product-label label-new">{{ @$labels['shop-in-evidenza'] }}</label> @endif
                @if(trim($product->custom_1) != "")<label class="product-label product-label-custom-color-1">{{ $product->custom_1 }}</label> @endif
                @if(trim($product->custom_2) != "")<label class="product-label product-label-custom-color-2">{{ $product->custom_2 }}</label> @endif
            </div>
            <div class="product-action-vertical">
                @if(env('SLUG_COMPARE') && $adminPlugin->version == 3 && $pluginSetting->is_comparations)
                    <?php
                    $indexClass = new \App\Http\Controllers\PluginProductsController();
                    $cartCompare = $indexClass->loading_compare();
                    ?>
                    <div id="compare_{{ $product->id }}">
                        @if(!in_array($product->id, $cartCompare))
                            <button type="button" onclick="add_compare({{ $product->id }})" class="btn-product-icon" data-bs-toggle="tooltip" title="{{ @$labels['shop-compara-questo-articolo'] }}"><i class="fas fa-exchange-alt"></i></button>
                        @else
                            <button type="button" onclick="remove_compare({{ $product->id }})" class="btn-product-icon" data-bs-toggle="tooltip" title="{{ @$labels['shop-rimuovi-da-comparazione'] }}"><i class="far fa-minus-square"></i></button>
                        @endif
                    </div>
                @endif
                <button class="btn-product-icon" type="button" onclick="modal_view({{ $product->id }})" class="btn btn-primary btn-product" data-bs-toggle="tooltip" title="{{ @$labels['shop-visualizzazione-rapida'] }} {{ $product->name }}"><i class="bi bi-search"></i></button>
            </div>
            <div class="product-action product-action-1">
                @if($adminPlugin->version == 3)
                    <a class="btn-product btn btn-primary" href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}" class="btn-primary btn-product" title="{{ $product->name }}">{{ @$labels['dettaglio-prodotto'] }}</a>
                @endif
            </div>
        </figure>
        <div class="product-details">
            <div class="product-cat">
                <a href="{{ route("pluginProducts.".\App::getLocale(), [$cat_prod_slug]) }}">{{ $cat_prod_name }}</a>
            </div>
            <h4 class="product-title">
               <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}">{{ $product->name }}
                   <!-- aggiungo sku in lista prodotti -->
                   @if($pluginSetting->show_sku == 1 || ($product->show_sku == 1))
                       <br><span style="font-size: 14px;">{{ @$labels['sku'] }} {{ $product->sku }}</span>
                   @endif
               </a>
            </h4>
            <!-- qui vorreo aggiungere le proprietà -->

            <!-- Div Info_extra_list -->
            @if(trim($product->info_extra_list) != "" && $product->info_extra_list != null)
                <div class="product-element-bottom">{!! $product->info_extra_list !!}</div>
            @else
                <div class="product-element-bottom-null"></div>
            @endif
            <!-- End Div Info_extra_list -->

            <div class="product-price">
                @if($shopSetting->view_variants_in_list == 0)
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

                    @if($pluginSetting->show_prices == 1 || ($pluginSetting->is_price_on_demand == 1 && $pluginSetting->show_prices == 0 && \Session::get("user_id")))
                        @include("Webshop.plugins.pluginProducts.v3.shop.calculate_price")
                    @endif
                @else
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

                        $p_temp = $product; ?>

                        @if($pluginSetting->show_prices == 1 || ($pluginSetting->is_price_on_demand == 1 && $pluginSetting->show_prices == 0 && \Session::get("user_id")))
                            @include("Webshop.plugins.pluginProducts.v3.shop.calculate_price")
                        @endif

                    @if(count($vet_ids) > 0 && $shopSetting->view_variants_in_list == 1)
                        <button type="button" onclick="modal_view_list_variant({{ $product->id }})"><u>{{ count($vet_ids) }} {{ @$labels['shop-varianti-disponibili'] }}</u></button>
                        <div id="box_variants_list_{{ $product->id }}"></div>
                    @else
                        @if(count($vet_ids) > 0 && $shopSetting->view_variants_in_list == 2)
                            @foreach($vet_ids as $attribute_name => $options)

                                <div class="box_variants_list">
                                    <span class="variant-title">{{ $attribute_name }}</span>
                                    <ul class="list-variants">

                                        @if($options)
                                            <?php
                                              if(is_string($options)){
                                                  $options = explode(",", $options);
                                              }
                                            ?>

                                            @foreach($options as $option)
                                                <?php
                                                if(!is_object($option)){
                                                    continue;
                                                }

                                                $product_temp = \App\Models\PluginProducts::find($option->product_id);
                                                if(!$product_temp){
                                                    continue;
                                                }

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

            <!--
            <div class="product-action product-action-2">
                <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}" class="btn btn-product btn-primary" title="{{ $product->name }}">{{ @$labels['dettaglio-prodotto'] }}</a>
            </div> -->
        </div>
    </div>
</div>
