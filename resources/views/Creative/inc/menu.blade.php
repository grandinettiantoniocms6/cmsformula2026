<?php
$lang = \App::getLocale();
$lang_ = strtoupper($lang);
$shopSetting = \App\Models\ShopSettings::first();
?>
<ul class="navbar-nav">
    <!-- logo sul mobile menu -->
    <li class="d-block d-lg-none">
        <div class="logo">
            <a href="/">
                @if($website->logo)
                    <img src="{{ url($website->logo) }}" alt="">
                @else
                    {{ $website->title }}
                @endif
            </a>
        </div>
    </li>
    <!-- logo sul mobile menu -->

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
            if($item->slug == env("PLUGIN_PRODUCTS_URL_$lang_")){
                if($view_button_shop == 0){
                    continue;
                }
            }
            $target = $item->is_in_blank == 1 ? "_blank" : "";
            ?>

            <!-- il <li> seguente è quello che crea il top menu ma non va messa nessuna classe -->

            <li class="nav-item dropdown">
                <!-- se però ha figli cambia e metto le classi o al tag a o al tag li  -->
                @if($item->slug != "/")
                    @if(count($item->figli))

                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <!-- se non ha figli niente dropdown-->
                            @else
                                <a class="nav-link" href="/{{ $item->slug }}" target="{{ $target }}">
                                    @endif
                                    <!-- se è il tasto home -->
                                    @else
                                        <a class="nav-link" href="/">
                                            @endif
                                            {{ $item->title }}
                                            <!-- Se la voce di menu ha figli metti arrow -->
                                            @if(count($item->figli))
                                                <!--<i class="fas fa-angle-down fa-indicator"></i> -->
                                            @endif
                                        </a>
                                        <!-- sotto menu per ogni voce -->
                                        @if(count($item->figli))
                                            <ul class="dropdown-menu">
                                                @foreach($item->figli as $figli)
                                                    <?php
                                                    $target = $figli->is_in_blank == 1 ? "_blank" : "";
                                                    ?>
                                                    <li>
                                                        <a class="dropdown-item" href="/{{ $figli->slug }}" target="{{ $target }}"><span>{{ $figli->title }}</span></a>
                                                    </li>
                                                @endforeach
                                            </ul>
                    @endif
            </li>
        @endforeach
    @endif

    @include('Creative.inc.switch_lang')
</ul>
