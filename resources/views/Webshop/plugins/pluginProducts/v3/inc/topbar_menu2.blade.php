<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$menu_topbar = \App\Models\Page::where("is_in_topbar", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$shopSetting = \App\Models\ShopSettings::first();
?>

<a class="wishlist label-down link d-xs-show" href="#">
    <i class="w-icon-heart"></i>
</a>
<a class="compare label-down link d-xs-show" href="#">
    <i class="w-icon-compare"></i>
</a>

@if($menu_topbar)
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
                    $htmlLabel = "";
                    break;
                case env("SLUG_LOGIN"):
                    $htmlLabel = "<i class='w-icon-account'></i>";
                    break;
                case env("SLUG_REGISTER"):
                    $htmlLabel = "<i class='w-icon-account'></i>";
                    break;
            }
            ?>

           @if($item->slug == env("SLUG_CART") && $view_button_cart)

                    <a href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}
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
                            <div class="dropdown cart-dropdown mr-0 mr-lg-2">
                                <div class='cart-overlay'></div>
                                    <i class="w-icon-cart">
                                        <span id="cart_box" class="cart-count">0</span>
                                    </i>
                            </div>
                            @else
                            <div class="dropdown cart-dropdown mr-0 mr-lg-2">
                                <div class='cart-overlay'></div>
                                <i class="w-icon-cart">
                                    <span id="cart_box" class="cart-count">{{ $qty_cart }}</span>
                                </i>
                            </div>

                            @endif
                    </a>

            @else
                @if($item->slug != env("SLUG_CART"))

                            <a href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}</a>

                @endif
           @endif
@endforeach

    @if(\Session::has('user_id'))
         <a href="/myarea/dashboard">{{ @$labels['shop-area-riservata'] }}</a>
    @endif
@endif

