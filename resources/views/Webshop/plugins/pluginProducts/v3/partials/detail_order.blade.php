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
<table class="table table-fluid my-0">
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th>{{ @$labels['shop-partials-prodotto'] }}</th>
        <th></th>
        <th>{{ @$labels['shop-partials-qta'] }}</th>
        <th class="text-end">{{ @$labels['shop-partials-prezzo-unit'] }}</th>
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
                    <?php
                    $cover = $product->getCover();
                    ?>
                    @if($product->is_variant == 1)
                        <?php
                        $padre = \App\Models\PluginProducts::where("group_id", $product->group_id)->where("is_variant", 0)->first();
                        if($padre && $product->include_photo_padre == 1){
                            $coverPadre = $padre->getCover();
                            echo "<img width='50' class='card' src='$coverPadre'>";
                        }
                        ?>
                        <img width="50" class="card" src="{{ $cover }}" alt="{{ $product->pivot->name }}">
                    @else
                        <img width="50" class="card" src="{{ $cover }}" alt="{{ $product->pivot->name }}">
                    @endif
                </td>
                <td class="text-center d-none d-md-table-cell"></td>
                <td></td>
                <td data-column="Prodotto" data-fluid="100">
                    @if($product->pivot->custom_label_1 !== null && trim($product->pivot->custom_label_1) != "")
                        <label class="product-label">{{ $product->pivot->custom_label_1 }}</label>
                    @endif
                    @if($product->pivot->custom_label_2 !== null && trim($product->pivot->custom_label_2) != "")
                        <label class="product-label">{{ $product->pivot->custom_label_2 }}</label>
                    @endif
                    <h6>
                        @if(env("PROJECT_NAME") == "Maison-Flaneur")
                            {{ $product->pivot->sku }}
                        @else
                            {{ $product->pivot->name }}
                            <br>
                            <small><b>{{ @$labels['sku'] }}:</b> {{ $product->pivot->sku }}</small>
                        @endif
                    </h6>

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

                    @if($product->pivot->message)
                        <div class="extra">
                            <div><em>Messaggio:</em> {{ $product->pivot->message }}</div>
                        </div>
                    @endif

                    @if($product->pivot->file)
                        <div class="extra">
                            <div><em>File:</em> <a href="{{ url("uploads/{$product->pivot->file}") }}" target="_blank">Vedi</a> </div>
                        </div>
                    @endif
                </td>
                <td data-column="Q.tà" data-fluid="100">x {{ $product->pivot->quantity }}</td>
                <td data-column="Prezzo" class="text-end" data-fluid="100">{!! $symbol !!}
                        {{ $product->price }}
                </td>
            </tr>
            @php
                $subTotal = $subTotal + $product->pivot->quantity * $product->pivot->price;
                $total = $total + $product->pivot->quantity * $product->pivot->price_with_tax;

                $v_tax[$vat] += ($product->pivot->price_with_tax * $product->pivot->quantity) - ($product->pivot->price * $product->pivot->quantity);
            @endphp
        @endforeach
    @endif



    @if(env('HIDE_TASSE') == 0)
        <tr class="bg-light">
            <td colspan="5" class="text-end d-none d-md-table-cell">{{ @$labels['shop-partials-tot-tasse-esc'] }}</td>
            <td class="text-end" data-column="Totale (Tasse esc.)" data-fluid="100">{!! $symbol !!} {{ number_format($subTotal,2, ',','.') }}</td>
        </tr>

        <tr class="bg-light">
            <td colspan="5" class="text-end d-none d-md-table-cell">{{ @$labels['shop-partials-tot-spedizione-2'] }}
                @if(\Auth::user())
                    @if(\Auth::user()->type_client == 1)
                        {{ @$labels['shop-tasse-escl'] }}
                    @endif
                @endif
            </td>
            <td class="text-end" data-column="Spedizione" data-fluid="100">{!! $symbol !!}
                @if(\Auth::user())
                    @if(\Auth::user()->type_client == 1)
                        {{ number_format($order->total_shipping,2, ',','.') }}
                    @else
                        {{ number_format($order->total_shipping_tax,2, ',','.') }}
                    @endif
                @else
                    {{ number_format($order->total_shipping_tax,2, ',','.') }}
                @endif
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
                <tr class="bg-light">
                    <td colspan="5" class="text-end d-none d-md-table-cell">{{ @$labels['shop-partials-tasse-iva'] }} <small>{{ (int) $k }}%</small></td>
                    <td class="text-end" data-column="Tasse" data-fluid="100">{!! $symbol !!} {{ number_format(round($v, 2),2, ',','.') }}</td>
                </tr>
            @endforeach
        @endif
    @endif
    @if($order->code_coupon)
        <tr class="bg-light">
            <td colspan="5" class="text-end d-none d-md-table-cell">{{ @$labels['shop-partials-tot-coupon'] }}</td>
            <td class="text-end" data-column="Spedizione" data-fluid="100">- {!! $symbol !!} {{ number_format(round(($order->total_coupon), 2),2, ',','.') }}</td>
        </tr>
        <tr class="bg-light">
            <td colspan="5" class="text-end d-none d-md-table-cell"><span class="h4">{{ @$labels['shop-partials-totale'] }}</span></td>
            <td class="text-end" data-column="Totale" data-fluid="100"><span class="h4">{!! $symbol !!} {{ number_format((($order->total_tax - $order->total_coupon) + $order->total_shipping_tax + $order->total_extra),2, ',','.') }}</span></td>
        </tr>
    @else

        <tr class="bg-light">
            <td colspan="5" class="text-end d-none d-md-table-cell"><span class="h4">{{ @$labels['shop-partials-totale-2'] }}</span></td>
            <td class="text-end" data-column="Totale" data-fluid="100"><span class="h4">{!! $symbol !!} {{ number_format(($order->total_tax + $order->total_extra + $order->total_shipping_tax),2, ',','.') }}</span></td>
        </tr>
    @endif
    </tbody>
</table>
