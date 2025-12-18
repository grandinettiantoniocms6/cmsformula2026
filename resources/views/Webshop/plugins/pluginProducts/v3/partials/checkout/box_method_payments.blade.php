<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();  ?>
<h5 class="mb-3">{{ @$labels['shop-partials-mod-pag'] }}</h5>
@if($payments)
    <div id="payment_method">
        @php $i = 0; @endphp
        @foreach ($payments as $payment)
            @php
                if($payment->is_active == 0){
                    continue;
                }
                 $payment->total_min_cart_contrassegno = (float) $payment->total_min_cart_contrassegno;
                 $payment->total_max_cart_contrassegno = (float) $payment->total_max_cart_contrassegno;

                 $checked = '';
                 $active_class = '';
                 $class = 'is_not_contrassegno';

                 if($i == 0){
                     $checked = 'checked';
                     $active_class = 'active';
                 }
                 if($payment->is_contrassegno){
                     $class = '';
                     if($payment->total_min_cart_contrassegno >= 0 || $payment->total_max_cart_contrassegno >= 0){
                         if($tot >= $payment->total_min_cart_contrassegno && $tot <= $payment->total_max_cart_contrassegno){
                              $class = '';
                         }else{
                              continue;
                              $class = 'is_contrassegno';
                         }
                     }
                 }

                 if($hasContrassegno == 0){
                     $class = '';
                 }

                 if($payment->name == "GiftCard"){
                     $class = 'gift_card';
                 }
            @endphp
            <div class="form-check card-check">
                <input type="radio" name="payment_id" id="payment_id_{{ $i }}" value="{{ $payment->id }}" class="form-check-input {{ $class }}" {{ $checked }} onchange="change_payment({{ $payment->id }})">
                <label class="card card-body {{ $active_class }}" for="payment_id_{{ $i }}" @if($payment->name == "GiftCard") id="giftcard_payment" @endif>
                    <h6 class="mb-1">{{ $payment->name }}</h6>
                    <div class="text-muted font-sm">
                        {{ $payment->info }}

                        @if($payment->is_contrassegno)
                            @if($payment->total_min_cart_contrassegno > 0 || $payment->total_max_cart_contrassegno > 0)
                                <p>
                                    @if($payment->price_contrassegno)
                                        <strong>(&euro; {{ number_format($payment->price_contrassegno,2,",", ".") }})</strong>
                                    @endif
                                </p>
                            @endif
                        @endif
                    </div>
                </label>
            </div>


            @php $i++; @endphp
        @endforeach
    </div>
@endif

