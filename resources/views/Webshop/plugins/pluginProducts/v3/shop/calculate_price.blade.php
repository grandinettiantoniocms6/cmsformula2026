@if($adminPlugin->version == 1)
    <div class="prices">
        {!! $symbol !!} {!! $p_temp->prezzo_semplice !!}
    </div>
@else
    @if($promo_price)
        <div class="prices">
            @if(env('VIEW_WITH_IVA') == 1)
                @if($start_price != $promo_price)
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price * $vat_calculate), 2, ",", ".") }}</ins>
                    <del class="old-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($start_price * $vat_calculate), 2, ",", ".") }}</del>
                @else
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price * $vat_calculate), 2, ",", ".") }}</ins>
                @endif
                @if($vat > 0)
                    <span class="vat">{{ @$labels['shop-label-iva-inclusa'] }} {{ (int) $vat }}%</span>
                @endif
            @else
                @if($start_price != $promo_price)
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price), 2, ",", ".") }}</ins>
                    <del class="old-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($start_price), 2, ",", ".") }}</del>
                @else
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price), 2, ",", ".") }}</ins>
                @endif
                <span class="vat">{{ @$labels['shop-label-iva-esclusa'] }}</span>
            @endif
        </div>
    @endif
@endif


