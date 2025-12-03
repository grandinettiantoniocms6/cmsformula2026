<!-- start header -->
<header class="header-with-topbar">
    @if($website->topbar_active == 1 && (env('TOPBAR')) )
        <!-- TOPBAR -->
        <div class="header-top-bar" style="background-color: {{ $website->topbar_background }}; color: {{ $website->color_icon_topbar }};">
            <div class="container-fluid">
                <div class="row h-45px xs-h-auto align-items-center m-0 xs-pt-5px xs-pb-5px">
                    <div class="col-lg-5 col-md-7 text-center text-md-start xs-px-0">
                        @if($website->topbar_scrolltext_active == 1 && (env('TOPBAR_SCORREVOLE')) )
                            @if($website->topbar_contact_description)
                                <div class="fw-500" style="color: {{ $website->color_txt_topbar }}; font-size: {{ $website->font_size_topbar }};"><i class="{{ $website->icon_topbar3 }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }}"></i> {{ $website->topbar_contact_description }}</div>
                            @endif
                        @endif
                    </div>
                    @if($website->topbar_contact_mobile)
                        <div class="col-lg-7 col-md-5 text-end d-none d-md-flex">
                            <div class="widget fw-500 me-35px lg-me-25px md-me-0" style="color: {{ $website->color_txt_topbar }}; font-size: {{ $website->font_size_topbar }};"><a style="color: {{ $website->color_txt_topbar }};" href="tel:{{ $website->topbar_contact_mobile }}"><i style="color: {{ $website->color_icon_topbar }}" class="{{ $website->icon_topbar2 }} {{ $website->sizeicon }}"></i>{{ $website->topbar_contact_mobile }}</a></div>
                            @if($website->topbar_contact_email)
                                <div class="widget fw-500 me-35px lg-me-25px md-me-0"><i style="color: {{ $website->color_icon_topbar }}" class="{{ $website->icon_topbar1 }} {{ $website->sizeicon }}"></i><a href="mailto:{{ $website->topbar_contact_email }}">&nbsp; {{ $website->topbar_contact_email }}</a>
                                </div>
                            @endif
                            <div class="widget fw-500 d-none d-lg-inline-block" style="color: {{ $website->color_txt_topbar }}; font-size: {{ $website->font_size_topbar }};"><i class="{{ $website->topbar_address_icon }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }};"></i> {{ $website->topbar_address_text }}</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!-- / TOPBAR -->
    @endif

    <!-- NAVBAR + header fixed -->
    @if($website->is_topbar_fixed_desktop == 1)
    <nav class="navbar navbar-expand-lg responsive-sticky" style="background-color: {{ $website->header_background }}!important; height: {{ $website->menubar_height }}!important;">

    @else
    <nav class="navbar navbar-expand-lg" style="background-color: {{ $website->header_background }}!important; height: {{ $website->menubar_height }}!important;">
    @endif

            @if($website->is_online == 0 && backpack_user() && !is_numeric(strpos(env('APP_URL'), "stage")))
                <div id="offline" class="container-fluid bg-danger text-white text-center"><strong>Il sito è in modalità Offline.</strong> Avviso solo per gli amministratori. </div>
            @endif

            <div class="container-fluid">
                <div class="col-auto col-lg-2 me-lg-0 me-auto">

                    <!-- MENU -->
                    <a class="navbar-brand" href="/">
                        @if($website->logo)
                                <?php
                                if(env('LOCAL') == 0){
                                    list($width, $height, $type, $attr) = getimagesize("$website->logo");
                                }
                                ?>
                            <img src="{{ url($website->logo) }}" class="default-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
                            <img src="{{ url($website->logo) }}" class="alt-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>

                            @if($website->logo2)
                                    <?php
                                    if(env('LOCAL') == 0){
                                        list($width, $height, $type, $attr) = getimagesize("$website->logo2");
                                    }
                                    ?>
                                <img src="{{ url($website->logo2) }}" class="mobile-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
                            @else
                                <img src="{{ url($website->logo) }}" class="mobile-logo" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
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

                    @media only screen and (min-width: 992px) and (max-width: 2800px) {

                        .navbar .navbar-nav .dropdown .dropdown-menu .nav-link a:hover { color: {{ $website->header_color_hover }}!important; }

                    }

                    header .navbar [class*="col-"] .navbar-nav .nav-item a:hover { color: {{ $website->header_color_hover }}!important; }
                    header .navbar [class*="col-"] .navbar-nav .dropdown .dropdown-menu a:hover { color: {{ $website->header_color_hover }}!important; }

                </style>

                <div class="col-auto menu-order position-static">
                    <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                        <span class="navbar-toggler-line" style="background-color: {{ $website->bgcolor_menu_mobile }}!important;"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">

                        <?php
                        $lang = \App::getLocale();
                        $lang_ = strtoupper($lang);
                        ?>

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



                            <?php
                            $adminLang = \App\Models\AdminLanguage::where("is_active", 1)->where("is_frontend", 1)
                                ->orderBy("lft", "asc")
                                ->get()->pluck("label", "name")->toArray();
                            ?>
                            @if(count($adminLang) > 1)
                                <li class="nav-item nav-item-lang dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img width="24" height="16" src="{{ url("img/".\App::getLocale().".svg") }}" alt="{{ $lang }}"><span class="d-lg-none text-uppercase ms-3 me-auto">{{ $lang }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach ($adminLang as $lang => $language)
                                            @if ($lang != App::getLocale())
                                                <a class="dropdown-item" title="{{ $lang }}" href="{{ route('lang.switch', $lang) }}"><img width="24" height="16" src="{{ url("img/$lang.svg") }}" alt="{{ $lang }}"></a>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                            @endif


                        </ul>
                    </div>
                </div>

                @if($website->is_extra_button_menu == 1)
                    <div class="col-auto col-lg-2 text-end d-none d-sm-flex">
                        <div class="header-icon">
                           <div class="header-button">

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

            </div>
    </nav>
</header>

