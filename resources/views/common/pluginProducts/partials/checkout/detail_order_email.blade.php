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

<table border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica; text-align: left!important; background:#ffffff; max-width:100%; min-width:100%;" width="80%" class="mcnTextContentContainer order">
    <thead>
    <tr>
        <th width="10%"></th>
        <th>
            <strong>{{ @$labels['shop-partials-prodotto'] }}</strong>
        </th>
        <th style="text-align: center!important"><strong>{{ @$labels['shop-partials-prezzo'] }}</strong></th>
    </tr>
    </thead>
    <tbody>
    @if($order->products)
        <?php $subTotal = 0; ?>
        <?php $total = 0; ?>
        @foreach($order->products as $product)
            <?php
            $extra_list = \App\Models\ShopOrderProductExtra::where("shop_order_id", $product->pivot->order_id)->where("shop_product_id", $product->id)
                ->get()->pluck("value", "extra_id")->toArray();
            ?>
            <tr>
                <td style="text-align: center!important;">
                    <?php
                    $cover = url('uploads/no-image.jpg');

                    if(env("LOCAL") == 0){
                        $check = \App\Models\PluginProductsImages::where("product_id", $product->id)->orderBy("order", "asc")->first();
                        if($check){
                            if(is_numeric(strpos($check->image, "uploads"))){
                                $cover = url($check->image);
                            }else{
                                $cover = url("uploads/products/$check->image");
                            }
                        }
                    }
                    ?>

                    @if($product->is_variant == 1)
                        <?php
                        $padre = \App\Models\PluginProducts::where("group_id", $product->group_id)->where("is_variant", 0)->first();
                        if($padre && $product->include_photo_padre == 1){
                            $coverPadre = $padre->getCover();
                            echo "<img width='80' class='card' src='$coverPadre'>";
                        }
                        ?>
                        <img width="80" class="card" src="{{ $cover }}" alt="">
                    @else
                        <img width="80" class="card" src="{{ $cover }}" alt="">
                    @endif
                </td>
                <td>
                        @if(env("PROJECT_NAME") == "Maison-Flaneur")
                            <strong style="font-size: 15px"> {{ $product->pivot->sku }}</strong>
                        @else
                             <strong style="font-size: 13px">{{ $product->pivot->name }} </strong>
                            <br>
                            <small><b>{{ @$labels['sku'] }}:</b> {{ $product->pivot->sku }}</small>
                            <br>
                            @if($product->pivot->custom_label_1)
                                <small>{{ $product->pivot->custom_label_1 }}</small>
                            @endif
                            @if($product->pivot->custom_label_2)
                                <small>{{ $product->pivot->custom_label_2 }}</small>
                            @endif
                        @endif

                        <br/><strong>x {{ $product->pivot->quantity }}</strong> <small>
                        @if(env('VIEW_WITH_IVA') == 1)
                            <?php
                                    $temp_price = number_format($product->pivot->price_with_tax,3, ',','.');
                                    $strlen = strlen($temp_price);
                                    $price_prod = $temp_price[$strlen-1] == "0" ? number_format($product->pivot->price_with_tax,2, ',','.') : number_format($product->pivot->price_with_tax,3, ',','.');
                            ?>

                            ({!! $symbol !!} {{ $price_prod }})
                        @else
                                    <?php
                                    $temp_price = number_format($product->pivot->price,3, ',','.');
                                    $strlen = strlen($temp_price);
                                    $price_prod =  $temp_price[$strlen-1] == "0" ? number_format($product->pivot->price,2, ',','.') : number_format($product->pivot->price,3, ',','.');
                                    ?>

                            ({!! $symbol !!} {{ number_format((float) $price_prod,3, ',','.') }})
                        @endif


                        </small>

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
                            <br><br>
                            <div><em>Messaggio:</em> {{ $product->pivot->message }}</div>
                        @endif

                        @if($product->pivot->file)
                            <br>
                            <div><em>File:</em> <a href="{{ url("uploads/{$product->pivot->file}") }}" target="_blank">Vedi</a> </div>
                        @endif

                    @if($product->pivot->is_gift == 1)
                        <br>
                        <i class="fa fa-gift"></i>
                        @if(@$product->pivot->message)
                            @if(trim($product->pivot->message) != "")
                                <small>{{ $product->pivot->message }}</small>
                            @endif
                        @endif
                    @endif
                </td>
                <td style="text-align: center!important"><span class="h4">{!! $symbol !!}
                        @if(env('VIEW_WITH_IVA') == 1)
                            {{ number_format($product->pivot->quantity * $product->pivot->price_with_tax,2,",", ".") }}
                        @else
                            {{ number_format($product->pivot->quantity * $product->pivot->price,2,",", ".") }}
                        @endif
                    </span></td>
            </tr>
            <?php $subTotal = $subTotal + $product->pivot->quantity * $product->pivot->price; ?>
            <?php $total = $total + $product->pivot->quantity * $product->pivot->price_with_tax; ?>
        @endforeach
    @endif
    @if(env('PROJECT_NAME') != "Maison-Flaneur")
    <tr>
        <td></td>
        <td style="text-align: right!important"><strong>{{ @$labels['shop-partials-totale-prodotti'] }}</strong></td>
        <td style="text-align: center!important">{!! $symbol !!} <?php echo number_format($total,2, ',','.'); ?><br/><small>{{ @$labels['shop-partials-iva-inc'] }}</small></td>
    </tr>
    @endif
    @if($order->code_coupon)
        <tr class="active">
            <td></td>
            <td style="text-align: right!important"><strong>{{ @$labels['shop-partials-tot-coupon'] }}</strong></td>
            <td style="text-align: center!important"><strong>{!! $symbol !!} <?php echo number_format(round(($order->total_tax - $order->total_coupon), 2),2, ',','.'); ?></strong></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right!important"><strong>{{ @$labels['shop-partials-tit-spedizione'] }}</strong></td>
            <td style="text-align: center!important"><span class="h4">{!! $symbol !!} <?php echo number_format($order->total_shipping_tax,2, ',','.'); ?></span></td>
        </tr>

        <tr class="active">
            <td></td>
            <td style="text-align: right!important"><strong>{{ @$labels['shop-partials-tit-totale'] }}</strong></td>
            <td style="text-align: center!important"><strong>{!! $symbol !!} <?php echo number_format((($order->total_tax - $order->total_coupon) + $order->total_shipping_tax + $order->total_extra),2, ',','.');?></strong></td>
        </tr>
    @else
        <tr>
            <td></td>
            <td style="text-align: right!important"><strong>{{ @$labels['shop-partials-tit-spedizione'] }}</strong></td>
            <td style="text-align: center!important"><span class="h4">{!! $symbol !!} <?php echo number_format($order->total_shipping_tax,2, ',','.'); ?></span></td>
        </tr>

        <tr class="active">
            <td></td>
            <td style="text-align: right!important"><strong>{{ @$labels['shop-partials-tit-totale'] }}</strong></td>
            <td style="text-align: center!important"><strong>{!! $symbol !!} <?php echo number_format(($order->total_tax + $order->total_extra + $order->total_shipping_tax),2, ',','.');?></strong></td>
        </tr>
    @endif

    </tbody>
</table>
