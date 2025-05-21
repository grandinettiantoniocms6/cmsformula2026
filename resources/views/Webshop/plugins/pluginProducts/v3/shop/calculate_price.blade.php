@if($adminPlugin->version == 1)
    <div class="prices">
        {!! $symbol !!} {!! $p_temp->prezzo_semplice !!}
    </div>
@else
    @if($promo_price)
        @if(env('VIEW_WITH_IVA') == 1)
            <div class="prices">
                @if($start_price != $promo_price)
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price * $vat_calculate), 2, ",", ".") }}</ins>
                    <del class="old-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($start_price * $vat_calculate), 2, ",", ".") }}</del>
                @else
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price * $vat_calculate), 2, ",", ".") }}</ins>
                @endif
            </div>
            @if($vat > 0)
                <span class="vat">{{ @$labels['shop-label-iva-inclusa'] }} {{ (int) $vat }}%</span>
            @endif
        @else
            <div class="prices">
                @if($start_price != $promo_price)
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price), 2, ",", ".") }}</ins>
                    <del class="old-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($start_price), 2, ",", ".") }}</del>
                @else
                    <ins class="new-price">{!! $symbol !!} {{ number_format($p_temp->clear_price_centesimi($promo_price), 2, ",", ".") }}</ins>
                @endif
            </div>
            <span class="vat">{{ @$labels['shop-label-iva-esclusa'] }}</span>
        @endif
    @endif
@endif


