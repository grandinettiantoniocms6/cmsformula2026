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
                        $categories = \App\Models\PluginProductsCategories::where("is_active", 1)
                            ->where("parent_id", null)
                            ->where("is_purchasable", 1)
                            ->orderBy("lft", "asc")
                            ->get();

                        $class = new \App\Http\Controllers\PluginProductsController();
                        $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
                        $categories = $class->get_categories_sidebar($categories);
                        ?>

                        <li class="nav-item dropdown has-megamenu">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ $item->title }}</a>
                            <div class="dropdown-menu dropdown-menu-end megamenu elements-{{ count($categories) }}" role="menu">
                                @if($categories)
                                    @foreach($categories as $categoryItem)
                                        <?php $tot = 0; ?>
                                        @if(count($categoryItem->figli) > 0)
                                            @foreach($categoryItem->figli as $figlio)
                                                <?php $tot = $tot + $figlio->count;?>
                                            @endforeach
                                        @else
                                            <?php $tot = $tot + $categoryItem->count; ?>
                                        @endif

                                        @if($tot > 0)
                                            <div class="col-megamenu">
                                                <h6 class="menu-title dropdown-item"><a href="{{ route("pluginProducts.".\App::getLocale(), [$categoryItem->slug]) }}">{{ $categoryItem->name }}</a></h6>
                                                @if(count($categoryItem->figli) > 0)
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($categoryItem->figli as $figlio)
                                                            @if($figlio->count > 0)
                                                                <li><a class="dropdown-item" href="{{ route("pluginProducts.".\App::getLocale(), [$figlio->slug]) }}">{{ $figlio->name }}</a></li>
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
