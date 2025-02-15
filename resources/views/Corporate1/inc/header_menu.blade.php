<!-- header area -->
<header class="header" id="header">
    @if($website->topbar_active == 1 && (env('TOPBAR')) )

    <!-- header top -->
    <div class="header-top" style="background-color: {{ $website->topbar_background }}!important; color: {{ $website->color_icon_topbar }}!important;">
        <div class="container">
            <div class="header-top-wrap">
                <div class="header-top-left">
                    <div class="header-top-list">
                        <ul>
                            @if($website->topbar_contact_mobile)
                                <li>
                                    <i class="{{ $website->icon_topbar2 }} {{ $website->sizeicon }}"></i>
                                        <span style="color: {{ $website->color_txt_topbar }}!important;"></span>
                                    <a style="color: {{ $website->color_txt_topbar }}!important;
                                        font-size: {{ $website->font_size_topbar }};" href="tel:{{ $website->topbar_contact_mobile }}">&nbsp; {{ $website->topbar_contact_mobile }}
                                    </a>
                                </li>
                            @endif
                            @if($website->topbar_contact_email)
                                <li>
                                    <span><i class="{{ $website->icon_topbar1 }} {{ $website->sizeicon }}"></i>
                                        <span style="color: {{ $website->color_txt_topbar }}!important; font-size: {{ $website->font_size_topbar }};">
                                            <a href="mailto:{{ $website->topbar_contact_email }}">&nbsp; {{ $website->topbar_contact_email }}</a>
                                        </span>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="header-top-right">
                    <div class="header-top-lang">

                        <?php
                        $adminLang = \App\Models\AdminLanguage::where("is_active", 1)->where("is_frontend", 1)
                            ->orderBy("lft", "asc")
                            ->get()->pluck("label", "name")->toArray();
                        ?>
                        @if(count($adminLang) > 1)

                        <div class="dropdown">
                            <a href="#" class="top-lang dropdown-toggle" data-bs-toggle="dropdown" style="color: {{ $website->color_icon_topbar }}!important;">
                                <i style="color: {{ $website->color_icon_topbar }}!important;" class="fal fa-globe"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach ($adminLang as $lang => $language)
                                    @if ($lang != App::getLocale())
                                        <li>
                                            <a title="{{ $lang }}" href="{{ route('lang.switch', $lang) }}"><img style="min-width: 36px; border-radius: 10px; padding: 7px;" width="22px" height="16px" src="{{ url("img/$lang.svg") }}" alt="{{ $lang }}"></a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    <?php $socials = json_decode($website->socials, true); ?>
                    @if($socials)
                    <div class="header-top-social">
                        @foreach($socials as $social)
                            <a href="{{ $social['url'] }}" target="_blank">
                                @if($social['icon'])
                                    <i class="{{ $social['icon'] }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }}!important;"></i>
                                @else
                                    {{ $social['name'] }}
                                @endif
                            </a>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- header top end -->
    @endif

    @if($website->is_online == 0 && backpack_user() && !is_numeric(strpos(env('APP_URL'), "stage")))
        <div id="offline" class="container-fluid bg-danger text-white text-center"><strong>Il sito è in modalità Offline.</strong> Avviso solo per gli amministratori. </div>
    @endif

        <!-- navbar -->
        <div class="main-navigation">
            <!-- NAVBAR + header fixed -->
            @if($website->is_topbar_fixed_desktop == 1)
            <nav class="navbar navbar-expand-lg fixed-top" style="background-color: {{ $website->header_background }}!important; height: {{ $website->menubar_height }}!important;">
            @else
            <nav class="navbar navbar-expand-lg" style="background-color: {{ $website->header_background }}!important; height: {{ $website->menubar_height }}!important;">
            @endif

                <div class="container position-relative">

                    <a class="navbar-brand" href="/">

                        @if($website->logo)
                                <?php
                                if(env('LOCAL') == 0){
                                    list($width, $height, $type, $attr) = getimagesize("$website->logo");
                                }
                                ?>
                            <img src="{{ url($website->logo) }}" class="default-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>

                        @else
                            {{ $website->title }}
                        @endif

                    </a>

                    <div class="mobile-menu-right">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span style="border-bottom: 2px solid; color:{{ $website->bgcolor_menu_mobile }}!important;"></span>
                            <span style="border-bottom: 2px solid; color:{{ $website->bgcolor_menu_mobile }}!important;"></span>
                            <span style="border-bottom: 2px solid; color:{{ $website->bgcolor_menu_mobile }}!important;"></span>
                        </button>
                    </div>

                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <a href="/" class="offcanvas-brand" id="offcanvasNavbarLabel">

                                @if($website->logo2)
                                        <?php
                                        if(env('LOCAL') == 0){
                                            list($width, $height, $type, $attr) = getimagesize("$website->logo2");
                                        }
                                        ?>
                                    <img src="{{ url($website->logo2) }}" class="mobile-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
                                @else
                                    {{ $website->title }}
                                @endif

                            </a>

                            <!-- Style inline per gestire input pilotati da admin in vista mobile     ####mobile_menu_color#### -->
                            <style>
                                @media only screen and (min-width: 280px) and (max-width: 991px) {

                                    #navbarNav { background-color: {{ $website->mobile_menu_bgcolor }}!important; color: {{ $website->mobile_menu_color }}!important; }
                                    .navbar .navbar-nav .dropdown .dropdown-menu { background-color: {{ $website->bgcolor_menu_mobile }}!important; color: {{ $website->mobile_menu_color }} }
                                    dropdown-menu .nav-item { color: {{ $website->mobile_menu_color }}; }
                                    .nav-link { color: {{ $website->mobile_menu_color }}!important; }

                                    /* HOVER BACKGROUND-COLOR ON ITEM SUB-MENU */
                                    .navbar .nav-item .dropdown-menu .dropdown-item:hover { {{ $website->color_gen2 }} }

                                    .dropdown-item:hover { background-color: {{ $website->color_gen2 }} }


                                }

                                @media only screen and (min-width: 992px) and (max-width: 2800px) {

                                    .navbar .navbar-nav .dropdown .dropdown-menu .nav-link a:hover { color: {{ $website->header_color_hover }}!important; }
                                    /* HOVER BACKGROUND-COLOR ON ITEM SUB-MENU */
                                    .navbar .nav-item .dropdown-menu .dropdown-item:hover { background: {{ $website->color_gen2 }} }

                                }

                                header .navbar [class*="col-"] .navbar-nav .nav-item a:hover { color: {{ $website->header_color_hover }}!important; }
                                header .navbar [class*="col-"] .navbar-nav .dropdown .dropdown-menu a:hover { color: {{ $website->header_color_hover }}!important; }

                            </style>

                            <button style="background-color:{{ $website->color_gen2 }}!important;" type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                                <i class="far fa-xmark"></i>
                            </button>
                        </div>

                        <div class="offcanvas-body gap-xl-4">
                            <?php
                            $lang = \App::getLocale();
                            $lang_ = strtoupper($lang);
                            ?>

                            <ul class="navbar-nav justify-content-end flex-grow-1">

                                @if($menu)
                                    @foreach($menu as $item)
                                            <?php
                                            $target = $item->is_in_blank == 1 ? "_blank" : "";
                                            ?>

                                <li class="nav-item dropdown">

                                    <!-- se però ha figli cambia e metto le classi o al tag a o al tag li  -->
                                    @if($item->slug != "/")
                                        @if(count($item->figli))

                                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="color: {{ $website->header_color }};">
                                                <!-- se non ha figli niente dropdown-->
                                                @else
                                                    <a class="nav-link" href="/{{ $item->slug }}" target="{{ $target }}" style="color: {{ $website->header_color }};">
                                                        @endif
                                                        <!-- se è il tasto home -->
                                                        @else
                                                            <!-- la riga seguente è il pulsante HOME -->
                                                            <a class="nav-link" href="/" style="color: {{ $website->header_color }};">
                                                                @endif
                                                                {{ $item->title }}

                                                            </a>
                                                            <!-- sotto menu per ogni voce -->
                                                            @if(count($item->figli))
                                                                <ul class="dropdown-menu fade-down" style="background-color: {{ $website->submenu_desktop_bgcolor }}!important; width: auto; word-wrap: break-word;">
                                                                    @foreach($item->figli as $figli)
                                                                            <?php
                                                                                $target = $figli->is_in_blank == 1 ? "_blank" : "";
                                                                            ?>
                                                                        <li class="dropdown-item">
                                                                            <a href="/{{ $figli->slug }}" target="{{ $target }}">
                                                                                <span style="color: {{ $website->submenu_txt_color }}; word-wrap: break-word;">{{ $figli->title }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                    </a>
                                            </a>

                                            @endforeach
                                        @endif
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </nav>
        </div>
        <!-- navbar end-->

</header>







