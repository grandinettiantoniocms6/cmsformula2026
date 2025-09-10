<?php
  $plugin = \App\Models\PluginProductsSettings::first();
  $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();

  $categories = [];
  $categories_search = \App\Models\PluginProductsCategoriesSearch::first();
  if($categories_search){
      $categories = json_decode($categories_search->categories, true);
  }
?>

<?php
$menu_topbar = \App\Models\Page::where("is_in_search_bar", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->first();
$shopSetting = \App\Models\ShopSettings::first();
?>

@if($plugin->view_topbar_ecommerce && $adminPlugin)
    <div id="topbar-ecommerce">
        <div class="container-fluid">
            @if(session()->has('message-autocomplete'))
                <div class="row">
                    <div class="col-lg-3 mb-2 mb-lg-0"></div>
                    <div class="col-lg-6 mb-2 mb-lg-0">
                        <div class="alert alert-success text-center">
                            <p>{{ @$labels['shop-alert-aggiunto-al-carrello'] }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-2 mb-lg-0"></div>
                </div>
            @endif

            <div class="row align-items-center gx-2">
                <div class="col-auto col-lg-3 drop-categories">
                    @if($plugin->categories_topbar_ecommerce)
                        @if($categories)
                            <div class="dropdown category-dropdown">
                                <button type="button" class="category-toggle" role="button" id="dropdown-box-btn" data-toggle="show" data-target="#dropdown-box" title="{{ @$labels['shop-varie-categorie'] }}">
                                    <svg viewBox="0 0 100 80" width="16" height="16">
                                        <rect width="100" height="10"></rect>
                                        <rect y="30" width="100" height="10"></rect>
                                        <rect y="60" width="50" height="10"></rect>
                                    </svg>
                                    <span>{{ @$labels['shop-varie-categorie'] }}</span>
                                </button>
                                <div class="dropdown-box" id="dropdown-box">
                                    <ul class="menu vertical-menu category-menu">
                                        @if($categories)
                                            @foreach($categories as $categoryItem)
                                                <?php
                                                $cat_slug = null;
                                                $tot = 0;
                                                if(key_exists(\App::getLocale(), $categoryItem['slug'])){
                                                    $cat_slug = $categoryItem['slug'][\App::getLocale()];
                                                }

                                                $cat_name = null;
                                                if(key_exists(\App::getLocale(), $categoryItem['name'])){
                                                    $cat_name = $categoryItem['name'][\App::getLocale()];
                                                }

                                                ?>
                                                @if(count($categoryItem['figli']) > 0)
                                                    @foreach($categoryItem['figli'] as $figlio)
                                                        <?php $tot = $tot + $figlio['count'];?>
                                                    @endforeach
                                                @else
                                                        <?php $tot = $tot + $categoryItem['count']; ?>
                                                @endif
                                                @if($tot > 0)
                                                    @if(count($categoryItem['figli']) > 0)
                                                        <li class="has-submenu">
                                                            <a href="{{ route("pluginProducts.".\App::getLocale(), [$cat_slug]) }}">{{ $cat_name }}</a>
                                                            <ul class="megamenu columns-1">
                                                                @foreach($categoryItem['figli'] as $figlio)
                                                                    <?php
                                                                    $cat_slug = null;
                                                                    if(key_exists(\App::getLocale(), $figlio['slug'])){
                                                                        $cat_slug = $figlio['slug'][\App::getLocale()];
                                                                    }

                                                                        $cat_name = null;
                                                                    if(key_exists(\App::getLocale(), $figlio['name'])){
                                                                        $cat_name = $figlio['name'][\App::getLocale()];
                                                                    }
                                                                    ?>
                                                                    @if($figlio['count'] > 0 && $cat_slug && $cat_name)
                                                                        <li><a class="dropdown-item" href="{{ route("pluginProducts.".\App::getLocale(), [$cat_slug]) }}">{{ $cat_name }}</a></li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                        @if($cat_slug && $cat_name)
                                                            <li><a href="{{ route("pluginProducts.".\App::getLocale(), [$cat_slug]) }}">{{ $cat_name }}</a></li>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="dropdown-box-backdrop" data-toggle="show" data-target="#dropdown-box"></div>
                            </div>
                        @endif
                    @endif
                </div>

                @if($plugin->html_free_topbar_ecommerce)
                    <div class="col-lg search-bar my-lg-0 my-1">
                        @if($plugin->autocomplete_topbar_ecommerce)
                            @include("$thema.plugins.pluginProducts.v3.inc.search_top")
                        @endif
                    </div>
                    <div class="col-lg-auto col html-free my-lg-0 my-1">
                        {!! $plugin->html_free_topbar_ecommerce !!}
                    </div>
                    @if($menu_topbar)
                        @if(!$menu_topbar->isEmpty())
                            <div class="col-auto col-lg-auto menu-topbar my-lg-0 my-1">
                                <ul class="nav nav-cart nav-cart-1">
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
                                                    $htmlLabel = "<i class='$item->icon' data-bs-toggle='tooltip' data-bs-title='Carrello'></i>";
                                                }else{
                                                    $htmlLabel = "<i class='bi bi-bag-fill' data-bs-toggle='tooltip' data-bs-title='Carrello'></i>";
                                                }
                                                break;
                                            case env("SLUG_LOGIN"):
                                                if($item->icon){
                                                    $htmlLabel = "<i class='$item->icon' data-bs-toggle='tooltip' data-bs-title='Accedi'></i>";
                                                }else{
                                                    $htmlLabel = "<i class='bi bi-person-fill' data-bs-toggle='tooltip' data-bs-title='Accedi'></i>";
                                                }
                                                break;
                                            case env("SLUG_COMPARE"):
                                                if($item->icon){
                                                    $htmlLabel = "<i class='$item->icon' data-bs-toggle='tooltip' data-bs-title='Compara'></i>";
                                                }else{
                                                    $htmlLabel = "<i class='bi bi-files' data-bs-toggle='tooltip' data-bs-title='Compara'></i>";
                                                }
                                                break;
                                        }
                                        ?>

                                        @if($item->slug == env("SLUG_CART") && $view_button_cart)
                                            <li class="nav-item">
                                                <a class="nav-link position-relative" href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}
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
                                                <li class="nav-item">
                                                    <a class="nav-link" href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="col-lg col search-bar my-lg-0 my-1">
                        @if($plugin->autocomplete_topbar_ecommerce)
                            @include("$thema.plugins.pluginProducts.v3.inc.search_top")
                        @endif
                    </div>
                    @if($menu_topbar)
                        @if(!$menu_topbar->isEmpty())
                            <div class="col-auto col-lg-auto menu-topbar my-lg-0 my-1">
                                <ul class="nav nav-cart nav-cart-2">
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
                                                    $htmlLabel = "<i class='$item->icon' data-bs-toggle='tooltip' data-bs-title='Carrello'></i>";
                                                }else{
                                                    $htmlLabel = "<i class='bi bi-bag-fill' data-bs-toggle='tooltip' data-bs-title='Carrello'></i>";
                                                }
                                                break;
                                            case env("SLUG_LOGIN"):
                                                if($item->icon){
                                                    $htmlLabel = "<i class='$item->icon' data-bs-toggle='tooltip' data-bs-title='Accedi'></i>";
                                                }else{
                                                    $htmlLabel = "<i class='bi bi-person-fill' data-bs-toggle='tooltip' data-bs-title='Accedi'></i>";
                                                }
                                                break;
                                            case env("SLUG_COMPARE"):
                                                if($item->icon){
                                                    $htmlLabel = "<i class='$item->icon' data-bs-toggle='tooltip' data-bs-title='Compara'></i>";
                                                }else{
                                                    $htmlLabel = "<i class='bi bi-files' data-bs-toggle='tooltip' data-bs-title='Compara'></i>";
                                                }
                                                break;
                                        }
                                        ?>

                                        @if($item->slug == env("SLUG_CART") && $view_button_cart)
                                            <li class="nav-item">
                                                <a class="nav-link position-relative" href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}
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
                                                <li class="nav-item"><a class="nav-link" href="/{{ $item->slug }}" target="{{ $target }}">{!! $htmlLabel !!}</a></li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
@endif
