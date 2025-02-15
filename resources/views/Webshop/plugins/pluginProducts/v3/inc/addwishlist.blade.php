<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();  ?>
<div class="box_wishlist_{{ $itemProduct->id }} my-3">
    @if(\Session::has("user_id"))
        @if($itemProduct->in_wishlist(\Session::get('user_id')))
            <button class="btn btn-danger btn-sm" onclick="remove_wishlist({{ $itemProduct->id }})"><i class="far fa-heart-broken"></i> <span class="mx-1">{{ @$labels['shop-rimuovi-preferiti'] }}</span></button>
        @else
            <button class="btn btn-secondary btn-sm" onclick="add_wishlist({{ $itemProduct->id }})"><i class="far fa-heart"></i> <span class="mx-1">{{ @$labels['shop-aggiungi-preferiti'] }}</span></button>
        @endif
    @else
        <a class="btn btn-secondary btn-sm" href="{{route('login')}}" title="{{ @$labels['shop-accedi-aggiungi-preferiti'] }}"><i class="far fa-heart mr-1"></i> {{ @$labels['shop-accedi-aggiungi-preferiti'] }}</a>
    @endif
</div>
