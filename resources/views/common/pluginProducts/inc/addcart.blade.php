<?php
    $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
@if($itemProduct->is_purchasable == 1)
    <div id="buy-block">
        @if(!$itemProduct->in_cart())
            <form method="post" action="{{ route('add.cart.product') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $itemProduct->id }}">

                <div class="form-group form-group-qty">
                    <label class="small text-uppercase">{{ @$labels['shop-qta'] }}</label>
                    <div class="input-group input-spinner">
                        <div class="input-group-append">
                            <button class="btn btn-default" type="button" id="button-minus" onclick="decreaseValue('#qty_{{ $itemProduct->id }}')"><i class="fas fa-minus"></i></button>
                        </div>
                        @if($itemProduct->stock_max)
                            <input type="text" class="form-control form-control-qty text-right" type="number" step="1" min="1" max="{{ $itemProduct->stock_max }}" name="quantity" value="1" id="qty_{{ $itemProduct->id }}">
                        @else
                            <input type="text" class="form-control form-control-qty text-right" type="number" step="1" min="1" max="{{ $itemProduct->stock }}" name="quantity" value="1" id="qty_{{ $itemProduct->id }}">
                        @endif
                        <div class="input-group-append">
                            <button class="btn btn-default" type="button" id="button-plus" onclick="increaseValue('#qty_{{ $itemProduct->id }}')"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <button id="addtocart" type="submit" name="addtocart" value="5" class="btn btn-lg btn-primary btn-block px-1 px-md-2" onclick="this.disabled=true;this.value='Aggiungendo...'; this.form.submit();"><span class="text">{{ @$labels['shop-add-to-cart'] }}</span></button>
            </form>
        @else
            <div class="form-group">
                <div class="alert alert-info text-center">
                    <i class="fa fa-check"></i>
                    <span class="d-block">{{ @$labels['shop-prod-nel-carrello'] }}</span>
                </div>
            </div>
            <a href="{{ route('cart') }}" class="btn btn-lg btn-outline-primary btn-block px-1 px-md-2"><span class="text">{{ @$labels['shop-edit-cart'] }}</span></a>
            <a class="btn btn-lg btn-primary btn-block" href="{{route('checkout')}}">{{ @$labels['shop-completa-acquisto'] }}</a>
        @endif
    </div>
    <br>
@endif

