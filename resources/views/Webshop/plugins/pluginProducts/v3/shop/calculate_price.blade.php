@if($adminPlugin->version == 1)
    <div class="prices">
        {!! $symbol !!} {!! $p_temp->prezzo_semplice !!}
    </div>
@else
    <?php
        $a_partire_da = 0;
        if(@$product){
            $obj = $product;
        }
        if(@$itemProduct){
            $obj = $itemProduct;
        }
        if(@$tempProduct){
            $obj = $tempProduct;
        }

        if($obj){
            if($obj->is_variant == 0){
                $figlio_first = \App\Models\PluginProducts::where("is_variant", 1)->where("group_id", $obj->group_id)
                    ->where("is_active", 1)
                    ->orderBy("price", "asc")
                    ->first();

                if($figlio_first){
                    $a_partire_da = 1;
                }
            }
        }
    ?>

    @if($a_partire_da && $figlio_first)
        <?php
            $vat = $figlio_first->tax ? $figlio_first->tax->value : 22;
            $vat_calculate = ($vat / 100) + 1;
            if(env('VIEW_WITH_IVA') == 1){
                $a_partire_da_price = $figlio_first->price * $vat_calculate;
            }else{
                $a_partire_da_price = $figlio_first->price;
            }
        ?>
        <ins class="new-price">A partire da {!! $symbol !!} {{ number_format($a_partire_da_price, 2, ",", ".") }}</ins>
        @if(env('VIEW_WITH_IVA') == 1)
            @if($vat > 0)
                <span class="vat">{{ @$labels['shop-label-iva-inclusa'] }} {{ (int) $vat }}%</span>
            @endif
        @else
            <span class="vat">{{ @$labels['shop-label-iva-esclusa'] }}</span>
        @endif
    @else
        @if($promo_price)
            @if(env('VIEW_WITH_IVA') == 1)
                <div class="prices">
                    @if($start_price != $promo_price)
                        <ins class="new-price">{!! $symbol !!} {{ number_format($promo_price * $vat_calculate, 2, ",", ".") }}</ins>
                        <del class="old-price">{!! $symbol !!} {{ number_format($start_price * $vat_calculate, 2, ",", ".") }}</del>
                    @else
                        <ins class="new-price">{!! $symbol !!} {{ number_format($promo_price * $vat_calculate, 2, ",", ".") }}</ins>
                    @endif
                </div>
                @if($vat > 0)
                    <span class="vat">{{ @$labels['shop-label-iva-inclusa'] }} {{ (int) $vat }}%</span>
                @endif
            @else
                <div class="prices">
                    @if($start_price != $promo_price)
                        <ins class="new-price">{!! $symbol !!} {{ number_format($promo_price, 2, ",", ".") }}</ins>
                        <del class="old-price">{!! $symbol !!} {{ number_format($start_price, 2, ",", ".") }}</del>
                    @else
                        <ins class="new-price">{!! $symbol !!} {{ number_format($promo_price, 2, ",", ".") }}</ins>
                    @endif
                </div>
                <span class="vat">{{ @$labels['shop-label-iva-esclusa'] }}</span>
            @endif
        @endif
    @endif


@endif
