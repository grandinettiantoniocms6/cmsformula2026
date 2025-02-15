<div class="modal" tabindex="-1" role="dialog" id="modalProductView">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $itemProduct->name }}</h5>
                <a href="javascript:closeModalView({{ $itemProduct->id }})" class="close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="product product-single row mb-7">
                    @include("common.pluginProducts.shop.type_detail_photo_modal_view")

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

                                        @if($plugin->show_prices == 1)
                                            @include("Webshop.plugins.pluginProducts.v3.shop.calculate_price")
                                        @endif

                                        @if($symbol == "&euro;")
                                            @if($itemProduct->price_srp != 0)
                                                <ins class="new-price">{{ @$labels['shop-srp'] }} {!! $symbol !!}
                                                    @if(env('VIEW_WITH_IVA') == 1)
                                                        {{ number_format($itemProduct->price_srp * 1.22, 2, ",", ".") }}
                                                    @else
                                                        {{ number_format($itemProduct->price_srp, 2, ",", ".") }}
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

                                    @if($plugin->show_prices == 1)
                                        @include('common.pluginProducts.promo')
                                    @endif

                                <!-- END Blocco Prezzo + Promo CountDown -->

                                    <!-- Blocco descrizione breve -->

                                    <p class="product-short-desc">
                                        {!! $itemProduct->description_short !!}
                                    </p>

                                    <!-- END Blocco descrizione breve -->

                                @endif

                            <!-- Blocco SKU/Categoria/Q.ty/Tags -->

                                <!-- riga 82 significa se il nome progetto è diverso da MF allora-->
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

                                <div id="button_modal_goto"></div>
                            @endif

                            @if($shopSetting->type_view_variant == 4)
                                @include('common.pluginProducts.shop.radio_variants')

                                <div id="button_modal_goto"></div>
                            @endif

                            @if($shopSetting->type_view_variant == 2 && $itemProduct->is_variant == 0)
                                @include('common.pluginProducts.shop.table_variants')
                            @endif

                            @if($shopSetting->type_view_variant == 3)
                                @include('common.pluginProducts.shop.html_variants')
                            @endif



                            @if($itemProduct->is_purchasable == 1 && $shopSetting->type_view_variant == 1 && $promo_price > 0)
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
                                            @if($plugin->is_add_to_cart == 1)
                                            <form method="post" action="{{ route('add.cart.product') }}" id="modalFormProductView">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $itemProduct->id }}">
                                                <input type="hidden" name="modal" value="1">

                                                <hr class="product-divider mb-3">

                                                <div class="product-form product-qty">
                                                    <div class="product-form-group">
                                                        <div class="input-group mr-2">
                                                            <button class="quantity-minus fas fa-minus" type="button"></button>
                                                            <input class="quantity form-control" type="number" name="qty" min="1" @if($plugin->is_qty_infinite == 0) max="{{ $max }}" @endif value="1">
                                                            <button class="quantity-plus fas fa-plus" type="button"></button>
                                                        </div>
                                                        <a class="btn btn-product btn-shoppy text-normal ls-normal font-weight-semi-bold" href="javascript:add_modal_cart({{ $itemProduct->id }})" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};"><i class="fas fa-shopping-cart" style="color: {{ $website->btn_txt_color }}"></i> <span class="pl-2" style="color: {{ $website->btn_txt_color }}">{{ @$labels['shop-add-to-cart'] }}</span></a>
                                                    </div>
                                                </div>

                                                <hr class="product-divider mb-3">

                                            </form>
                                            @endif
                                        @else
                                            <div class="form-group">
                                                <div class="alert alert-warning alert-dark alert-round alert-inline">
                                                    <h4 class="alert-title">{{ @$labels['shop-nel-carrello'] }}</h4>
                                                    {{ @$labels['shop-prodotto-gia-nel-carrello'] }}
                                                </div>
                                            </div>
                                            <a href="{{ route('cart') }}" class="btn btn-lg btn-block px-1 px-md-2"><span class="text">{{ @$labels['shop-edit-cart'] }}</span></a>
                                            <a class="btn btn-shoppy btn-block btn-lg px-1 px-md-2" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};" href="{{route('checkout')}}"><span style="color: {{ $website->btn_txt_color }}">{{ @$labels['shop-completa-acquisto'] }}</span></a>

                                        @endif
                                    @endif


                                @endif
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


                            <div class="product-footer">
                                @include('common.pluginProducts.shop.size_guide')

                                @if($plugin->is_print_pdf == 1)
                                    <a href="{{ route("pluginProducts.pdf.".\App::getLocale(), $itemProduct->id) }}" class="btn btn-block btn-link"><i class="fas fa-file-pdf"></i>{{ @$labels['scarica-pdf'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="javascript:closeModalView({{ $itemProduct->id }})">Chiudi</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#first_attribute').change(function(){
            $("#button_modal_goto").html("");
            var val = $(this).val();
            if(val != ""){
                var token = '{{ csrf_token() }}';
                var product_id = "{{ $itemProduct->id }}";
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get_second_attribute_detail_product') }}',
                    data: 'product_id='+product_id+'&val='+val+'&_token=' + token,
                    dataType: 'json',
                    success: function (data) {
                        if(data.slug){
                            if(data.button){
                                $("#button_modal_goto").html(data.button);
                            }
                            //window.location.href = data.slug;
                        }else{
                            $('#second_attribute_box').html(data.contents);
                        }
                    },
                    error: function() {}
                });
            }
        });
    });

    function redirectVariant(value){
        var url = value.value;
        if(url != ""){
            $("#button_modal_goto").html('<a class="btn btn-primary" href="'+url+'">Vai al prodotto</a>');
        }
    }

    function click_radio(val){
        if(val != ""){
            var token = '{{ csrf_token() }}';
            var product_id = "{{ $itemProduct->id }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('get_second_attribute_detail_product') }}',
                data: 'radio=1&product_id='+product_id+'&val='+val+'&_token=' + token,
                dataType: 'json',
                success: function (data) {
                    if(data.redirect == 1 && data.slug){
                        if(data.button){
                            $("#button_modal_goto").html(data.button);
                        }
                    }else{
                        if(data.slug){
                            if(data.button){
                                $("#button_modal_goto").html(data.button);
                            }
                        }else{
                            $('#second_attribute_box').html(data.contents);
                        }
                    }
                },
                error: function() {}
            });
        }
    }
</script>
