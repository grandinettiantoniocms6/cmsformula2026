<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>
<div class="card-step">
    <h5>{{ @$labels['shop-partials-metodo-spedizione'] }}</h5>
    @if($shippings)
        <div id="shipping_method">
            @php $j = 0; @endphp
            @foreach ($shippings as $k=>$v)
                @php
                    $temp = explode('-', $k);
                    $checked = '';
                    if($j == 0){
                        $checked = 'checked';
                    }
                    $itemShip = \App\Models\Shipping::find($temp[0]);
                @endphp
                @if($itemShip)
                    <div class="form-check card-check">
                        <input class="form-check-input" type="radio" name="shipping_id" data-index="{{ $j }}" id="shipping_id_{{ $j }}" value="{{ $temp[0] }}" {{ $checked }} onchange="change_shipping({{ $v }}, {{ $temp[0] }})">
                        <label class="card card-body" for="shipping_id_{{ $j }}">
                            <h6 class="mb-1">{{ $temp[1] }} (€ {{ number_format($v,2, ',','.') }})</h6>
                            <div class="text-muted font-sm">{{ $itemShip->delay_description }}</div>
                        </label>
                    </div>
                    @php $j++; @endphp
                @endif
            @endforeach
        </div>
    @else
        <div class="alert alert-danger"><i class="ti-alert mx-2"></i> {{ @$labels['shop-partials-non-disponibile'] }}</div>
    @endif
</div>
