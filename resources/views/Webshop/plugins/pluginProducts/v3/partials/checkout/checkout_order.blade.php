<?php
$shopSetting = \App\Models\ShopSettings::first();
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$symbol = "&euro;";
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
    $symbol = "&#36;";
}
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
    $symbol = "&euro;";
}
?>

<table class="table table-sm table-cart-summary">
    <thead>
        <tr>
            <th>{{ @$labels['shop-partials-prodotto'] }}</th>
            <th class="text-end" width="100">{{ @$labels['shop-partials-totale'] }}</th>
        </tr>
    </thead>
    <tbody>
    @if($order->products)
        @php
            $subTotal = 0;
            $total = 0;
            $v_tax = [];
             foreach ($order->products as $product){
                $vat = $product->tax ? $product->tax->value : 22;
                $vat_calculate = ($vat / 100) + 1;
                $v_tax[$vat] = 0;
            }
        @endphp
        @foreach($order->products as $product)
            <?php
            $vat = $product->tax ? $product->tax->value : 22;
            $vat_calculate = ($vat / 100) + 1;

            $extra_list = \App\Models\ShopOrderProductExtra::where("shop_order_id", $product->pivot->order_id)->where("shop_product_id", $product->id)
                ->get()->pluck("value", "extra_id")->toArray();
            ?>
            <tr>
                <td>
                    @if(trim($product->custom_1) != "") <label class="product-label product-label-custom-color-1">{{ $product->custom_1 }}</label> @endif
                    @if(trim($product->custom_2) != "") <label class="product-label product-label-custom-color-2">{{ $product->custom_2 }}</label> @endif

                    @if(env("PROJECT_NAME") == "Maison-Flaneur")
                        <div>{{ $product->sku }}</div>
                    @else
                        <div class="fw-bold line-height-md">{{ $product->pivot->name }}</div>
                    @endif

                    @if($product->pivot->price_add > 0)
                        <?php
                        if(env('VIEW_WITH_IVA') == 1){
                            $sum_price_options = number_format($product->pivot->price_add * $vat_calculate,2,",",".");
                        }else{
                            $sum_price_options = number_format($product->pivot->price_add,2,",",".");
                        }
                        ?>
                        @if(env('VIEW_WITH_IVA') == 1)
                            <div class="line-height-md">{{ @$labels['shop-carrello-prezzo'] }}: &euro; {{ number_format($product->pivot->price_unit * $vat_calculate,2,",",".") }}</div>
                            <div class="line-height-md">{{ @$labels['shop-opzioni-aggiuntive'] }}: &euro; {{ $sum_price_options }}</div>
                        @else
                            <div class="line-height-md">{{ @$labels['shop-carrello-prezzo'] }}: &euro; {{ number_format($product->pivot->price_unit,2,",",".") }}</div>
                            <div class="line-height-md">{{ @$labels['shop-opzioni-aggiuntive'] }}: &euro; {{ $sum_price_options }}</div>
                        @endif
                    @endif

                    <div class="line-height-md">{{ @$labels['shop-carrello-qta'] }}: {{ $product->pivot->quantity }}</div>
                    <br>

                    @if($extra_list)
                        @foreach($extra_list as $extra_id => $value)
                            <?php $extra = \App\Models\ShopExtra::find($extra_id); ?>
                            <div class="font-sm">{{ $extra->name }}: {{ $value }}</div>
                        @endforeach
                    @endif

                    @if($product->pivot->message)
                        <div class="extra">
                            <div><em>{{ @$labels['testo-custom'] }}:</em> {{ $product->pivot->message }}</div>
                        </div>
                    @endif

                    @if($product->pivot->file)
                        <div class="extra">
                            <div><em>File:</em> <a href="{{ url("uploads/{$product->pivot->file}") }}" target="_blank">
                                    {{ @$labels['testo-vedi-file'] }}
                                </a> </div>
                        </div>
                    @endif
                </td>
                <td class="text-end">{!! $symbol !!}
                        <?php echo number_format($product->pivot->price_unit + $product->pivot->price_add,2, ',','.'); ?>
                </td>
            </tr>
            @php
                $subTotal = $subTotal + ($product->pivot->quantity * $product->pivot->price);
                $total = $total + ($product->pivot->quantity * $product->pivot->price_with_tax);

                $v_tax[$vat] += ($product->pivot->price_with_tax * $product->pivot->quantity) - ($product->pivot->price * $product->pivot->quantity);
            @endphp
        @endforeach
    @endif
    @php
           $total = $total;
    @endphp

    @if(env('HIDE_TASSE') == 0)
        <tr>
            <th>{{ @$labels['shop-partials-tot-tasse-esc'] }}</th>
            <td class="text-end">{!! $symbol !!} <span id="total_no_tax">{{ number_format(round($subTotal, 3),2, ',','.') }}</span></td>
        </tr>

        <tr>
            <th>{{ @$labels['shop-partials-tit-spedizione'] }}
                @if(\Auth::user())
                    @if(\Auth::user()->type_client == 1)
                        {{ @$labels['shop-tasse-escl'] }}
                    @endif
                @endif
            </th>
            <td class="text-end">{!! $symbol !!}
                <span id="total_no_tax">
                    @if(\Auth::user())
                        @if(\Auth::user()->type_client == 1)
                            {{ number_format($order->total_shipping,2, ',','.') }}
                        @else
                            {{ number_format($order->total_shipping_tax,2, ',','.') }}
                        @endif
                    @else
                        {{ number_format($order->total_shipping_tax,2, ',','.') }}
                    @endif
                </span>
            </td>
        </tr>

        <?php
        if(key_exists("22.00", $v_tax)){
            if(\Auth::user()){
                if(\Auth::user()->type_client == 1){
                    if($order->total_shipping_tax > 0){
                        $v_tax["22.00"] += ($order->total_shipping_tax - $order->total_shipping);
                    }
                }
            }
        }
        ?>

        @if($v_tax)
            @foreach($v_tax as $k=>$v)
                <tr>
                    <th>{{ @$labels['shop-checkout-tasse'] }} <small>{{ (int) $k }}%</small></th>
                    <td class="text-end">{!! $symbol !!} <span id="sum_tax">@php echo number_format(round($v,3),2, ',','.'); @endphp</span></td>
                </tr>
            @endforeach
        @endif
    @endif
    @if($order->code_coupon)
            <tr>
                <th>{{ @$labels['shop-partials-tot-coupon'] }} <small>{{ @$labels['shop-partials-iva-inc'] }}</small></th>
                <td class="text-end">{!! $symbol !!} <span id="total_no_tax">- {{ number_format(round(($order->total_coupon), 3),2, ',','.') }}</span></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>{{ @$labels['shop-checkout-totale'] }}</th>
                <td class="text-end">{!! $symbol !!} <span id="total_view">{{ number_format((($order->total_tax - $order->total_coupon) + $order->total_shipping_tax + $order->total_extra),2, ',','.') }}</span></td>
            </tr>
        </tfoot>
    @else
        </tbody>
        <tfoot>
            <tr>
                <th>{{ @$labels['shop-checkout-totale'] }}</th>
                <td class="text-end">{!! $symbol !!} <span id="total_view">{{ number_format(($order->total_tax + $order->total_extra + $order->total_shipping_tax),2, ',','.') }}</span></td>
            </tr>
        </tfoot>
    @endif
</table>
