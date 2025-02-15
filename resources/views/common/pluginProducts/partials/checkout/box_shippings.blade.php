<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<h5 class="mb-3">{{ @$labels['shop-partials-indirizzo-sped'] }}</h5>
@if(count($user->addresses))

    <div class="list-methods mb-3">
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
                <label class="method-item card flex-row py-2 px-3 active" for="shipping_address_{{ $address->id }}">
                    <div class="custom-control custom-radio mr-2">
                        <input type="radio" name="address_id" id="shipping_address_{{ $address->id }}" value="{{ $address->id }}" class="custom-control-input" {{ $selected }} onclick="get_info_for_method_shippings(this.value);">
                        <span class="custom-control-label d-inline-block">
                            <h6 class="font-weight-normal mb-1">{{ @$address->name }}</h6>
                            <div class="d-block text-capitalize small">
                                {{ @$address->address1 }} {{ @$address->number_street }}<br>
                                {{ @$address->postal_code }} {{ @$address->city }}
                                @if($address->county)
                                ({{ $address->county }})
                                @endif
                                {{ @$address->country->name }}
                                @if($address->comment)
                                    <br><small>{{ $address->comment }}</small>
                                @endif
                            </div>
                        </span>
                    </div>
                    <div class="ml-auto my-auto">
                        <button class="btn btn-sm btn-outline-primary" type="button" onclick="edit_address({{ $address->id }})"><i class="fas fa-edit"></i></button>
                        {{--<button  class="btn btn-sm btn-outline-primary" type="button" onclick="delete_address({{ $address->id }})"><i class="far fa-trash-alt"></i></button>--}}
                    </div>
                </label>
                <?php $i++; ?>
            @endforeach
        </div>
    </div>
@endif
