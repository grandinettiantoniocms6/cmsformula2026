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

<section class="border-top border-bottom py-3 py-sm-4">
    <div class="container">
        <h1 class="page-title font-2xl my-0">{{ @$labels['shop-carrello'] }}</h1>
    </div>
</section>

<section class="page-shop py-4 py-lg-5">
    <div class="container-fluid container-2xl">
        @if($cart)
            <div class="row">
                <div class="col-lg-8">
                    <form method="post" action="{{ route('update.cart') }}" id="form-update-cart">
                        {{ csrf_field() }}

                        <table class="table table-sm table-cart">
                            <thead class="font-sm">
                            <tr>
                                <th>{{ @$labels['shop-carrello-prodotto'] }}</th>
                                <th></th>
                                <th>{{ @$labels['shop-carrello-prezzo'] }}</th>
                                <th>{!! @$labels['shop-carrello-qta'] !!}</th>
                                <th>{{ @$labels['shop-carrello-tot'] }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $tot = 0;
                                $totNoTax = 0;
                                $v_tax = [];

                                foreach ($cart as $item){
                                    $product = \App\Models\PluginProducts::find($item->product_id);
                                    if(!$product){
                                        continue;
                                    }

                                    $vat = $product->tax ? $product->tax->value : 22;
                                    $vat_calculate = ($vat / 100) + 1;
                                    $v_tax[$vat] = 0;
                                }
                            @endphp

                            @foreach ($cart as $item)
                                @php
                                    $product = \App\Models\PluginProducts::find($item->product_id);
                                    if(!$product){
                                        continue;
                                    }

                                    $vat = $product->tax ? $product->tax->value : 22;
                                    $vat_calculate = ($vat / 100) + 1;

                                     if(env('VIEW_WITH_IVA') == 0){
                                        $item->price = $item->price / $vat_calculate;
                                     }

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
                                    </td>
                                    <td class="product-name" data-column="Prodotto">
                                        <a href="{{ $url_product }}">
                                            @if(env("PROJECT_NAME") == "Maison-Flaneur")
                                                <div class="fw-bold">{{ $product->sku }}</div>
                                            @else
                                                <div class="fw-bold">{{ $product->name }}</div>
                                                <div class="font-sm mt-1"><b>{{ @$labels['sku'] }}:</b> {{ $product->sku }}</div>
                                            @endif
                                        </a>
                                        @if(property_exists($item, "extra"))
                                            @if($item->extra)
                                                <div class="extra">
                                                @foreach($item->extra as $extra_id => $value)
                                                    <?php $extra = \App\Models\ShopExtra::find($extra_id); ?>
                                                    <div>{{ $extra->name }}</div>
                                                    <div class="font-sm">{{ $value }}</div>
                                                @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="product-subtotal" data-column="Prezzo">

                                        @if($finalPrice != $priceOld)
                                            <?php
                                            $temp_price = number_format($finalPrice,3, ',','.');
                                            $strlen = strlen($temp_price);
                                            $price_prod = $temp_price[$strlen-1] == "0" ? number_format($finalPrice,2, ',','.') : number_format($finalPrice,3, ',','.');
                                            ?>

                                            <span>{!! $symbol !!} {{ number_format((float) $price_prod,3, ',','.') }}</span>
                                            <span class="text-muted"><del>{!! $symbol !!} {{ number_format($priceOld,3, ',','.') }}</del></span>
                                        @else
                                            <?php
                                            $temp_price = number_format($item->price,3, ',','.');
                                            $strlen = strlen($temp_price);
                                            $price_prod = $temp_price[$strlen-1] == "0" ? number_format($item->price,2, ',','.') : number_format($item->price,3, ',','.');
                                            ?>

                                                <span>{!! $symbol !!} {{ number_format((float) $price_prod,3, ',','.') }}</span>
                                        @endif
                                    </td>
                                    <td class="product-quantity" data-column="Q.tà">
                                            <div class="input-group input-spinner">
                                                <button class="btn btn-default button-minus" type="button" onclick="decreaseValue('#qty_<?php echo $item->product_id;?>')"><i class="fas fa-minus"></i></button>
                                                <?php
                                                $qty_max = $product->qty;
                                                if($product->qty_max){
                                                    $qty_max = $product->qty_max;
                                                }
                                                ?>
                                                <input type="text" class="form-control form-control-sm form-control-qty" id="qty_<?php echo $item->product_id;?>" step="1" min="1" max="<?php echo $qty_max;?>"
                                                       name="quantity[<?php echo $item->product_id;?>]"
                                                       value="{{ $item->qty }}">
                                                <button class="btn btn-default button-plus" type="button" onclick="increaseValue('#qty_<?php echo $item->product_id;?>')"><i class="fas fa-plus"></i></button>
                                            </div>
                                    </td>
                                    @php
                                        $productTotal = ($item->price * $vat_calculate) * $item->qty;
                                        $tot = $tot + $productTotal;
                                        $prezzoNoIva = $productTotal / ((100 + $vat)/100);

                                        $v_tax[$vat] += $productTotal - $prezzoNoIva;


                                        $totNoTax = $totNoTax + $prezzoNoIva;
                                    @endphp

                                    <td class="product-price" data-column="Totale">{!! $symbol !!} <?php echo number_format($productTotal,2, ',','.'); ?></td>
                                    <td class="product-remove" data-column="Rimuovi dal carrello">
                                        <a class="btn btn-sm btn-remove" href="{{ route('remove.cart.list') }}?id={{ $item->product_id }}"><span data-bs-toggle="tooltip" title="" data-original-title="Rimuovi/Remove"><i class="fas fa-times"></i></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                        <div class="row gx-2 my-3">
                            <div class="col-auto my-1">
                                <?php
                                $lang = \App::getLocale();
                                $url = route("pluginProducts.$lang");
                                ?>
                                <a href="{{ $url }}" class="btn btn-sm btn-secondary"><i class="bi bi-chevron-left me-1"></i> {{ @$labels['shop-continua-shopping'] }}</a>
                            </div>
                            <div class="col-auto my-1">
                                <button type="submit" class="btn btn-sm btn-primary" form="form-update-cart">{{ @$labels['shop-aggiorna-carello'] }} <i class="bi bi-chevron-right ms-1"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <aside class="col-lg-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5>{{ @$labels['shop-riepilogo-carrello'] }}</h5>
                            <table class="table table-sm table-cart-summary">
                                <tbody>
                                    @if(env('HIDE_TASSE') == 0)
                                        <tr>
                                            <th>{{ @$labels['shop-subtotale-carrello'] }} <small>{{ @$labels['shop-tasse-escl'] }}</small></th>
                                            <td class="text-end">{!! $symbol !!} <span id="total_no_tax">@php echo number_format(round($totNoTax,3),2, ',','.'); @endphp</span></td>
                                        </tr>
                                        @if($v_tax)
                                            @foreach($v_tax as $k=>$v)
                                                <tr>
                                                    <th class="fw-normal">{{ @$labels['shop-tasse'] }} <small>{{ (int) $k }}%</small></th>
                                                    <td class="text-end">{!! $symbol !!} <span id="sum_tax">@php echo number_format(round($v,3),2, ',','.'); @endphp</span></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                    <tr id="shipping_view"></tr>
                                    <tr id="discount_coupon"></tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{ @$labels['shop-totale-carrello'] }}</th>
                                        <td class="text-end fw-bold">{!! $symbol !!}<span id="total_view"><?php echo number_format(round($tot,3),2, ',','.'); ?></span></td>
                                    </tr>
                                </tfoot>
                            </table>

                            @if($blockButton == 0)
                                 <a href="{{ route('checkout') }}" class="btn btn-primary w-100">{{ @$labels['shop-completa-acquisto'] }} <i class="bi bi-chevron-right"></i></a>
                            @endif

                        </div>

                        @if($blockButton == 1)
                            <br><span class="alert alert-danger"><strong>{{ @$labels['shop-completa-acquisto-error-abbonamenti'] }}</strong></span><br>
                        @endif
                        <input type="hidden" id="total_product" name="total_product" value="@php echo (float) $tot; @endphp">
                        <input type="hidden" name="total" id="total" value="@php echo (float) $tot; @endphp">
                        <input type="hidden" name="total_ship" id="total_ship" value="0">
                    </div>
                </aside>
            </div>
        @else
            <div class="card-body text-center">
                <div class="font-6xl"><i class="bi bi-basket"></i></div>
                <h3 class="mb-4">{{ @$labels['shop-carrello-vuoto'] }}</h3>
                <?php
                $lang = \App::getLocale();
                $url = route("pluginProducts.$lang");
                ?>
                <a class="btn btn-primary px-4" href="{{ $url }}">{{ @$labels['shop-continua-acquisti'] }}</a>
            </div>
        @endif
    </div>
</section>

<style>
    .input-spinner .form-control-qty {
        max-width: 60px !important;
    }
</style>

