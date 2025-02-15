<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>
<h5 class="mb-3">{{ @$labels['shop-partials-indirizzo-sped'] }}</h5>
@if(count($user->addresses))
    <div id="shipping_address">
        <?php $i = 0; ?>
        @foreach ($user->addresses as $address)
            @php
                $selected = '';

                if($i == 0 && $id == 0){
                      $selected = 'checked';
                }else{
                    if($id == $address->id){
                        $selected = 'checked';
                    }
                }
            @endphp

            <div class="form-check card-check">
                <input type="radio" name="address_id" id="shipping_address_{{ $address->id }}" value="{{ $address->id }}" class="form-check-input" {{ $selected }} onclick="get_info_for_method_shippings(this.value);">
                <label class="card card-body" for="shipping_address_{{ $address->id }}">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ @$address->name }}</h6>
                        <div class="text-muted font-sm">
                            <div>{{ @$address->address1 }} {{ @$address->number_street }}</div>
                            <div>{{ @$address->postal_code }} {{ @$address->city }} @if($address->county) ({{ $address->county }}) @endif {{ @$address->country->name }}</div>
                            @if($address->comment)
                                <div>{{ $address->comment }}</div>
                            @endif
                        </div>
                    </div>
                    <button class="btn btn-secondary btn-circle" type="button" onclick="edit_address({{ $address->id }})"><i class="fas fa-edit"></i></button>
                </label>
            </div>
            <?php $i++; ?>
        @endforeach
    </div>
@endif
