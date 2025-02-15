<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>
<h5 class="mb-3">{{ @$labels['shop-partials-mod-pag'] }}</h5>
@if($payments)
    <div class="list-methods">
        <div id="payment_method">
            @php $i = 0; @endphp
            @foreach ($payments as $payment)
                @php
                    $checked = '';
                    $active_class = '';
                    $class = 'is_not_contrassegno';

                    if($i == 0){
                        $checked = 'checked';
                        $active_class = 'active';
                    }
                    if($payment->is_contrassegno){
                        $class = 'is_contrassegno';
                    }
                    if($hasContrassegno == 0){
                        $class = '';
                    }

                    if($payment->name == "GiftCard"){
                        $class = 'gift_card';
                    }
                @endphp
                <label class="method-item card py-3 px-3 {{ $active_class }}" for="payment_id_{{ $i }}" @if($payment->name == "GiftCard") id="giftcard_payment" style="display: none;" @endif>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="payment_id" id="payment_id_{{ $i }}" value="{{ $payment->id }}" class="custom-control-input {{ $class }}" {{ $checked }} onchange="change_payment({{ $payment->id }})">
                        <span class="custom-control-label d-inline-block">{{ $payment->name }}</span>
                    </div>
                    <div class="method-description text-muted mt-2">{{ $payment->info }}</div>
                </label>
                @php $i++; @endphp
            @endforeach
        </div>
    </div>
@endif

