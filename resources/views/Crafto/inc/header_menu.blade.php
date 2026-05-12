<!-- start header -->
<?php
    $lang = \App::getLocale();
    $lang_ = strtoupper($lang);
    $menubarHeightValue = trim((string) $website->menubar_height);
    if ($menubarHeightValue === '') {
        $menubarHeightCss = '80px';
    } elseif (is_numeric($menubarHeightValue)) {
        $menubarHeightCss = $menubarHeightValue . 'px';
    } elseif (preg_match('/^\d+(\.\d+)?(px|rem|em|vh|vw)$/', $menubarHeightValue)) {
        $menubarHeightCss = $menubarHeightValue;
    } else {
        $menubarHeightCss = '80px';
    }
    $headerBackgroundCss = $website->header_background ?: '#ffffff';
    $mobileStickyBackgroundCss = '';
?>
<header class="header-with-topbar">
    @if($website->topbar_active == 1 && (env('TOPBAR')) )
        <!-- TOPBAR -->
        <div class="header-top-bar" style="background-color: {{ $website->topbar_background }}; color: {{ $website->color_icon_topbar }};">
            <div class="container-fluid">
                <div class="row h-45px align-items-center m-0">

                    <div class="col-9 fw-500 justify-content-lg-start justify-content-left">
                        @if($website->topbar_contact_mobile)
                            <span class="me-25px fs-15 md-m-0">
                                <i class="{{ $website->icon_topbar2 }} {{ $website->sizeicon }}"></i>
                                <span style="color: {{ $website->color_txt_topbar }}!important;"><a class="me-25px fs-15 md-m-0" style="color: {{ $website->color_txt_topbar }}!important; font-size: {{ $website->font_size_topbar }};" href="tel:{{ $website->topbar_contact_mobile }}">&nbsp; {{ $website->topbar_contact_mobile }}</a></span>
                            </span>
                        @endif
                        @if($website->topbar_contact_email)
                            <span class="d-xl-inline-block d-none fs-15"><i class="{{ $website->icon_topbar1 }} {{ $website->sizeicon }}"></i>
                            <span style="color: {{ $website->color_txt_topbar }}!important; font-size: {{ $website->font_size_topbar }};><a href="mailto:{{ $website->topbar_contact_email }}">&nbsp; {{ $website->topbar_contact_email }}</a></span>
                        @endif
                    </div>

                    <div class="col-3 fw-500 justify-content-lg-start justify-content-rigth">

                            <?php $socials = json_decode($website->socials, true); ?>
                        @if($socials)

                            @foreach($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" class="me-25px lg-me-15px">
                                    @if($social['icon'])
                                        <i class="{{ $social['icon'] }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }}!important; "></i>
                                    @else
                                        {{ $social['name'] }}
                                    @endif
                                </a>
                            @endforeach

                        @endif

                        <!-- Gestione lingue -->
                            <?php
                            $adminLang = \App\Models\AdminLanguage::where("is_active", 1)->where("is_frontend", 1)
                                ->orderBy("lft", "asc")
                                ->get()->pluck("label", "name")->toArray();
                            ?>

                            @if(count($adminLang) > 1)

                            <div class="header-language-icon widget alt-font fw-600">
                                <div class="header-language dropdown" style="top: -2px!important;">
                                    <a href="javascript:void(0);"><img width="24" height="16" src="{{ url("img/".\App::getLocale().".svg") }}" alt="{{ $lang }}"></a>
                                    <ul class="language-dropdown">

                                        @foreach ($adminLang as $lang => $language)
                                                @if ($lang != App::getLocale())
                                                    <li>
                                                        <a class="" title="{{ $lang }}" href="{{ route('lang.switch', $lang) }}"><img width="24" height="16" src="{{ url("img/$lang.svg") }}" alt="{{ $lang }}"></a>
                                                    </li>
                                                @endif
                                            @endforeach

                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!-- / Gestione lingue -->

                    </div>
                </div>
            </div>
        </div>
        <!-- / TOPBAR -->
    @endif

    <!-- NAVBAR + header fixed -->
    @if($website->is_topbar_fixed_desktop == 1)
    <nav class="navbar navbar-expand-lg header-reverse crafto-inc-nav" style="background-color: {{ $headerBackgroundCss }}!important; height: {{ $menubarHeightCss }}!important;">

    @else
    <nav class="navbar navbar-expand-lg crafto-inc-nav" style="background-color: {{ $headerBackgroundCss }}!important; height: {{ $menubarHeightCss }}!important;">
    @endif

            @if($website->is_online == 0 && backpack_user() && !is_numeric(strpos(env('APP_URL'), "stage")))
                <div id="offline" class="container-fluid bg-danger text-white text-center"><strong>Il sito è in modalità Offline.</strong> Avviso solo per gli amministratori. </div>
            @endif

            <div class="container-fluid">
                <div class="col-auto">

                    <!-- MENU -->
                    <a class="navbar-brand" href="/">
                        @if($website->logo)
                                <?php
                                $logoWidth = null;
                                $logoHeight = null;
                                if(env('LOCAL') == 0){
                                    $logoPath = public_path(ltrim((string) $website->logo, '/'));
                                    if (is_file($logoPath)) {
                                        [$logoWidth, $logoHeight] = getimagesize($logoPath);
                                    }
                                }
                                ?>
                            <img src="{{ url($website->logo) }}" class="default-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0 && $logoWidth && $logoHeight) width="{{ $logoWidth }}" height="{{ $logoHeight }}" @endif>
                            <img src="{{ url($website->logo) }}" class="alt-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0 && $logoWidth && $logoHeight) width="{{ $logoWidth }}" height="{{ $logoHeight }}" @endif>

                            @if($website->logo2)
                                    <?php
                                    $logo2Width = null;
                                    $logo2Height = null;
                                    if(env('LOCAL') == 0){
                                        $logo2Path = public_path(ltrim((string) $website->logo2, '/'));
                                        if (is_file($logo2Path)) {
                                            [$logo2Width, $logo2Height] = getimagesize($logo2Path);
                                        }
                                    }
                                    ?>
                                <img src="{{ url($website->logo2) }}" class="mobile-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0 && $logo2Width && $logo2Height) width="{{ $logo2Width }}" height="{{ $logo2Height }}" @endif>
                            @else
                                <img src="{{ url($website->logo) }}" class="mobile-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0 && $logoWidth && $logoHeight) width="{{ $logoWidth }}" height="{{ $logoHeight }}" @endif>
                            @endif
                        @else
                            {{ $website->title }}
                        @endif
                    </a>
                </div>


                <!-- Style inline per gestire input pilotati da admin in vista mobile     ####mobile_menu_color#### -->
                <style>
                    @media only screen and (min-width: 280px) and (max-width: 991px) {

                        #navbarNav { background-color: {{ $website->mobile_menu_bgcolor }}!important; color: {{ $website->mobile_menu_color }}!important; }
                        .navbar .navbar-nav .dropdown .dropdown-menu { background-color: {{ $website->bgcolor_menu_mobile }}!important; color: {{ $website->mobile_menu_color }} }
                         dropdown-menu .nav-item { color: {{ $website->mobile_menu_color }}; }
                        .nav-link { color: {{ $website->mobile_menu_color }}!important; }

                    }

                    @media only screen and (max-width: 991px) {

                        header.header-with-topbar .crafto-inc-nav,
                        header.sticky .crafto-inc-nav,
                        header.sticky.sticky-active .crafto-inc-nav {
                            height: {{ $menubarHeightCss }} !important;
                            min-height: {{ $menubarHeightCss }} !important;
                            max-height: {{ $menubarHeightCss }} !important;
                            padding-top: 0 !important;
                            padding-bottom: 0 !important;
                            background-color: {{ $mobileStickyBackgroundCss }} !important;
                            overflow: visible !important;
                            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                            z-index: 1100;
                        }

                        header.header-with-topbar .crafto-inc-nav > .container-fluid,
                        header.sticky .crafto-inc-nav > .container-fluid,
                        header.sticky.sticky-active .crafto-inc-nav > .container-fluid {
                            height: {{ $menubarHeightCss }} !important;
                            min-height: {{ $menubarHeightCss }} !important;
                            max-height: {{ $menubarHeightCss }} !important;
                            align-items: center !important;
                            background-color: {{ $mobileStickyBackgroundCss }} !important;
                            overflow: visible !important;
                        }

                        header.header-with-topbar .crafto-inc-nav .navbar-brand,
                        header.sticky .crafto-inc-nav .navbar-brand,
                        header.sticky .crafto-inc-nav.disable-fixed .navbar-brand,
                        header.sticky .crafto-inc-nav.fixed-header .navbar-brand,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-brand {
                            display: flex !important;
                            align-items: center !important;
                            height: {{ $menubarHeightCss }} !important;
                            max-height: {{ $menubarHeightCss }} !important;
                            padding-top: 0 !important;
                            padding-bottom: 0 !important;
                            overflow: hidden !important;
                        }

                        header.header-with-topbar .crafto-inc-nav .navbar-brand .default-logo,
                        header.header-with-topbar .crafto-inc-nav .navbar-brand .alt-logo,
                        header.sticky .crafto-inc-nav .navbar-brand .default-logo,
                        header.sticky .crafto-inc-nav .navbar-brand .alt-logo,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-brand .default-logo,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-brand .alt-logo {
                            visibility: hidden !important;
                            opacity: 0 !important;
                            width: 0 !important;
                            max-width: 0 !important;
                        }

                        header.header-with-topbar .crafto-inc-nav .navbar-brand .mobile-logo,
                        header.sticky .crafto-inc-nav .navbar-brand .mobile-logo,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-brand .mobile-logo {
                            display: block !important;
                            visibility: visible !important;
                            opacity: 1 !important;
                            width: auto !important;
                            max-width: min(55vw, 220px) !important;
                            max-height: calc({{ $menubarHeightCss }} - 12px) !important;
                            object-fit: contain !important;
                        }

                        header.header-with-topbar .crafto-inc-nav .navbar-collapse,
                        header.sticky .crafto-inc-nav .navbar-collapse,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-collapse {
                            z-index: 1200;
                            overflow: visible !important;
                            background-color: {{ $website->mobile_menu_bgcolor ?: $mobileStickyBackgroundCss }} !important;
                        }

                        header.header-with-topbar .crafto-inc-nav .navbar-collapse.collapsing,
                        header.sticky .crafto-inc-nav .navbar-collapse.collapsing,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-collapse.collapsing {
                            overflow: hidden !important;
                            background-color: {{ $website->mobile_menu_bgcolor ?: $mobileStickyBackgroundCss }} !important;
                            transition: height 0.25s ease !important;
                        }

                        header.header-with-topbar .crafto-inc-nav .navbar-collapse .navbar-nav,
                        header.sticky .crafto-inc-nav .navbar-collapse .navbar-nav,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-collapse .navbar-nav {
                            background-color: {{ $website->mobile_menu_bgcolor ?: $mobileStickyBackgroundCss }} !important;
                        }

                        header.header-with-topbar .crafto-inc-nav .navbar-toggler,
                        header.sticky .crafto-inc-nav .navbar-toggler,
                        header.sticky.sticky-active .crafto-inc-nav .navbar-toggler {
                            align-self: center !important;
                            margin-top: 0 !important;
                            margin-bottom: 0 !important;
                        }

                    }

                    @media only screen and (min-width: 992px) and (max-width: 2800px) {

                        .navbar .navbar-nav .dropdown .dropdown-menu .nav-link a:hover { color: {{ $website->header_color_hover }}!important; }

                    }

                    header .navbar [class*="col-"] .navbar-nav .nav-item a:hover { color: {{ $website->header_color_hover }}!important; }
                    header .navbar [class*="col-"] .navbar-nav .dropdown .dropdown-menu a:hover { color: {{ $website->header_color_hover }}!important; }

                </style>

                <div class="col-auto menu-order left-nav">
                    <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">

                        <ul class="navbar-nav fw-600">
                            @if($menu)
                                @foreach($menu as $item)
                                        <?php
                                        $target = $item->is_in_blank == 1 ? "_blank" : "";
                                        ?>

                                    <li class="nav-item dropdown simple-dropdown">

                                        <!-- se però ha figli cambia e metto le classi o al tag a o al tag li  -->
                                        @if($item->slug != "/")
                                            @if(count($item->figli))

                                                <a href="#" class="nav-link" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: {{ $website->header_color }};">

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
                                                                    <!-- Se la voce di menu ha figli metti arrow -->
                                                                    @if(count($item->figli))
                                                                        &nbsp;<i class="fa-solid fa-angle-down"></i>
                                                                    @endif
                                                                </a>
                                                                <!-- sotto menu per ogni voce -->
                                                                @if(count($item->figli))
                                                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background-color: {{ $website->submenu_desktop_bgcolor }}!important;">
                                                                        @foreach($item->figli as $figli)
                                                                                <?php
                                                                                $target = $figli->is_in_blank == 1 ? "_blank" : "";
                                                                                ?>
                                                                            <li class="nav-item">
                                                                                <a href="/{{ $figli->slug }}" target="{{ $target }}"><span style="color: {{ $website->submenu_txt_color }};">{{ $figli->title }}</span></a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                        </a>
                                                </a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>


                    </div>
                </div>

                <!-- Info extra button menu -->
                @if($website->is_extra_button_menu == 1)
                    <div class="col-auto ms-auto ps-lg-0 d-none d-sm-flex">
                        <div class="header-icon">
                            <div class="header-button ms-25px">

                                <a href="{{ $website->link_extra_button_menu }}" target="{{ $website->type_href }}" class="btn btn-small btn-rounded btn-box-shadow" style="background-color: {{ $website->bgcolor_extra_button_menu }}; color: {{ $website->txtcolor_extra_button_menu }};">{{ $website->label_extra_button_menu }}</a>

                            </div>
                        </div>
                    </div>

                @else

                    <div class="col-auto col-lg-2 text-end d-none d-sm-flex">
                        <div class="header-icon">
                            <div class="header-button">
                                <!-- null per lasciare il center top menu -->
                            </div>
                        </div>
                    </div>

                @endif
                <!-- / Info extra button menu -->

            </div>
    </nav>
</header>

