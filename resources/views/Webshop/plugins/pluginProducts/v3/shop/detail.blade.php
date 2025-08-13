<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$pluginSetting = \App\Models\PluginProductsSettings::first();
$shopSetting = \App\Models\ShopSettings::first();
?>
@if($itemProduct)
    <?php
    $padre = null;
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

    if($itemProduct->is_variant == 1 && in_array($shopSetting->type_view_variant, [3,4])){
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

    $lang = \App::getLocale();

    $product_lang = \App\Models\PluginProductsLangs::where("product_id", $itemProduct->id)->where("lang", $lang)->whereNotNull("image")->first();
    if($product_lang){
        if(count($images) > 0){
            $images[0] = $product_lang->image;
        }else{
            $images = [];
            $images[0] = $product_lang->image;
        }
    }

    ?>
<!-- Webisland aggiunge le briciole di pane -->
@if($shopSetting->bread_crumbs == "1")
    <section style="height: {{ $shopSetting->height_section_bc }}px; background-color: {{ $shopSetting->bgcolor_bc }}; padding: {{ $shopSetting->padding_section_bc }}rem;">
        <span style="color: {{ $shopSetting->text_color_bc }}; margin-left: 2.2rem; font-size: {{ $shopSetting->text_size_bc }}px;">
            <a href="javascript:history.back()"><i class="fa-solid fa-arrow-right-long fa-rotate-180 fa-2xl" style="color: {{ $shopSetting->text_color_bc }}; font-size: 16px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <!--i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-xs"></i-->
            <a href="/"><i class="fa-solid fa-house fa-xs" style="color: {{ $shopSetting->text_color_bc }};"></i> Home</a> /
            @if($categories_products)
                @foreach($categories_products as $category_product)
                    <a href="{{ route("pluginProducts.".\App::getLocale(), [$category_product->slug]) }}">{{ $category_product->name }}</a>
                @endforeach
            @endif
            / {{ $itemProduct->sku }}
        </span>
        <!--<i class="fa-solid fa-arrow-left"></i> <i class="fa-solid fa-left-long"></i>-->
    </section>
@endif
<!-- END briciole di pane -->
<section class="single-product">
    <div class="page-content">
        <div class="container-fluid container-2xl">
            <div class="row">
                @include("$thema.plugins.pluginProducts.v3.shop.type_detail_photo_{$shopSetting->type_detail_photo}")
                <div class="col-md">
                    <div class="product-details">
                        @include("$thema.plugins.pluginProducts.v3.shop.view_brand")

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

                        <?php $promo_price = 0; ?>
                        @if($shopSetting->type_view_variant != 3 && $adminPlugin->version == 3)
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

                                @if($pluginSetting->show_prices == 1 || ($pluginSetting->is_price_on_demand == 1 && $pluginSetting->show_prices == 0 && \Session::get("user_id")))
                                    @include("$thema.plugins.pluginProducts.v3.shop.calculate_price")

                                    @if($symbol == "&euro;")
                                        <?php $price_srp = $itemProduct->price_srp;
                                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                                            $price_srp = $itemProduct->price_2_srp;
                                        } ?>

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
                                 @endif
                            </div>

                            @if($pluginSetting->show_prices == 1 || ($pluginSetting->is_price_on_demand == 1 && $pluginSetting->show_prices == 0 && \Session::get("user_id")))
                                 @include("$thema.plugins.pluginProducts.v3.promo")
                            @endif

                            <!--<p class="product-short-description">
                                <?php $itemProduct->description_short = str_replace("|", "<br>", $itemProduct->description_short); ?>
                                {!! $itemProduct->description_short !!}
                            </p>-->
                        @endif

                        <div class="product-meta">
                            <div class="product-sku"><b>{{ @$labels['sku'] }}:</b> {{ $itemProduct->sku }} </div>

                            @if($itemProduct->ean13)
                                <div class="product-stock"><b>Ean:</b> {{ $itemProduct->ean13 }}</div>
                            @endif

                            <div class="product-cats"><b>{{ @$labels['categoria'] }}:</b>
                                @if($categories_products)
                                    @foreach($categories_products as $category_product)
                                        <a href="{{ route("pluginProducts.".\App::getLocale(), [$category_product->slug]) }}">{{ $category_product->name }}</a>
                                    @endforeach
                                @endif
                            </div>

                        <!-- Campo prezzo semplice solo per versione 1 ad uso immobili o similari -->
                            @if($adminPlugin->version == 1)
                                @if($itemProduct->prezzo_semplice !== null)
                                   <b>{{ @$labels['prezzo-semplice'] }}:</b>  € {!! $itemProduct->prezzo_semplice !!}
                                @endif
                            @endif
                        <!-- end Campo prezzo semplice -->

                            <p class="product-short-description">
                                    <?php $itemProduct->description_short = str_replace("|", "<br>", $itemProduct->description_short); ?>
                                {!! $itemProduct->description_short !!}
                            </p>

                            @if($plugin->show_quantities == 1 && $itemProduct->qty != null && $adminPlugin->version == 3)
                                @if($itemProduct->qty > 0)
                                    @if($plugin->label_qty_success && trim($plugin->label_qty_success) != "")
                                          <div class="product-stock"><b>{{ @$labels['qty'] }}:</b> {{ $plugin->label_qty_success }}</div>
                                    @else
                                          <div class="product-stock"><b>{{ @$labels['qty'] }}:</b> {{ $itemProduct->qty }}</div>
                                    @endif
                                @else
                                    @if($plugin->label_qty_error && trim($plugin->label_qty_error) != "")
                                        <div>{{ $plugin->label_qty_error }}</div>
                                    @else
                                        <div class="product-stock">{{ @$labels['qty'] }}: {{ $itemProduct->qty }} </div>
                                    @endif
                                @endif
                            @endif


                            @if($itemProduct->tags != "")
                                <?php
                                    $tags = [];
                                    $temp_prod = \DB::table("plugins_products")->where("id", $itemProduct->id)->first();
                                    if($temp_prod->tags){
                                        $tags = json_decode($temp_prod->tags, true);
                                        $lang = \App::getLocale();

                                        $tags = explode(",",$tags[$lang]);
                                        if($tags){
                                            foreach ($tags as $k=>$tag){
                                                if(trim($tag) == ""){
                                                    unset($tags[$k]);
                                                    continue;
                                                }

                                                $tags[$k] = trim($tag);
                                            }
                                        }
                                    }
                                ?>
                                @if(count($tags) > 0)
                                    <div class="product-tags"><b>{{ @$labels['tags'] }}:</b>
                                    <?php $x = 1; ?>
                                    @foreach($tags as $itemTag)
                                       <a class="single-tag" href="{{ route("pluginProductsTags.".\App::getLocale(), $itemTag) }}">{{ $itemTag }}</a>
                                       <?php $x++; ?>
                                   @endforeach
                                   </div>
                                @endif
                            @endif
                        </div>

                        @if($shopSetting->type_view_variant == 1 && $adminPlugin->version == 3)
                            @include("$thema.plugins.pluginProducts.v3.shop.select_variants")
                        @endif

                        @if($shopSetting->type_view_variant == 2 && $itemProduct->is_variant == 0 && $adminPlugin->version == 3)
                            @include("$thema.plugins.pluginProducts.v3.shop.table_variants")
                        @endif

                        @if($shopSetting->type_view_variant == 3 && $adminPlugin->version == 3)
                            @include("$thema.plugins.pluginProducts.v3.shop.html_variants")
                        @endif

                        @if($shopSetting->type_view_variant == 4 && $adminPlugin->version == 3)
                            @include("$thema.plugins.pluginProducts.v3.shop.radio_variants")
                        @endif

                        @if($shopSetting->type_view_variant == 5 && $adminPlugin->version == 3)
                            @include("$thema.plugins.pluginProducts.v3.shop.links_variants")
                        @endif


                        @if($pluginSetting->show_prices == 0)
                            @if($pluginSetting->is_price_on_demand == 1)
                                @if(!\Session::has("user_id"))
                                    <p><a href="{{ route('register') }}?plugin_product_id={{ $itemProduct->id }}" class="btn btn-danger btn-lg text text-white"><i class="fas fa-euro-sign"></i> {{ @$labels['richiedi-prezzo'] }}</a></p>
                                @endif
                            @endif
                        @endif

                        @if($itemProduct->is_button_for_request && $itemProduct->form_page_id)
                            <?php
                            $page = \App\Models\Page::find($itemProduct->form_page_id);
                            ?>
                            @if($page)
                                <p><a class="text text-danger-emphasis" href="/{{ $page->slug }}?product_id={{ $itemProduct->id }}"><i class="fas fa-info"></i> {!! @$labels['richiedi-personalizzazione'] !!} {{ @$labels['richiedi-preventivo'] }}</a></p>
                            @endif
                        @endif

                        <?php
                        $has_figli = 0;
                        if($itemProduct->is_variant == 0){
                            $has_figli = \App\Models\PluginProducts::where("is_variant", 1)->where("group_id", $itemProduct->group_id)
                                ->where("is_active", 1)
                                ->count();
                        }
                        ?>

                        @if($itemProduct->is_purchasable == 1 && in_array($shopSetting->type_view_variant, [1,4]) && $promo_price > 0 && $has_figli == 0)
                            @if($itemProduct->qty == 0)
                                <div class="alert alert-warning">
                                    <strong>{{ @$labels['shop-attenzione'] }}:</strong> {{ @$labels['shop-prodotto-non-disponibile'] }}
                                </div>
                            @else
                                @if((env("PROJECT_NAME") == "Manega") && strpos( \URL::current(),"luxury"))
                                    @if($plugin->show_form_contact == 1)
                                        <p><a class="btn btn-primary btn-lg" href="#block-product-contact"><i class="fas fa-euro-sign"></i> {{ @$labels['richiedi-preventivo'] }}</a></p>
                                    @endif
                                @else
                                    @if(!$itemProduct->in_cart())
                                        <?php
                                        $max = $itemProduct->qty;
                                        if($itemProduct->qty_max){
                                            $max = $itemProduct->qty_max;
                                        }

                                        ?>

                                        @if($pluginSetting->is_add_to_cart == 1 || ($pluginSetting->is_price_on_demand == 1 && $pluginSetting->is_add_to_cart == 0 && \Session::get("user_id")) )

                                            <?php
                                                 $products_quantities = \App\Models\PluginProductsQuantities::where("plugin_product_id", $itemProduct->id)
                                                     ->get();
                                            ?>
                                            @if($products_quantities)
                                                <table class="table">
                                                    <tr><th>Quantità minima</th><th>Prezzo</th></tr>
                                                    @foreach($products_quantities as $pq)
                                                        <tr>
                                                            <td>{{ $pq->quantity_min }}</td>
                                                            <td>{{ number_format($pq->price * $vat_calculate,2,",",".") }} &euro;</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @endif


                                            <form method="post" action="{{ route('add.cart.product') }}" class="product-form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $itemProduct->id }}">

                                                @include("$thema.plugins.pluginProducts.v3.shop.box_extra")

                                                <div class="product-form-group row">
                                                    <div class="input-group input-spinner w-auto col-auto">
                                                        <button class="quantity-minus btn btn-default button-minus" type="button" onclick="decreaseValue('#qty')" aria-label="Riduci"><i class="fas fa-minus"></i></button>
                                                        <input class="quantity form-control form-control-qty" type="number" name="qty" min="1" @if($pluginSetting->is_qty_infinite == 0) max="{{ $max }}" @endif id="qty" value="1" aria-label="Quantità" style="max-width: 40px!important">
                                                        <button class="quantity-plus btn btn-default button-plus" type="button" onclick="increaseValue('#qty')" aria-label="Aumenta"><i class="fas fa-plus"></i></button>
                                                    </div>
                                                    <button class="btn btn-primary col-auto" type="submit">
                                                        <i class="bi bi-bag-fill"></i><span class="ps-2">{{ @$labels['shop-add-to-cart'] }}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    @else
                                        <div class="alert alert-warning">
                                            <strong>{{ @$labels['shop-nel-carrello'] }}</strong> {{ @$labels['shop-prodotto-gia-nel-carrello'] }}
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-sm my-1"><a class="btn btn-lg btn-secondary w-100" href="{{ route('cart') }}"><i class="bi bi-bag-fill"></i> {{ @$labels['shop-edit-cart'] }}</a></div>
                                            <div class="col-sm my-1"><a class="btn btn-lg btn-success text-white w-100" href="{{route('checkout')}}"><i class="bi bi-check-circle"></i> {{ @$labels['shop-completa-acquisto'] }}</a></div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endif

                        @if(count($itemProduct->options))
                            @if(count($itemProduct->options))
                                <table class="table table-sm table-bordered size-table my-3">
                                    <tbody>
                                    <p style="font-size: 20px;"><strong>{{ @$labels['titolo-options'] }}</strong></p>
                                    @foreach($itemProduct->options as $option)
                                        <?php $name = json_decode($option->name, true);
                                        if(!key_exists(\App::getLocale(), $name)){
                                            continue;
                                        } ?>
                                        <tr>
                                            <th>{{ $name[\App::getLocale()] }}</th>
                                            <td>{{ $option->value }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endif

                        <div class="product-footer">
                            @include("Webshop.plugins.pluginProducts.v3.shop.size_guide")

                            @if($adminPlugin->version < 3)
                                @if($plugin->is_print_pdf == 1)
                                    <p><a class="btn btn-primary" href="{{ route("pluginProducts.pdf.".\App::getLocale(), $itemProduct->id) }}" target="_blank"><i class="fas fa-file-pdf"></i> {{ @$labels['scarica-pdf'] }}</a> </p>
                                @else
                                    @if(count($itemProduct->attachmentsList))
                                        <?php
                                        if($shopSetting->box_attachments == 0){
                                            $ancora = "#altre-info";
                                        }else{
                                            $ancora = "#allegati-lista";
                                        }
                                        ?>
                                        <p><a class="btn btn-primary" href="{{ $ancora }}">{{ @$labels['allegati-prodotto'] }}</a> </p>
                                    @endif
                                @endif

                                @if($plugin->show_form_contact == 1)
                                    &nbsp;&nbsp; <p><a class="btn btn-primary" href="#block-product-contact"><!--i class="fas fa-euro-sign"></i--> {{ @$labels['richiedi-preventivo'] }} </a></p>
                                @endif
                            @else
                                @if($plugin->show_form_contact == 1)
                                    &nbsp;&nbsp; <p><a class="btn btn-primary" href="#block-product-contact"><!--i class="fas fa-euro-sign"></i--> {{ @$labels['richiedi-preventivo'] }} </a></p>
                                @endif

                                @if($shopSetting->is_add_to_wishlist)
                                    @if(\Session::has("user_id"))
                                        @if($itemProduct->in_wishlist(\Session::get('user_id')))
                                            <a href="#" onclick="remove_wishlist({{ $itemProduct->id }})" class="btn btn-primary"><i class="fas fa-heart me-1"></i> {{ @$labels['shop-rimuovi-preferiti'] }}</a>
                                        @else
                                            <a href="#" onclick="add_wishlist({{ $itemProduct->id }})" class="btn btn-outline-primary"><i class="far fa-heart me-1"></i> {{ @$labels['shop-aggiungi-preferiti'] }}</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary" title="{{ @$labels['shop-accedi-e-aggiungi-preferiti'] }}"><i class="far fa-heart me-2"></i> {{ @$labels['shop-accedi-e-aggiungi-preferiti'] }}</a>
                                    @endif
                                @endif

                                @if(env('SLUG_COMPARE') && $pluginSetting->is_comparations)
                                        <?php
                                        $indexClass = new \App\Http\Controllers\PluginProductsController();
                                        $cartCompare = $indexClass->loading_compare();
                                        ?>
                                    <span id="compare_{{ $itemProduct->id }}">
                                    @if(!in_array($itemProduct->id, $cartCompare))
                                            <a href="{{ route('advice.compare', $itemProduct->id) }}" class="btn btn-outline-primary btn-compare"><i class="fas fa-balance-scale me-1"></i> {{ @$labels['shop-compara'] }}</a>
                                        @else
                                            <a href="{{ route('advice.compare.remove', $itemProduct->id) }}" class="btn btn-primary btn-compare"><i class="fas fa-balance-scale-left me-1"></i> {{ @$labels['shop-rimuovi-da-comparazione'] }}</a>
                                        @endif
                                </span>

                                    <a class="btn btn-outline-primary btn-compare" href="{{ route('comparatore') }}"><i class="fas fa-exchange-alt me-1"></i> {{ @$labels['shop-vai-alla-comparazione'] }}</a>
                                @endif

                                @if($plugin->is_print_pdf == 1)
                                    <a href="{{ route("pluginProducts.pdf.".\App::getLocale(), $itemProduct->id) }}" class="btn btn-outline-primary"><i class="fas fa-file-pdf me-1"></i> {{ @$labels['scarica-pdf'] }}</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-info">

                @if(trim($itemProduct->description) != "")
                    <div class="product-description mb-4">
                        <div class="h5">{{ @$labels['description-long'] }}</div>
                        <div class="product-description-inner">
                            {!! $itemProduct->description !!}
                            @include("$thema.plugins.pluginProducts.inc.video")
                        </div>
                    </div>
                @endif

                <a name="allegati-lista"></a>
                <a name="altre-info"></a>


                @if($shopSetting->box_attachments == 0)
                    @if(count($itemProduct->attachmentsList))
                        <h2><i class="fas fa-list"></i> {{ @$labels['altre-info'] }} </h2>
                    @endif
                @else
                    <h2><i class="fas fa-list"></i> {{ @$labels['altre-info'] }} </h2>
                @endif

                @if($shopSetting->box_properties == 0)

                    @if(count($itemProduct->options) || ( count($itemProduct->attachmentsList) && ($shopSetting->box_attachments == 0) ) )

                        <div class="navbar-expand-md" id="accordion-tabs">
                            <div class="collapse navbar-collapse">
                                    <?php
                                    $activeTab1 = "";
                                    $expandedTab1 = "false";
                                    $activeTab2 = "";
                                    $expandedTab2 = "false";
                                    if(count($itemProduct->options) > 0){
                                        $activeTab1 = "show";
                                        $expandedTab1 = "true";
                                    }else{
                                        $activeTab2 = "show";
                                        $expandedTab2 = "true";
                                    }
                                    ?>

                                <ul class="nav nav-tabs nav-product-info">
                                    @if(count($itemProduct->options))
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $activeTab1;?>" data-bs-toggle="collapse" data-bs-target="#collapse-tab-proprieta" href="#collapse-tab-proprieta" aria-expanded="<?php echo $expandedTab1;?>">{{ @$labels['proprieta-prodotto'] }}</a>
                                        </li>
                                    @endif
                                    @if(count($itemProduct->attachmentsList) && ($shopSetting->box_attachments == 0) )
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $activeTab2;?>" data-bs-toggle="collapse" data-bs-target="#collapse-tab-allegati" id="block-tab-allegati" href="#collapse-tab-allegati" aria-expanded="<?php echo $expandedTab2;?>">{{ @$labels['allegati-prodotto'] }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- qui vorrei un settaggio in admin fai vedere le proprietà nuovaente o altro -->
                            @if(count($itemProduct->options))
                                <div class="card">
                                    <div class="card-header navbar-toggler" data-bs-toggle="collapse" data-bs-target="#collapse-tab-proprieta" aria-label="{{ @$labels['proprieta-prodotto'] }}" aria-expanded="<?php echo $expandedTab1;?>">{{ @$labels['proprieta-prodotto'] }}</div>
                                    <div id="collapse-tab-proprieta" class="collapse <?php echo $activeTab1;?>" data-bs-parent="#accordion-tabs">
                                        <div class="card-body">
                                            @if(count($itemProduct->options))
                                                <table class="table table-bordered my-0">
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
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(count($itemProduct->attachmentsList) && ($shopSetting->box_attachments == 0) )
                                <div class="card">
                                    <div class="card-header navbar-toggler" data-bs-toggle="collapse" data-bs-target="#collapse-tab-allegati" aria-label="{{ @$labels['allegati-prodotto'] }}" aria-expanded="<?php echo $expandedTab2;?>">{{ @$labels['allegati-prodotto'] }}</div>
                                    <div id="collapse-tab-allegati" class="collapse <?php echo $activeTab2;?>" data-bs-parent="#accordion-tabs">
                                        <div class="card-body">
                                            @include("$thema.plugins.pluginProducts.inc.attachments")
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                    @endif

                @endif

                <!-- CASO NASCONDI PROPRIETA' 1 E BOX ALLEGATI a parte 0 -->
                @if(count($itemProduct->attachmentsList) && ($shopSetting->box_attachments == 0) && ($shopSetting->box_properties == 1) )

                        <div class="navbar-expand-md" id="accordion-tabs">
                            <div class="collapse navbar-collapse">
                                    <?php
                                    $activeTab1 = "";
                                    $expandedTab1 = "";
                                    $activeTab2 = "show";
                                    $expandedTab2 = "true";
                                    //if(count($itemProduct->options) > 10000){
                                    //    $activeTab1 = "show";
                                    //    $expandedTab1 = "false";
                                    //}else{
                                    //    $activeTab2 = "show";
                                    //    $expandedTab2 = "true";
                                    //}
                                    ?>

                                <ul class="nav nav-tabs nav-product-info">
                                    <!--<li class="nav-item">
                                        <a class="nav-link <?php echo $activeTab1;?>" data-bs-toggle="collapse" data-bs-target="#collapse-tab-descrizione" href="#collapse-tab-descrizione" aria-expanded="<?php echo $expandedTab1;?>">{{ @$labels['description-long'] }}</a>
                                    </li>-->

                                    @if(count($itemProduct->attachmentsList) && ($shopSetting->box_attachments == 0) )
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $activeTab2;?>" data-bs-toggle="collapse" data-bs-target="#collapse-tab-allegati" id="block-tab-allegati" href="#collapse-tab-allegati" aria-expanded="<?php echo $expandedTab2;?>">{{ @$labels['allegati-prodotto'] }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="card">
                                <div class="card-header navbar-toggler" data-bs-toggle="collapse" data-bs-target="#collapse-tab-descrizione" aria-label="{{ @$labels['allegati-prodotto'] }}" aria-expanded="<?php echo $expandedTab1;?>">{{ @$labels['description-long'] }}</div>
                                <div id="collapse-tab-descrizione" class="collapse <?php echo $activeTab1;?>" data-bs-parent="#accordion-tabs">
                                    <div class="card-body">
                                        {!! $itemProduct->description !!}
                                    </div>
                                </div>
                            </div>



                            @if(count($itemProduct->attachmentsList) && ($shopSetting->box_attachments == 0) )
                                <div class="card">
                                    <div class="card-header navbar-toggler" data-bs-toggle="collapse" data-bs-target="#collapse-tab-allegati" aria-label="{{ @$labels['allegati-prodotto'] }}" aria-expanded="<?php echo $expandedTab2;?>">{{ @$labels['allegati-prodotto'] }}</div>
                                    <div id="collapse-tab-allegati" class="collapse <?php echo $activeTab2;?>" data-bs-parent="#accordion-tabs">
                                        <div class="card-body">
                                            @include("$thema.plugins.pluginProducts.inc.attachments")
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>





                @endif
                <!-- END CASO NASCONDI PROPRIET E BOX ALLEGATI SPENTO -->


                <br/><br/>
                @if(count($itemProduct->attachmentsList) && ($shopSetting->box_attachments == 1))

                    <h2>@if($shopSetting->icon_attachments == 1) <i class="fas fa-{{ $shopSetting->icon_attachments }}"></i> @else <i class="fas fa-file-pdf"></i> @endif {{ @$labels['allegati-prodotto'] }}</h2>
                    <div class="card">
                        <div class="card-body">
                            @include("$thema.plugins.pluginProducts.inc.attachments")
                        </div>
                    </div>
                @endif

            </div>

            @if($plugin->show_form_contact == 1 && $adminPlugin->version <= 3)
                @include("$thema.plugins.pluginProducts.inc.formContact")
            @else
                @if(($itemProduct->is_purchasable == 0 || $itemProduct->is_button_for_request == 1) || ((env("PROJECT_NAME") == "Manega") && strpos( \URL::current(),"luxury")))
                    @include("$thema.plugins.pluginProducts.inc.formContact")
                @endif
            @endif
        </div>
        @include("$thema.plugins.pluginProducts.v3.shop.products_related")
    </div>
</section>
@endif
