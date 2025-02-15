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
<table class="table my-0">
    <thead>
        <tr>
            <th>{{ @$labels['shop-partials-prodotto'] }}</th>
            <th class="text-right" width="100">{{ @$labels['shop-partials-totale'] }}</th>
        </tr>
    </thead>
    <tbody>
    @if($order->products)
        @php
            $subTotal = 0;
            $total = 0;
            $v_tax = [];
        @endphp
        @foreach($order->products as $product)
            <?php
            $vat = $product->tax ? $product->tax->value : 22;
            $vat_calculate = ($vat / 100) + 1;
            $v_tax[$vat] = 0;

            $extra_list = \App\Models\ShopOrderProductExtra::where("shop_order_id", $product->pivot->order_id)->where("shop_product_id", $product->id)
                ->get()->pluck("value", "extra_id")->toArray();
            ?>
            <tr>
                <td class="small">
                    @if(trim($product->custom_1) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_1 }}; font-size: 10px; color:white; padding:3px;">{{ $product->custom_1 }}</label> @endif
                    @if(trim($product->custom_2) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_2 }}; font-size: 10px; color:white; padding:3px;">{{ $product->custom_2 }}</label> @endif
                    <br>

                    @if(env("PROJECT_NAME") == "Maison-Flaneur")
                        {{ $product->sku }}
                    @else
                        {{ $product->pivot->name }}
                    @endif

                    <strong>x {{ $product->pivot->quantity }}</strong>

                    @if($extra_list)
                        <br>
                        @foreach($extra_list as $extra_id => $value)
                            <?php
                            $extra = \App\Models\ShopExtra::find($extra_id);
                            ?>
                            {{ $extra->name }}<br>
                            <small>{{ $value }}</small>
                        @endforeach
                    @endif
                </td>
                <td class="text-right">{!! $symbol !!}
                    @php
                        if(env('CALCULATE_IVA') == 1){
                           echo number_format($product->pivot->price_with_tax,2, ',','.');
                        }else{
                            echo number_format($product->pivot->price,2, ',','.');
                        }
                    @endphp
                </td>
            </tr>
            @php
                $subTotal = $subTotal + $product->pivot->quantity * $product->pivot->price;
                $total = $total + $product->pivot->quantity * $product->pivot->price_with_tax;

                $v_tax[$vat] += $product->pivot->price_with_tax - $product->pivot->price;
            @endphp
        @endforeach
    @endif
    @php
        if(env('CALCULATE_IVA') == 1){
           $total = $total;
        }else{
           $total = $total/1.22;
        }
    @endphp

    @if(env('HIDE_TASSE') == 0)
        <tr>
            <th>{{ @$labels['shop-partials-tot-tasse-esc'] }}</th>
            <td class="text-right">{!! $symbol !!} <span id="total_no_tax">{{ number_format(round($subTotal, 2),2, ',','.') }}</span></td>
        </tr>

        @if($v_tax)
            @foreach($v_tax as $k=>$v)
                <tr>
                    <th>{{ @$labels['shop-checkout-tasse'] }} <small>{{ (int) $k }}%</small></th>
                    <td class="text-right">{!! $symbol !!} <span id="sum_tax">@php echo number_format(round($v,2),2, ',','.'); @endphp</span></td>
                </tr>
            @endforeach
        @endif
    @endif
    @if($order->code_coupon)
        <tr>
            <th>{{ @$labels['shop-partials-tot-coupon'] }} <small>{{ @$labels['shop-partials-iva-inc'] }}</small></th>
            <td class="text-right">{!! $symbol !!} <span id="total_no_tax">- {{ number_format(round(($order->total_coupon), 2),2, ',','.') }}</span></td>
        </tr>
        <tr>
            <th>{{ @$labels['shop-partials-tit-spedizione'] }}</th>
            <td class="text-right">{!! $symbol !!} <span id="total_no_tax">{{ number_format($order->total_shipping_tax,2, ',','.') }}</span></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th>{{ @$labels['shop-checkout-totale'] }}</th>
            <td class="text-right">{!! $symbol !!} <span id="total_view">{{ number_format((($order->total_tax - $order->total_coupon) + $order->total_shipping_tax + $order->total_extra),2, ',','.') }}</span></td>
        </tr>
    </tfoot>
    @else
        <tr>
            <th>{{ @$labels['shop-partials-tit-spedizione'] }}</th>
            <td class="text-right">{!! $symbol !!} <span id="total_no_tax">{{ number_format($order->total_shipping_tax,2, ',','.') }}</span></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th>{{ @$labels['shop-checkout-totale'] }}</th>
            <td class="text-right">{!! $symbol !!} <span id="total_view">{{ number_format(($order->total_tax + $order->total_extra + $order->total_shipping_tax),2, ',','.') }}</span></td>
        </tr>
    </tfoot>
    @endif
</table>
