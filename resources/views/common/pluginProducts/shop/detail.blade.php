<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
@if($itemProduct)
    <?php
    $padre = null;
    $shopSetting = \App\Models\ShopSettings::first();
    $cat_prod_name = "";
    $cat_prod_slug = "no-categoria";
    $cat_prod = $itemProduct->category();
    if($cat_prod){
        $cat_prod_name = $cat_prod->name;
        $cat_prod_slug = $cat_prod->slug;
    }

    $categories_products = \App\Models\PluginProductsCategories::join("plugins_products_categories_products", "plugins_products_categories.id", "=", "plugins_products_categories_products.plugin_product_category_id")
        ->where("plugin_product_product_id", $itemProduct->id)
        ->where("plugins_products_categories.is_active", 1)
        ->get();

    $images = [];
    if($itemProduct->is_variant == 1 && $shopSetting->type_view_variant == 3){
        $padre = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)->where("is_variant", 0)->first();
        if(!$padre){
            $lang = \App::getLocale();
            return redirect()->route("pluginProducts.404.$lang");
        }
        if($itemProduct->include_photo_padre == 1){
            if($padre){
                $padre->images = \App\Models\PluginProductsImages::where("product_id", $padre->id)->orderBy("order", "asc")->get();
            }

            if(count($padre->images)){
                foreach($padre->images as $image){
                    $images[] = $image->image;
                }
            }
        }

        /* Se non si vuole vedere le foto delle varianti commento da riga 36 a riga 40 */
        if(count($itemProduct->images)){
            foreach($itemProduct->images as $image){
                $images[] = $image->image;
            }
        }
    }else{
        if(count($itemProduct->images)){
            foreach($itemProduct->images as $image){
                $images[] = $image->image;
            }
        }
    }
    ?>


    <main class="main mt-6 single-product">
    <div class="page-content mb-10 pb-6">
        <div class="container">
            <div class="product product-single row mb-7">
                @include("common.pluginProducts.shop.type_detail_photo_{$shopSetting->type_detail_photo}")

                <div class="col-md-6">
                    <div class="product-details">
                        @include('common.pluginProducts.shop.view_brand')

                        @if(session()->has('message'))
                            <div class="alert alert-success text-center">
                                <p>{{ @$labels['shop-alert-aggiunto-al-carrello'] }}</p>
                            </div>
                        @endif

                        @if(session()->has('error'))
                            <div class="alert alert-warning text-center">
                                <p>{{ @$labels['shop-alert-aggiunto-al-carrello-error'] }}</p>
                            </div>
                        @endif

                        <h1 class="product-name">
                            @if($shopSetting->type_view_variant == 3 && $padre)
                                {{ $padre->name }}
                            @else
                                {{ $itemProduct->name }}
                            @endif
                        </h1>
                        <div class="product-meta">

                            <!-- Blocco Prezzo + Promo CountDown -->

                            @if($shopSetting->type_view_variant != 3)
                                <div class="product-price">
                                    <?php
                                    $symbol = "&euro;";
                                    $start_price = $itemProduct->price;
                                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                                        if($itemProduct->price_dollar){
                                            $symbol = "&#36;";
                                            $start_price = $itemProduct->price_dollar;
                                        }
                                    }

                                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                                        if($itemProduct->price_2){
                                            $symbol = "&euro;";
                                            $start_price = $itemProduct->price_2;
                                        }
                                    }
                                    $promo_price = $itemProduct->get_promo_price();

                                    $vat = $itemProduct->tax ? $itemProduct->tax->value : 22;
                                    $vat_calculate = ($vat / 100) + 1;

                                    $p_temp = $itemProduct;
                                    ?>

                                    @include('common.pluginProducts.shop.calculate_price')

                                    @if($symbol == "&euro;")
                                        <?php
                                            $price_srp = $itemProduct->price_srp;
                                            if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                                                $price_srp = $itemProduct->price_2_srp;
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
                                        @if($itemProduct->price_srp_dollar != 0)
                                            <ins class="new-price">{{ @$labels['shop-srp'] }} {!! $symbol !!}
                                                @if(env('VIEW_WITH_IVA') == 1)
                                                    {{ number_format($itemProduct->price_srp_dollar * 1.22, 2, ",", ".") }}
                                                @else
                                                    {{ number_format($itemProduct->price_srp_dollar, 2, ",", ".") }}
                                                @endif
                                            </ins>
                                        @endif
                                    @endif
                                </div>

                                @include('common.pluginProducts.promo')

                            <!-- END Blocco Prezzo + Promo CountDown -->

                            <!-- Blocco descrizione breve -->

                                <p class="product-short-desc">
                                    <!-- eccezione progetto -->
                                    @if(env("PROJECT_NAME") != "Maison-Flaneur")
                                        {!! $itemProduct->description_short !!}
                                    <!-- / eccezione progetto -->
                                    @else
                                        <?php $itemProduct->description_short = str_replace("|", "<br>", $itemProduct->description_short); ?>
                                        {!! $itemProduct->description_short !!}
                                    @endif
                                </p>

                            <!-- END Blocco descrizione breve -->

                            @endif

                            <!-- Blocco SKU/Categoria/Q.ty/Tags -->

                            @if(env("PROJECT_NAME") != "Maison-Flaneur")

                                <div class="product-sku text-black"><b>{{ @$labels['sku'] }}:</b> {{ $itemProduct->sku }}</div>
                                <div class="product-cats text-black mb-3"><b>{{ @$labels['categoria'] }}:</b>
                                    @if($categories_products)
                                        @foreach($categories_products as $category_product)
                                           <a href="{{ route("pluginProducts.".\App::getLocale(), [$category_product->slug]) }}">{{ $category_product->name }}</a>
                                        @endforeach
                                    @endif
                                </div>
                            @endif

                            @if($plugin->show_quantities == 1 && $itemProduct->qty != null)
                                @if($itemProduct->qty > 0)
                                    @if($plugin->label_qty_success && trim($plugin->label_qty_success) != "")
                                          <div class="product-brand text-black">{{ @$labels['qty'] }}: {{ $plugin->label_qty_success }}</div>
                                    @else
                                          <div class="product-brand text-black"><b>{{ @$labels['qty'] }}:</b> {{ $itemProduct->qty }}</div>
                                    @endif
                                @else
                                    @if($plugin->label_qty_error && trim($plugin->label_qty_error) != "")
                                        <div>{{ $plugin->label_qty_error }}</div>
                                    @else
                                        <div class="product-brand text-black">{{ @$labels['qty'] }}: {{ $itemProduct->qty }} </div>
                                    @endif
                                @endif
                            @endif

                            @if($itemProduct->tags != "")
                                <?php $tags = explode(",", $itemProduct->tags); ?>
                                @if(count($tags) > 0)
                                    <div class="product-tags text-black"><b>{{ @$labels['tags'] }}:</b>
                                    <?php $x = 1; ?>
                                    @foreach($tags as $itemTag)
                                       <a href="{{ route("pluginProductsTags.".\App::getLocale(), $itemTag) }}">{{ $itemTag }}</a>@if($x < count($tags)),@endif
                                       <?php $x++; ?>
                                   @endforeach
                                   </div>
                                @endif
                            @endif
                        </div>

                        <!-- END Blocco SKU/Categoria/Q.ty/Tags -->
                        @if($shopSetting->type_view_variant == 1)
                            @include('common.pluginProducts.shop.select_variants')
                        @endif

                        @if($shopSetting->type_view_variant == 2 && $itemProduct->is_variant == 0)
                            @include('common.pluginProducts.shop.table_variants')
                        @endif

                        @if($shopSetting->type_view_variant == 3)
                            @include('common.pluginProducts.shop.html_variants')
                        @endif

                        @if($shopSetting->type_view_variant == 4)
                            @include('common.pluginProducts.shop.radio_variants')
                        @endif

                        @if($itemProduct->is_purchasable == 1 && in_array($shopSetting->type_view_variant, [1,4]) && $promo_price > 0)
                            @if($itemProduct->qty == 0)
                                <div class="alert alert-warning alert-simple alert-inline">
                                    <h4 class="alert-title">{{ @$labels['shop-attenzione'] }}</h4>
                                    {{ @$labels['shop-prodotto-non-disponibile'] }}
                                </div>
                            @else
                                @if((env("PROJECT_NAME") == "Manega") && strpos( \URL::current(),"luxury"))
                                    @if($plugin->show_form_contact == 1)
                                        <p class="mb-30"><a class="btn btn-shoppy btn-block btn-lg px-1 px-md-2" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};" href="#form_contact"><i class="fa fa-eur"></i> <span style="color: {{ $website->btn_txt_color }}"> {{ @$labels['richiedi-preventivo'] }}</a> </span></p>
                                    @endif
                                @else
                                    @if(!$itemProduct->in_cart())
                                        <?php
                                        $max = $itemProduct->qty;
                                        if($itemProduct->qty_max){
                                            $max = $itemProduct->qty_max;
                                        }
                                        ?>

                                        <!-- Blocco aggiungi al carrello Plugin Prodotti V3-->
                                        <form method="post" action="{{ route('add.cart.product') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $itemProduct->id }}">

                                            @include('common.pluginProducts.shop.box_extra')

                                            <hr class="product-divider">
                                            <div class="product-form product-qty">
                                                <div class="product-form-group">
                                                    <div class="input-group-cart mr-2">
                                                        <button class="quantity-minus fas fa-minus" type="button"></button>
                                                           <input class="quantity form-control" type="number" name="qty" min="1" max="{{ $max }}">
                                                        <button class="quantity-plus fas fa-plus" type="button"></button>
                                                    </div>
                                                    <button class="btn-shoppy btn-product text-normal ls-normal font-weight-semi-bold" type="submit" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};"><i class="fas fa-shopping-cart" style="color: {{ $website->btn_txt_color }}"></i> <span class="pl-2" style="color: {{ $website->btn_txt_color }}">{{ @$labels['shop-add-to-cart'] }}</span></button>
                                                </div>
                                            </div>

                                            <hr class="product-divider mb-3">

                                        </form>
                                    @else
                                        <div class="form-group">
                                            <div class="alert alert-warning alert-dark alert-round alert-inline">
                                                <h4 class="alert-title">{{ @$labels['shop-nel-carrello'] }}</h4>
                                                {{ @$labels['shop-prodotto-gia-nel-carrello'] }}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <a class="btn btn-block btn-md" href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i> {{ @$labels['shop-edit-cart'] }}</a>
                                            <a class="btn btn-success btn-block btn-md" href="{{route('checkout')}}"><i class="fas fa-cash-register"></i> {{ @$labels['shop-completa-acquisto'] }}</a>
                                        </div>

                                    @endif
                                @endif

                            @endif

                        <!-- Caso Richiedi preventivo - CATALOGO VERS. 2 NO VENDITA -->
                        @else
                            @if($plugin->show_form_contact == 1)
                            <p class="mb-30"><a class="btn btn-shoppy btn-block btn-lg px-1 px-md-2" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};" href="#form_contact"><i class="fa fa-eur"></i> <span style="color: {{ $website->btn_txt_color }}"> {{ @$labels['richiedi-preventivo'] }}</a> </span></p>
                            @endif
                        @endif

                        @if(count($itemProduct->options))
                            @if(count($itemProduct->options))
                                <figure class="size-table mt-4 mb-4">
                                    <table class="table table-bordered">
                                        <tbody>
                                        @foreach($itemProduct->options as $option)
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
                        @endif

                        <!-- pulsante qty + add to cart + icone -- VERS. MARZO 2022-->

                        <div class="product-footer">
                            @include('common.pluginProducts.shop.size_guide')

                            <div class="product-action">
                                @if(\Session::has("user_id"))

                                    @if($itemProduct->in_wishlist(\Session::get('user_id')))
                                        <a href="#" onclick="remove_wishlist({{ $itemProduct->id }})" class="mr-6"><i class="fas fa-heart"></i> {{ @$labels['shop-rimuovi-preferiti'] }}</a>
                                    @else
                                        <a href="#" onclick="add_wishlist({{ $itemProduct->id }})" class="mr-6"><i class="far fa-heart"></i> {{ @$labels['shop-aggiungi-preferiti'] }}</a>
                                    @endif
                                    @else
                                        <a href="{{ route('login') }}" class="mr-6"><i class="far fa-heart"></i> {{ @$labels['shop-accedi-e-aggiungi-preferiti'] }}</a>
                                    @endif


                                    @if(env('SLUG_COMPARE'))
                                    <?php
                                    $indexClass = new \App\Http\Controllers\PluginProductsController();
                                    $cartCompare = $indexClass->loading_compare();
                                    ?>
                                    <span id="compare_{{ $itemProduct->id }}">
                                        @if(!in_array($itemProduct->id, $cartCompare))
                                            <a href="{{ route('advice.compare', $itemProduct->id) }}" class="btn-product btn-compare mr-6"><i class="fas fa-balance-scale"></i>Compara</a>
                                        @else
                                            <a href="{{ route('advice.compare.remove', $itemProduct->id) }}" class="btn-product btn-compare mr-6"><i class="fas fa-balance-scale-left"></i>Rimuovi da comparazione</a>
                                        @endif
                                    </span>
                            </div>
                            <a class="btn-product btn-compare" href="{{ route('comparatore') }}"><i class="fas fa-exchange-alt"></i>Vai alla Comparazione</a>

                            @endif

                            @if($plugin->is_print_pdf == 1)
                                 <a href="{{ route("pluginProducts.pdf.".\App::getLocale(), $itemProduct->id) }}" class="btn btn-block btn-link"><i class="fas fa-file-pdf"></i>{{ @$labels['scarica-pdf'] }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab tab-nav-simple product-tabs">
                <hr>
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    @if(trim($itemProduct->description) != "")
                    <li class="nav-item">
                        <a class="nav-link active" href="#product-tab-description">{{ @$labels['description-long'] }}</a>
                    </li>
                    @endif
                    @if(count($itemProduct->options))
                    <!--<li class="nav-item">
                        <a class="nav-link" href="#proprieta">{{ @$labels['proprieta-prodotto'] }}</a>
                    </li>-->
                    @endif
                    @if(count($itemProduct->attachmentsList))
                    <li class="nav-item">
                        <a class="nav-link" href="#allegati">{{ @$labels['allegati-prodotto'] }}</a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active in" id="product-tab-description">
                        <div class="row">
                            <div class="col">
                                @if(env("PROJECT_NAME") != "Maison-Flaneur")
                                    {!! $itemProduct->description !!}
                                @else
                                    <?php $itemProduct->description = str_replace("|", "<br>", $itemProduct->description); ?>
                                    {!! $itemProduct->description !!}
                                @endif

                                @include("$thema.plugins.pluginProducts.inc.video")
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="proprieta">

                    </div>
                    <div class="tab-pane" id="allegati">
                        @include("$thema.plugins.pluginProducts.inc.attachments")
                    </div>
                </div>
            </div>

            @if($plugin->show_form_contact == 1)
                @if($itemProduct->is_purchasable == 0 || ((env("PROJECT_NAME") == "Manega") && strpos( \URL::current(),"luxury")))
                    @include("$thema.plugins.pluginProducts.inc.formContact")
                @endif
            @endif

            @include("common.pluginProducts.shop.products_related")
        </div>
    </div>
</main>

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
        PhotoSwipe keeps only 3 of them in the DOM to save memory.
        Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" aria-label="Close (Esc)"></button>
                <button class="pswp__button pswp__button--zoom" aria-label="Zoom in/out"></button>

                <div class="pswp__preloader">
                    <div class="loading-spin"></div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button--arrow--left" aria-label="Previous (arrow left)"></button>
            <button class="pswp__button--arrow--right" aria-label="Next (arrow right)"></button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
@endif
