<div class="product-wrap">
    <div class="product product-list">
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

                @if(env('LOCAL') == 1)
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
                @if($shopSetting->is_modal_rapid)
                     <button class="btn-product-icon" type="button" onclick="modal_view({{ $product->id }})" class="btn btn-primary btn-product" data-bs-toggle="tooltip" title="{{ @$labels['shop-visualizzazione-rapida'] }} {{ $product->name }}"><i class="bi bi-search"></i></button>
                @endif
            </div>
            <div class="product-action product-action-1">
                @if(!$shopSetting->is_add_to_cart_list)
                    @if($adminPlugin->version == 3)
                        <a class="btn-product btn btn-primary btn-block" href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}" class="btn-primary btn-product" title="{{ $product->name }}">{{ @$labels['dettaglio-prodotto'] }}</a>
                    @endif
                @endif
            </div>
        </figure>
        <div class="product-details">
            <div class="product-infos">
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
                <div class="product-short-description">{!! $product->description_short !!}</div>

                <!-- Div Info_extra_list -->
                @if(trim($product->info_extra_list) != "" && $product->info_extra_list != null)
                    <div class="product-element-bottom">{!! $product->info_extra_list !!}</div>
                @else
                    <div class="product-element-bottom-null"></div>
            @endif
            <!-- End Div Info_extra_list -->
            </div>

            <div class="row align-items-end mt-4">
                <div class="col">
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

                            $p_temp = $product;

                            ?>

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
                                            <button type="button" class="btn btn-primary btn-sm w-100 my-1" data-bs-toggle="modal" data-bs-target="#modal-varianti-{{ $product->id }}">Guarda <strong>{{ count($options) }} varianti</strong></button>
                                            <div class="modal fade" id="modal-varianti-{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header pb-0">
                                                            <h5 class="modal-title">{{ $attribute_name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                @if($options)
                                                                    @foreach($options as $option)
                                                                        <?php

                                                                        //background_color
                                                                        if($option['type_layout'] == 0){
                                                                            $type_layout = "checkbox-size";
                                                                        }else{
                                                                            $type_layout = "checkbox-color";
                                                                        }

                                                                        $IconImage = null;
                                                                        if(key_exists($option['option_id'], $optionsList)){
                                                                            $IconImage = $optionsList[$option['option_id']];
                                                                        }
                                                                        ?>
                                                                        <div class="col-12">
                                                                            <a class="card card-variant text-decoration-none mb-3" title="{{ $option['value'][\App::getLocale()] }}" href="{{ $option['url_product'] }}">
                                                                                <div class="row gx-0">
                                                                                    @if($IconImage)
                                                                                        <div class="col-auto">
                                                                                            <div class="px-3 py-2">
                                                                                                <img width="50" height="50" class="img-fluid" src="{{ url($IconImage) }}" alt="{{ $option['value'][\App::getLocale()] }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    <div class="col border-left bg-light d-flex flex-column px-3 py-2">
                                                                                        <div class="fw-bold text-uppercase">{{ $option['value'][\App::getLocale()] }}</div>
                                                                                        <div class="small text-dark">Contattaci</div>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        @endif
                    </div>
                </div>

                @if($shopSetting->is_add_to_cart_list && $product->is_purchasable)
                    <div class="col-auto">
                        <form method="post" action="{{ route('add.cart.product') }}" id="add-cart-from-list-{{ $product->id }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="modal" value="1">
                            <div class="product-form-group">
                                <a class="btn btn-lg btn-primary" onclick="add_list_cart({{ $product->id }})">
                                    @if(!$product->in_cart())
                                        <i id="add-cart-button-list-{{ $product->id }}" class="bi bi-bag-fill"></i>
                                    @else
                                        <i class="bi bi-cart-check-fill" id="add-cart-button-list-{{ $product->id }}"></i>
                                    @endif
                                </a>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            @if(!$shopSetting->is_add_to_cart_list)
                @if($adminPlugin->version == 3)
                    <div class="product-action product-action-2">
                        <a href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]) }}" class="btn btn-product btn-primary" title="{{ $product->name }}">{{ @$labels['dettaglio-prodotto'] }}</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
