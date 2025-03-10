<?php
$lang = \App::getLocale();
$lang_ = strtoupper($lang);
$shopSetting = \App\Models\ShopSettings::first();

?>
<ul class="navbar-nav" id="navbar-main">
    @if($menu)
        @foreach($menu as $item)
            <?php

            $view_button_shop = 1;
            if($shopSetting->visitors_buy == 0){
                if($item->slug == env("PLUGIN_PRODUCTS_URL_$lang_") && \Session::has('user_id')){
                    $view_button_shop = 1;
                }else{
                    $view_button_shop = 0;
                }
            }

            $megamenu = 0;
            if($item->slug == env("PLUGIN_PRODUCTS_URL_$lang_")){
                if($website->is_megamenu == 1){
                    $megamenu = 1;
                }

                if($view_button_shop == 0){
                    continue;
                }
            }
            $target = $item->is_in_blank == 1 ? "_blank" : "";

            ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">TEST</a>
                </li>

                <li class="nav-item dropdown">
                    <!-- Level one dropdown-->
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Menu Multilivello</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"> Dropdown item 1 </a></li>
                        <!-- Level two dropdown-->
                        <li class="has-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Dropdown item 2</a>
                            <ul class="dropdown-menu submenu">
                                <li><a class="dropdown-item" href="#">Submenu item 1</a></li>
                                <li><a class="dropdown-item" href="#">Submenu item 2</a></li>
                                <!-- Level three dropdown-->
                                <li class="has-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Submenu item 3</a>
                                    <ul class="dropdown-menu submenu">
                                        <li><a class="dropdown-item" href="#">Multi level 1</a></li>
                                        <li><a class="dropdown-item" href="#">Multi level 2</a></li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="#">Submenu item 4</a></li>
                                <li><a class="dropdown-item" href="#">Submenu item 5</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#"> Dropdown item 3 </a></li>
                        <li><a class="dropdown-item" href="#"> Dropdown item 4 </a></li>
                    </ul>
                </li>

            @if($item->slug != "/")
                @if(count($item->figli))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ $item->title }}</a>
                        <ul class="dropdown-menu" id="dropdown-menu-{{ $item->id }}">
                            @foreach($item->figli as $figli)
                                <?php $target = $figli->is_in_blank == 1 ? "_blank" : "";

                                    ?>
                                    @if($figli->figli)
                                        @if($figli->figli->isEmpty())
                                            <li><a class="dropdown-item" href="/{{ $figli->slug }}" target="{{ $target }}">{{ $figli->title }}</a></li>
                                        @else
                                            <li class="has-submenu level-1">
                                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ $figli->title }}</a>
                                                <ul class="dropdown-menu submenu" id="dropdown-menu-{{ $figli->id }}-lv1">
                                                    @foreach($figli->figli as $figli2)
                                                        <li><a class="dropdown-item" href="/{{ $figli2->slug }}" target="{{ $target }}">{{ $figli2->title }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                     @else
                                        <li><a class="dropdown-item" href="/{{ $figli->slug }}" target="{{ $target }}">{{ $figli->title }}</a></li>
                                     @endif
                            @endforeach
                        </ul>
                    </li>
                @else
                    @if($megamenu == 0)
                        <li class="nav-item">
                            <a class="nav-link" href="/{{ $item->slug }}" target="{{ $target }}">{{ $item->title }}</a>
                        </li>
                    @else
                        <?php
                        $plugin = \App\Models\PluginProductsSettings::first();
                        $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();

                        $categories = [];
                        $categories_search = \App\Models\PluginProductsCategoriesSearch::first();
                        if($categories_search){
                            $categories = json_decode($categories_search->categories, true);
                        }
                        ?>

                        <li class="nav-item dropdown has-megamenu">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ $item->title }}</a>
                            <div class="dropdown-menu dropdown-menu-end megamenu elements-{{ count($categories) }}" role="menu">
                                @if($categories)
                                    @foreach($categories as $categoryItem)
                                        <?php
                                        $tot = 0;
                                        $cat_slug = $categoryItem['slug'][\App::getLocale()];
                                        $cat_name = $categoryItem['name'][\App::getLocale()];
                                        ?>
                                        @if(count($categoryItem['figli']) > 0)
                                            @foreach($categoryItem['figli'] as $figlio)
                                                <?php $tot = $tot + $figlio['count'];?>
                                            @endforeach
                                        @else
                                            <?php $tot = $tot + $categoryItem['count']; ?>
                                        @endif

                                        @if($tot > 0)
                                            <div class="col-megamenu">
                                                <h6 class="menu-title dropdown-item"><a href="{{ route("pluginProducts.".\App::getLocale(), [$cat_slug]) }}">{{ $cat_name }}</a></h6>
                                                @if(count($categoryItem['figli']) > 0)
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($categoryItem['figli'] as $figlio)
                                                            <?php
                                                            $cat_slug = $figlio['slug'][\App::getLocale()];
                                                            $cat_name = $figlio['name'][\App::getLocale()];
                                                            ?>
                                                            @if($figlio['count'] > 0)
                                                                <li><a class="dropdown-item" href="{{ route("pluginProducts.".\App::getLocale(), [$cat_slug]) }}">{{ $cat_name }}</a></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>  <!-- col-megamenu.// -->
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </li>

                        {{--PER KEIVAN--}}

                            <li class="nav-item dropdown">
                                <!-- Level one dropdown-->
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Menu Multilivello</a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"> Dropdown item 1 </a></li>
                                    <!-- Level two dropdown-->
                                    <li class="has-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Dropdown item 2</a>
                                        <ul class="dropdown-menu submenu">
                                            <li><a class="dropdown-item" href="#">Submenu item 1</a></li>
                                            <li><a class="dropdown-item" href="#">Submenu item 2</a></li>
                                            <!-- Level three dropdown-->
                                            <li class="has-submenu">
                                                <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Submenu item 3</a>
                                                <ul class="dropdown-menu submenu">
                                                    <li><a class="dropdown-item" href="#">Multi level 1</a></li>
                                                    <li><a class="dropdown-item" href="#">Multi level 2</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item" href="#">Submenu item 4</a></li>
                                            <li><a class="dropdown-item" href="#">Submenu item 5</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="#"> Dropdown item 3 </a></li>
                                    <li><a class="dropdown-item" href="#"> Dropdown item 4 </a></li>
                                </ul>
                            </li>
                    @endif
                @endif
            @else
                <li class="nav-item">
                    <a class="nav-link" href="/">{{ $item->title }}</a>
                </li>
            @endif
        @endforeach


    @endif

    @include('Webshop.inc.switch_lang')
</ul>
