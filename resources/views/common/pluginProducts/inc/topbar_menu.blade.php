<?php

$shopSetting = \App\Models\ShopSettings::first();

$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$menu_topbar = \App\Models\Page::where("is_in_topbar", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$shopSetting = \App\Models\ShopSettings::first();
?>

@if($menu_topbar)
<ul class="ul-menu">
    @foreach($menu_topbar as $item)
            <?php
            $target = $item->is_in_blank == 1 ? "_blank" : "";
            if(\Session::has('user_id') && ($item->slug == env("SLUG_LOGIN") || ($item->slug == env("SLUG_REGISTER")))){
                continue;
            }
            if($adminPlugin->version < 3){
                continue;
            }

            $view_button_cart = 1;
            if($shopSetting->visitors_buy == 0){
                if($item->slug == env("SLUG_CART") && \Session::has('user_id')){
                    $view_button_cart = 1;
                }else{
                    $view_button_cart = 0;
                }
            }

            $htmlLabel = $item->title;

            switch ($item->slug){
                case env("SLUG_CART"):
                    if($item->icon){
                        $htmlLabel = "<i class='$item->icon'></i>";
                    }else{
                        $htmlLabel = "<i class='fas fa-shopping-cart'></i>";
                    }
                    break;
                case env("SLUG_LOGIN"):
                    if($item->icon){
                        $htmlLabel = "<i class='$item->icon'></i>";
                    }else{
                        $htmlLabel = "<i class='fas fa-user'></i>";
                    }
                    break;
                case env("SLUG_REGISTER"):
                    if($item->icon){
                        $htmlLabel = "<i class='$item->icon'></i>";
                    }else{
                        $htmlLabel = "<i class='fas fa-user'></i>";
                    }
                    break;
                case env("SLUG_COMPARE"):
                    if($item->icon){
                        $htmlLabel = "<i class='$item->icon'></i>";
                    }else{
                        $htmlLabel = "<i class='fas fa-copy'></i>";
                    }
                    break;
            }
            ?>

           @if($item->slug == env("SLUG_CART") && $view_button_cart)
                <li>
                    <a class="position-relative d-block" href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}
                            <?php
                            $cart_class = new \App\Http\Controllers\CartController();
                            $cart_vet = $cart_class->loading_cart(true);
                            $qty_cart = 0;
                            if($cart_vet){
                                foreach ($cart_vet as $cart){
                                    $qty_cart = $qty_cart + $cart->qty;
                                }
                            }
                            ?>
                            @if($cart_vet == null)
                                    <span id="cart_box" class="badge badge-cart">0</span>
                            @else
                                    <span id="cart_box" class="badge badge-cart">{{ $qty_cart }}</span>
                            @endif
                    </a>
                </li>
            @else
                @if($item->slug != env("SLUG_CART") && $item->slug != env("SLUG_COMPARE"))
                        <li>
                            <a class="d-block" href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}</a>
                        </li>
                @endif
           @endif
@endforeach

    @if(\Session::has('user_id'))
     <li>
         <a href="/myarea/dashboard" class="badge badge-light">{{ @$labels['shop-area-riservata'] }}</a>
     </li>
    @endif
</ul>
@endif

