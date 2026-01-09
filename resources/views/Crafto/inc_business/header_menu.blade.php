<?php
$lang = \App::getLocale();
$lang_ = strtoupper($lang);
?>
<!-- start header -->
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
                        <div class="header-language-icon widget alt-font fw-600">
                            <div class="header-language dropdown" style="top: -2px!important;">
                                <a href="javascript:void(0);"><img width="24" height="16" src="{{ url("img/".\App::getLocale().".svg") }}" alt="{{ $lang }}"></a>
                                <ul class="language-dropdown">

                                    @if(count($adminLang) > 1)

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
    <nav class="navbar navbar-expand-lg header-transparent bg-transparent header-reverse" >
    @else
    <nav class="navbar navbar-expand-lg header-transparent bg-transparent" >
    @endif

        @if($website->is_online == 0 && backpack_user() && !is_numeric(strpos(env('APP_URL'), "stage")))
            <div id="offline" class="container-fluid bg-danger text-white text-center"><strong>Il sito è in modalità Offline.</strong> Avviso solo per gli amministratori. </div>
        @endif

        <div class="container-fluid">
            <div class="col-auto col-lg-2 me-lg-0 me-auto">
                <a class="navbar-brand" href="/" style="color: {{ $website->header_color }}!important;">
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
            <div class="col-auto menu-order position-static">
                <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        @if($menu)
                            @foreach($menu as $item)
                                    <?php
                                        $target = $item->is_in_blank == 1 ? "_blank" : "";
                                    ?>

                                <li class="nav-item dropdown simple-dropdown">

                                    <!-- se però ha figli cambia e metto le classi o al tag a o al tag li  -->
                                    @if($item->slug != "/")
                                        @if(count($item->figli))

                                            <a href="#" class="nav-link" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: {{ $website->header_color }}!important;" >

                                                <!-- Top menu senza sotto menu dropdown-->
                                                @else
                                                    <a class="nav-link" href="/{{ $item->slug }}" target="{{ $target }}" style="color: {{ $website->header_color }}!important;">
                                                        @endif
                                                        <!-- se è il tasto home -->
                                                        @else
                                                            <a class="nav-link" href="/">
                                                                @endif
                                                                {{ $item->title }}
                                                                <!-- Se la voce di menu ha figli metti arrow -->
                                                                @if(count($item->figli))
                                                                    &nbsp;<i class="fa-solid fa-angle-down"></i>
                                                                @endif
                                                            </a>
                                                            <!-- sotto menu per ogni voce -->
                                                            @if(count($item->figli))
                                                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background-color: {{ $website->submenu_desktop_bgcolor }};">
                                                                    @foreach($item->figli as $figli)
                                                                            <?php
                                                                            $target = $figli->is_in_blank == 1 ? "_blank" : "";
                                                                            ?>
                                                                        <li class="nav-item">
                                                                            <a href="/{{ $figli->slug }}" target="{{ $target }}"><span style="color: {{ $website->header_color }}!important;">{{ $figli->title }}</span></a>
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
            <!-- ICONE SOCIAL -->
            <?php $socials = json_decode($website->socials, true); ?>
            @if($socials)
                <div class="col-auto col-lg-2 text-end">
                    <div class="header-icon">
                        <div class="header-social-icon icon">
                            @foreach($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" class="me-25px lg-me-15px">
                                    @if($social['icon'])
                                        <i class="{{ $social['icon'] }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }}!important;"></i>
                                    @else
                                        {{ $social['name'] }}
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <!-- ICONE SOCIAL -->

        </div>
    </nav>
    <!-- / MENU -->
</header>
<!-- end header -->
