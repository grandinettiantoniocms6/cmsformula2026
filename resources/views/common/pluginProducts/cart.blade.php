<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$symbol = "&euro;";
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
    $symbol = "&#36;";
}
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
    $symbol = "&euro;";
}
?>
<main>
    <div class="page-content pt-7 pb-10">
        <section class="section-page-header bg-light py-4 border-bottom">
            <div class="container">
                <h2 class="h3 my-0">{{ @$labels['shop-carrello'] }}</h2>
            </div>
        </section>

        <section class="py-4">
        <div class="container mt-7 mb-2">
            @if($cart)
                <div class="row">
                    <div class="col-lg-8 col-md-12 pr-lg-4">

                        <form method="post" action="{{ route('update.cart') }}" id="form-update-cart">
                            {{ csrf_field() }}

                                        <table class="shop-table cart-table">
                                            <thead>
                                            <tr>
                                                <th><span>{{ @$labels['shop-carrello-prodotto'] }}</span></th>
                                                <th></th>
                                                <th><span>{{ @$labels['shop-carrello-prezzo'] }}</span></th>
                                                <th><span>{!! @$labels['shop-carrello-qta'] !!}</span></th>
                                                <th><span>{{ @$labels['shop-carrello-tot'] }}</span></th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $tot = 0;
                                                $totNoTax = 0;
                                                $v_tax = [];
                                            @endphp

                                            @foreach ($cart as $item)
                                                @php
                                                    $product = \App\Models\PluginProducts::find($item->product_id);
                                                    if(!$product){
                                                        continue;
                                                    }

                                                    $vat = $product->tax ? $product->tax->value : 22;
                                                    $vat_calculate = ($vat / 100) + 1;
                                                    $v_tax[$vat] = 0;

                                                    $finalPrice = $product->getFinalPrice();
                                                    $priceOld = $finalPrice;

                                                    $cat_prod_name = "";
                                                    $cat_prod_slug = "no-categoria";
                                                    $cat_prod = $product->category();
                                                    if($cat_prod){
                                                        $cat_prod_name = $cat_prod->name;
                                                        $cat_prod_slug = $cat_prod->slug;
                                                    }

                                                    $url_product = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]);
                                                    $cover = $product->getCover();
                                                @endphp
                                                <tr>
                                                    <td class="product-thumbnail">
                                                        <figure>
                                                            <a href="{{ $url_product }}">
                                                                @if($product->is_variant == 1)
                                                                    <?php
                                                                    $padre = \App\Models\PluginProducts::where("group_id", $product->group_id)->where("is_variant", 0)->first();

                                                                    if($padre && $product->include_photo_padre == 1){
                                                                       $coverPadre = $padre->getCover();
                                                                       echo "<img width='100' class='card' src='$coverPadre'>";
                                                                    }
                                                                    ?>
                                                                    <img width="100" class="card" src="{{ $cover }}" alt="{{ $item->product_name }}">
                                                                @else
                                                                    <img width="100" class="card" src="{{ $cover }}" alt="{{ $item->product_name }}">
                                                                @endif
                                                            </a>
                                                        </figure>
                                                    </td>
                                                    <td class="product-name" data-column="Prodotto">
                                                        <div class="product-name-section">
                                                            <a href="{{ $url_product }}">
                                                                @if(env("PROJECT_NAME") == "Maison-Flaneur")
                                                                   {{ $product->sku }}
                                                                @else
                                                                   {{ $product->name }}
                                                                   <br>
                                                                   <small><b>{{ @$labels['sku'] }}:</b> {{ $product->sku }}</small>
                                                                @endif
                                                            </a>

                                                            @if(property_exists($item, "extra"))
                                                                @if($item->extra)
                                                                    <br>
                                                                    @foreach($item->extra as $extra_id => $value)
                                                                         <?php
                                                                         $extra = \App\Models\ShopExtra::find($extra_id);
                                                                         ?>
                                                                         {{ $extra->name }}<br>
                                                                         <small>{{ $value }}</small>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal" data-column="Prezzo">
                                                        @if($finalPrice != $priceOld)
                                                            <span>{!! $symbol !!} {{ number_format($finalPrice,2, ',','.') }}</span>
                                                            <span class="text-muted"><del>{!! $symbol !!} {{ number_format($priceOld,2, ',','.') }}</del></span>
                                                        @else
                                                            <span>{!! $symbol !!} {{ number_format($item->price,2, ',','.') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="product-quantity" data-column="Q.tà">
                                                        <div class="input-group input-spinner">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-default" type="button" id="button-minus" onclick="decreaseValue('#qty_<?php echo $item->product_id;?>')"><i class="fas fa-minus"></i></button>
                                                            </div>
                                                            <?php
                                                            $qty_max = $product->qty;
                                                            if($product->qty_max){
                                                                $qty_max = $product->qty_max;
                                                            }
                                                            ?>
                                                            <input type="text" class="form-control form-control-qty text-right" id="qty_<?php echo $item->product_id;?>" step="1" min="1" max="<?php echo $qty_max;?>"
                                                                   name="quantity[<?php echo $item->product_id;?>]"
                                                                   value="{{ $item->qty }}" readonly>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-default" type="button" id="button-plus" onclick="increaseValue('#qty_<?php echo $item->product_id;?>')"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>


                                                    @php
                                                        $productTotal = $item->price * $item->qty;
                                                        $tot = $tot + $productTotal;
                                                        $prezzoNoIva = $productTotal / ((100 + $vat)/100);

                                                        $v_tax[$vat] += $productTotal - $prezzoNoIva;

                                                        $totNoTax = $totNoTax + $prezzoNoIva;
                                                    @endphp

                                                    <td class="product-price" data-column="Totale">{!! $symbol !!}
                                                        @php
                                                            echo number_format($productTotal,2, ',','.');
                                                        @endphp
                                                    </td>
                                                    <td class="product-close" data-column="Rimuovi dal carrello">
                                                        <a class="btn btn-sm" href="{{ route('remove.cart.list') }}?id={{ $item->product_id }}"><span data-toggle="tooltip" title="" data-original-title="Rimuovi/Remove"><i class="fas fa-times"></i></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>


                                        <div class="cart-actions mb-6 pt-4">
                                            <div class="row">
                                                <div class="col-sm-auto pt-2">
                                                    <a href="{{ route('index') }}" class="btn btn-primary btn-block" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif > <i class="fa fa-chevron-left mr-2"></i> {{ @$labels['shop-continua-shopping'] }}</a>
                                                </div>
                                                <div class="col-sm-auto ml-auto py-2 text-right">
                                                    <button type="submit" class="btn btn-primary btn-block" form="form-update-cart" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-aggiorna-carello'] }} <i class="fa fa-chevron-right ml-2"></i></button>
                                                </div>
                                            </div>
                                        </div>

                        </form>

                    </div> <!-- col.// -->

                    <aside class="col-lg-4 sticky-sidebar-wrapper">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="my-0">{{ @$labels['shop-riepilogo-carrello'] }}</h5>
                            </div>
                            <div class="card-table">
                                <table class="table my-0">
                                    <tbody>
                                    @if(env('HIDE_TASSE') == 0)
                                        <tr>
                                            <th class="col-auto font-weight-normal">
                                                <span class="d-block line-height-1">{{ @$labels['shop-subtotale-carrello'] }}</span>
                                                <small>{{ @$labels['shop-tasse-escl'] }}</small>
                                            </th>
                                            <td class="col text-right">{!! $symbol !!} <span id="total_no_tax">@php echo number_format(round($totNoTax,2),2, ',','.'); @endphp</span></td>
                                        </tr>

                                        @if($v_tax)
                                            @foreach($v_tax as $k=>$v)
                                                <tr>
                                                    <th class="col-auto font-weight-normal">{{ @$labels['shop-tasse'] }} <small>{{ (int) $k }}%</small></th>
                                                    <td class="col text-right">{!! $symbol !!} <span id="sum_tax">@php echo number_format(round($v,2),2, ',','.'); @endphp</span></td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    @endif
                                    <tr id="shipping_view"></tr>
                                    <tr id="discount_coupon"></tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="col-auto">{{ @$labels['shop-totale-carrello'] }}</th>
                                        <td class="col text-right font-weight-bold">{!! $symbol !!} <span id="total_view">
                                                @php
                                                    echo number_format($tot,2, ',','.');
                                                @endphp
                                            </span>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="card-body border-top bg-light py-2">
                                <a href="{{ route('checkout') }}" class="btn btn-primary btn-block" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif >{{ @$labels['shop-completa-acquisto'] }} <i class="fa fa-chevron-right ml-2"></i></a>
                            </div>
                        </div>

                        <input type="hidden" id="total_product" name="total_product" value="@php echo (float) $tot; @endphp">
                        <input type="hidden" name="total" id="total" value="@php echo (float) $tot; @endphp">
                        <input type="hidden" name="total_ship" id="total_ship" value="0">

                    </aside>
                </div>
            @else
                <div class="card-body text-center">
                    <div class="display-4"><i class="fa fa-shopping-cart"></i></div>
                    <h3>{{ @$labels['shop-carrello-vuoto'] }}</h3>
                    <div class="d-block">
                        <a class="btn btn-primary btn-block" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif href="{{ route('index') }}">{{ @$labels['shop-continua-acquisti'] }}</a>
                    </div>
                </div>
            @endif

        </div>
    </section>
    </div>
</main>
