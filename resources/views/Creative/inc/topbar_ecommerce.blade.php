<?php
  $plugin = \App\Models\PluginProductsSettings::first();
  $categories = \App\Models\PluginProductsCategories::where("is_active", 1)
        ->where("parent_id", null)
        ->where("is_purchasable", 1)
        ->orderBy("lft", "asc")
        ->get();

  $class = new \App\Http\Controllers\PluginProductsController();
  $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
  $categories = $class->get_categories_sidebar($categories);
?>

<?php
$menu_topbar = \App\Models\Page::where("is_in_search_bar", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$shopSetting = \App\Models\ShopSettings::first();
?>

@if($plugin->view_topbar_ecommerce)
    @if($plugin->topbar_background)
        <div class="topbar" style="background-color: {{ $plugin->topbar_background }}; ">
    @else
        <div class="topbar">
    @endif
        <div class="container-fluid">
            @if(session()->has('message-autocomplete'))
                <div class="row">
                    <div class="col-lg-3 mb-2 mb-lg-0">
                    </div>
                    <div class="col-lg-6 mb-2 mb-lg-0">
                        <div class="alert alert-success text-center">
                            <p>{{ @$labels['shop-alert-aggiunto-al-carrello'] }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-2 mb-lg-0">
                    </div>
                </div>
            @endif

                <style>

                    .dropdown-item:hover, .dropdown-item:active, .dropdown-item:visited { background: {{ $plugin->color_hover_autocomplete_topbar_ecommerce }};!important; }

                    #megasub2:hover, #megasub2:link, #megasub2:active { background: {{ $plugin->color_hover_autocomplete_topbar_ecommerce }};!important; }


                    .has-submenu:after { background: #f3e709;!important; }



                </style>

            <div class="row align-items-center">

                <div class="col-lg-3 mb-2 mb-lg-0 drop-categories">
                    @if($plugin->categories_topbar_ecommerce)
                        @if($categories)
                        <div class="dropdown dropdown-categories">
                            <button class="button btn-block" style="background-color: {{ $plugin->bg_btn_search_topbar_ecommerce }}; border-color: {{ $plugin->bg_btn_search_topbar_ecommerce }};" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-stream" style="color: {{ $plugin->txtcolor_btn_search_topbar_ecommerce }};"></i> <span style="color: {{ $plugin->txtcolor_btn_search_topbar_ecommerce }}; font-size: {{ $plugin->size_btn_search_topbar_ecommerce }};">{{ @$labels['shop-varie-categorie'] }}</span> <i class="fas fa-angle-down fa-indicator" style="color: {{ $plugin->txtcolor_btn_search_topbar_ecommerce }};"></i>
                            </button>
                            <ul class="dropdown-menu" style="background-color: {{ $plugin->bg_submenu_search_topbar_ecommerce }}; font-size: {{ $plugin->size_submenu_search_topbar_ecommerce }}; navbutton_up_hovered: #3bf311;!important; ">
                                @foreach($categories as $categoryItem)
                                    <?php $tot = 0; ?>
                                    @if(count($categoryItem->figli) > 0)
                                        @foreach($categoryItem->figli as $figlio)
                                           <?php $tot = $tot + $figlio->count;?>
                                        @endforeach

                                        <?php
                                        if($tot == 0){
                                            $tot = $tot + $categoryItem->count;
                                        }
                                        ?>
                                    @else
                                        <?php $tot = $tot + $categoryItem->count; ?>
                                    @endif

                                    @if($tot > 0)
                                        @if(count($categoryItem->figli) > 0)
                                                <li class="has-submenu">
                                                    <a class="dropdown-item" href="{{ route("pluginProducts.".\App::getLocale(), [$categoryItem->slug]) }}"><span style=".dropdown-item:hover:#000000;!important; color: {{ $plugin->txtcolor_submenu_search_topbar_ecommerce }}; font-size: {{ $plugin->size_submenu_search_topbar_ecommerce }};"> {{ $categoryItem->name }} <i class="fas fa-angle-right fa-indicator"></i></span></a>
                                                    <div class="megasubmenu dropdown-menu" style="background-color: {{ $plugin->bg_submenu_search_topbar_ecommerce }}; font-size: {{ $plugin->size_submenu_search_topbar_ecommerce }};">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <ul class="list-unstyled">
                                                                    @foreach($categoryItem->figli as $figlio)
                                                                        @if($figlio->count > 0)
                                                                            <li>
                                                                                <a href="{{ route("pluginProducts.".\App::getLocale(), [$figlio->slug]) }}">
                                                                                    <span id="megasub2" style="color: {{ $plugin->txtcolor_submenu_search_topbar_ecommerce }}; font-size: {{ $plugin->size_submenu_search_topbar_ecommerce }};">{{ $figlio->name }} </span>
                                                                                </a>
                                                                            </li>
                                                                         @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div><!-- end col-3 -->
                                                        </div><!-- end row -->
                                                    </div>
                                                </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="{{ route("pluginProducts.".\App::getLocale(), [$categoryItem->slug]) }}"><span style="color: {{ $plugin->txtcolor_submenu_search_topbar_ecommerce }}; font-size: {{ $plugin->size_submenu_search_topbar_ecommerce }};"> {{ $categoryItem->name }} </span></a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                   @endif
                </div>

                <div class="col-lg-5 search-bar">
                    @if($plugin->autocomplete_topbar_ecommerce)
                        @include("common.pluginProducts.inc.search")
                    @endif
                </div>
                <div class="col-lg-auto col-5 html-free mt-2 mt-lg-0">
                    @if($plugin->html_free_topbar_ecommerce)
                        {!! $plugin->html_free_topbar_ecommerce !!}
                    @endif
                </div>

                <div class="col-lg col-6 text-right mt-2 mt-lg-0 menu-topbar">
                    <ul>
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
                                    @if($item->slug != env("SLUG_CART"))
                                        <li>
                                            <a href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
