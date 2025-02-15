<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<div class="box_wishlist_{{ $itemProduct->id }} mt-3">
    @if(\Session::has("user_id"))
        @if($itemProduct->in_wishlist(\Session::get('user_id')))
            <button class="btn btn-outline-danger btn-block btn-sm" onclick="remove_wishlist({{ $itemProduct->id }})"><i class="far fa-heart-broken mr-1"></i><span class="text mx-2">{{ @$labels['shop-rimuovi-preferiti'] }}</span></button>
        @else
            <button class="btn btn-outline-primary btn-block btn-sm" onclick="add_wishlist({{ $itemProduct->id }})"><i class="far fa-heart mr-1"></i><span class="text mx-2">{{ @$labels['shop-aggiungi-preferiti'] }}</span></button>
        @endif
    @else
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{route('login')}}"><i class="far fa-heart mr-1"></i> {{ @$labels['shop-accedi-aggiungi-preferiti'] }}</a>
    @endif
</div>
<br>
