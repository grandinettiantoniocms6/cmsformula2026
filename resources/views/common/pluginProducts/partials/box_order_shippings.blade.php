<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>

<div class="card-step mb-3">
        <h5 class="mb-3">{{ @$labels['shop-partials-metodo-spedizione'] }}</h5>
        @if($shippings)
            <div class="list-methods">
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
                            <label class="method-item card py-2 px-3 active" for="shipping_id_{{ $j }}">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="shipping_id" data-index="{{ $j }}" id="shipping_id_{{ $j }}" value="{{ $temp[0] }}" {{ $checked }} onchange="change_shipping({{ $v }}, {{ $temp[0] }})">
                                    <span class="custom-control-label d-inline-block">{{ $temp[1] }} (€ {{ number_format($v,2, ',','.') }})</span>
                                </div>
                                <div class="method-description text-muted mt-2">{{ $itemShip->delay_description }}</div>
                            </label>
                        @php $j++; @endphp
                    @endif
                @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-danger"><i class="ti-alert mx-2"></i> {{ @$labels['shop-partials-non-disponibile'] }}</div>
        @endif
</div>
