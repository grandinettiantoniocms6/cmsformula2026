<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>
<h5 class="mb-3">{{ @$labels['shop-partials-met-sped'] }}</h5>
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
                @if($advice_special > 0 && count($shippings) != $advice_special)
                    @if($itemShip->is_special == 1)
                        <label class="method-item card py-2 px-3 active" for="shipping_id_{{ $j }}">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="shipping_id" data-index="{{ $j }}" id="shipping_id_{{ $j }}" value="{{ $temp[0] }}" disabled>
                                <span class="custom-control-label d-inline-block">{{ $temp[1] }} @if($v > 0)(€ {{ number_format($v,2, ',','.') }})@endif</span>
                            </div>
                            <div class="text-muted mt-2">{{ $itemShip->delay_description }}
                                <br>
                                <span class="text-danger">{{ @$labels['shop-partials-pronta-consegna-1'] }}</span>
                            </div>
                        </label>
                    @else
                        <label class="method-item card py-2 px-3 active" for="shipping_id_{{ $j }}">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="shipping_id" data-index="{{ $j }}" id="shipping_id_{{ $j }}" value="{{ $temp[0] }}" {{ $checked }} onchange="change_shipping({{ $v }}, {{ $temp[0] }})">
                                <span class="custom-control-label d-inline-block">{{ $temp[1] }} @if($v > 0)(€ {{ number_format($v,2, ',','.') }})@endif</span>
                            </div>
                            <div class="method-description text-muted mt-2">{{ $itemShip->delay_description }}</div>
                        </label>
                    @endif
                @else
                    <label class="method-item card py-2 px-3 active" for="shipping_id_{{ $j }}">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="shipping_id" data-index="{{ $j }}" id="shipping_id_{{ $j }}" value="{{ $temp[0] }}" {{ $checked }} onchange="change_shipping({{ $v }}, {{ $temp[0] }})">
                            <span class="custom-control-label d-inline-block">{{ $temp[1] }} @if($v > 0)(€ {{ number_format($v,2, ',','.') }})@endif</span>
                        </div>
                        <div class="method-description text-muted mt-2">{{ $itemShip->delay_description }}</div>
                    </label>
                @endif

                @php $j++; @endphp
            @endif
        @endforeach
    </div>
@else
    <div class="alert alert-danger">{{ @$labels['shop-partials-no-spedizione'] }} <strong>{{ env('PROJECT_SUPPORT_EMAIL') }}</strong></div>
@endif
