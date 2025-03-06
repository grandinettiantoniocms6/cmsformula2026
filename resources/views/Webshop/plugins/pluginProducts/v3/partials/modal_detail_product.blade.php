<?php
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
?>
<div class="modal" role="dialog" id="modalProductView">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalView({{ $itemProduct->id }})"></button>
            </div>
            <div class="modal-body">
                <div class="single-product row py-0">
                    @include("Webshop.plugins.pluginProducts.v3.shop.type_detail_photo_modal_view")
                    <div class="col-md-7">
                        <div class="product-details">
                            @include("Webshop.plugins.pluginProducts.v3.shop.view_brand")

                            @if(session()->has('message'))
                                <div class="alert alert-success text-center">{{ @$labels['shop-alert-aggiunto-al-carrello'] }}</div>
                            @endif

                            @if(session()->has('error'))
                                <div class="alert alert-warning text-center">{{ @$labels['shop-alert-aggiunto-al-carrello-error'] }}</div>
                            @endif

                            <h1 class="product-name">
                                @if($shopSetting->type_view_variant == 3 && $padre)
                                    {{ $padre->name }}
                                @else
                                    {{ $itemProduct->name }}
                                @endif
                            </h1>


                            @if($shopSetting->type_view_variant != 3)
                                <div class="product-price">
                                    @if($adminPlugin->version == 3)
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
                                    @endif
                                </div>

                                @if($adminPlugin->version == 3 && $plugin->show_prices == 1)
                                    @include("Webshop.plugins.pluginProducts.v3.promo")
                                @endif

                                <p class="product-short-description">{!! $itemProduct->description_short !!}</p>
                            @endif

                            <div class="product-meta">

                                <div class="product-sku"><b>{{ @$labels['sku'] }}:</b> {{ $itemProduct->sku }}</div>
                                <div class="product-cats"><b>{{ @$labels['categoria'] }}:</b>
                                    @if($categories_products)
                                        @foreach($categories_products as $category_product)
                                            <a href="{{ route("pluginProducts.".\App::getLocale(), [$category_product->slug]) }}">{{ $category_product->name }}</a>
                                        @endforeach
                                    @endif
                                </div>

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
                                            <div class="product-stock">{{ @$labels['qty'] }}: {{ $itemProduct->qty }}</div>
                                        @endif
                                    @endif
                                @endif

                                @if(trim($itemProduct->tags) != "" && $itemProduct->tags != null)
                                    <?php $tags = explode(",", $itemProduct->tags); ?>
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

                            @if($adminPlugin->version == 3)
                                @if($shopSetting->type_view_variant == 1)
                                    @include("Webshop.plugins.pluginProducts.v3.shop.select_variants")

                                    <div id="button_modal_goto"></div>
                                @endif

                                @if($shopSetting->type_view_variant == 4)
                                    @include("Webshop.plugins.pluginProducts.v3.shop.radio_variants")

                                    <div id="button_modal_goto"></div>
                                @endif

                                @if($shopSetting->type_view_variant == 2 && $itemProduct->is_variant == 0)
                                    @include("Webshop.plugins.pluginProducts.v3.shop.table_variants")
                                @endif

                                @if($shopSetting->type_view_variant == 3)
                                    @include("Webshop.plugins.pluginProducts.v3.shop.html_variants")
                                @endif

                                @if($itemProduct->is_purchasable == 1 && $shopSetting->type_view_variant == 1 && $promo_price > 0)
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

                                                <div id="box_modal_detail">
                                                    @if($plugin->is_add_to_cart == 1)
                                                        <form method="post" action="{{ route('add.cart.product') }}" id="modalFormProductView">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id" value="{{ $itemProduct->id }}">
                                                            <input type="hidden" name="modal" value="1">

                                                            <div class="product-form-group row">
                                                                <div class="input-group input-spinner w-auto col-auto">
                                                                    <button class="quantity-minus btn btn-default button-minus" type="button" onclick="decreaseValue('#qty_{{ $itemProduct->id }}')"><i class="fas fa-minus"></i></button>
                                                                    <input class="quantity form-control form-control-qty" type="number" name="qty" min="1" @if($plugin->is_qty_infinite == 0) max="{{ $max }}" @endif value="1" id="qty_{{ $itemProduct->id }}">
                                                                    <button class="quantity-plus btn btn-default button-plus" type="button" onclick="increaseValue('#qty_{{ $itemProduct->id }}')"><i class="fas fa-plus"></i></button>
                                                                </div>
                                                                <a class="btn btn-primary col-auto" onclick="add_modal_cart({{ $itemProduct->id }})">
                                                                    <i class="bi bi-bag-fill"></i><span class="ps-2">{{ @$labels['shop-add-to-cart'] }}</span>
                                                                </a>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    <strong>{{ @$labels['shop-nel-carrello'] }}</strong> {{ @$labels['shop-prodotto-gia-nel-carrello'] }}
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-sm my-1"><a class="btn btn-secondary w-100" href="{{ route('cart') }}"><i class="bi bi-bag-fill"></i> {{ @$labels['shop-edit-cart'] }}</a></div>
                                                    <div class="col-sm my-1"><a class="btn btn-success text-white w-100" href="{{route('checkout')}}"><i class="bi bi-check-circle"></i> {{ @$labels['shop-completa-acquisto'] }}</a></div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if($plugin->show_form_contact == 1)
                                        <!-- <p><a class="btn btn-primary btn-lg" href="#block-product-contact"><i class="fas fa-euro-sign"></i> {{ @$labels['richiedi-preventivo'] }}</a></p> -->
                                    @endif
                                @endif

                                @if(count($itemProduct->options))
                                    @if(count($itemProduct->options))
                                        <table class="table table-sm table-bordered size-table my-3">
                                            <tbody>
                                            @foreach($itemProduct->options as $option)
                                                <?php
                                                $name = json_decode($option->name, true);
                                                if(!key_exists(\App::getLocale(), $name)){
                                                    continue;
                                                }
                                                ?>
                                                <tr>
                                                    <th>{{ $name[\App::getLocale()] }}</th>
                                                    <td>{{ $option->value }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                @endif
                            @endif

                            <div class="product-footer">
                                @include("Webshop.plugins.pluginProducts.v3.shop.size_guide")

                                @if($plugin->is_print_pdf == 1)
                                    <a href="{{ route("pluginProducts.pdf.".\App::getLocale(), $itemProduct->id) }}" class="btn btn-white"><i class="fas fa-file-pdf"></i> {{ @$labels['scarica-pdf'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
