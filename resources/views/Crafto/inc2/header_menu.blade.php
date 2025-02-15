<!-- start header -->
<header class="header-with-topbar">
    @if($website->topbar_active == 1 && (env('TOPBAR')) )
        <!-- TOPBAR -->
        <div class="header-top-bar top-bar-dark bg-dark" style="background-color: {{ $website->topbar_background }};">
            <div class="container-fluid">
                <div class="row h-45px align-items-center m-0">
                    <div class="col-12 col-lg-7 fw-500 justify-content-lg-start justify-content-center">
                        @if($website->topbar_contact_mobile)
                            <span class="me-25px fs-15 md-m-0">
                                <i class="{{ $website->icon_topbar2 }} {{ $website->sizeicon }}"></i>
                                <span class="text-light-gray"><a class="me-25px fs-15 md-m-0" href="tel:{{ $website->topbar_contact_mobile }}">{{ $website->topbar_contact_mobile }}</a></span>
                            </span>
                        @endif
                        @if($website->topbar_contact_email)
                            <span class="d-xl-inline-block d-none fs-15"><i class="{{ $website->icon_topbar1 }} {{ $website->sizeicon }}"></i><a href="mailto:{{ $website->topbar_contact_email }}" class="widget text-light-gray text-white-hover">{{ $website->topbar_contact_email }}</a></span>
                        @endif
                    </div>

                    <?php $socials = json_decode($website->socials, true); ?>
                    @if($socials)
                        <div class="col-md-5 text-end d-none d-lg-flex fs-15">
                            @foreach($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" class="me-25px lg-me-15px">
                                    @if($social['icon'])
                                        <i class="{{ $social['icon'] }} {{ $website->sizeicon }}" style="color: {{ $website->color_icon_topbar }}!important; "></i>
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
    @endif

    <!-- NAVBAR + header fixed -->
    @if($website->is_topbar_fixed_desktop == 1)
    <nav class="navbar navbar-expand-lg header-light bg-white header-reverse" data-header-hover="light">
    @else
    <nav class="navbar navbar-expand-lg header-light bg-white" data-header-hover="light">
    @endif

        @if($website->is_online == 0 && backpack_user() && !is_numeric(strpos(env('APP_URL'), "stage")))
            <div id="offline" class="container-fluid bg-danger text-white text-center"><strong>Il sito è in modalità Offline.</strong> Avviso solo per gli amministratori. </div>
        @endif

        <div class="container-fluid">
            <div class="col-auto">
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
            <div class="col-auto menu-order left-nav">
                <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
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

                                            <a href="#" class="nav-link" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">

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
                                                                            <a href="/{{ $figli->slug }}" target="{{ $target }}"><span>{{ $figli->title }}</span></a>
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

            <div class="col-auto ms-auto ps-lg-0 d-none d-sm-flex">
                <!--<div class="header-icon">
                    <div class="d-none d-xl-inline-block"><div class="fw-600"><a href="tel:1800222000" class="widget-text"><i class="feather icon-feather-phone-call me-10px"></i>1 800 222 000</a></div></div>
                    <div class="header-button ms-25px">
                        <a href="demo-logistics-contact-us.html" class="btn btn-small btn-base-color btn-hover-animation-switch btn-round-edge btn-box-shadow fw-700 ls-0px btn-icon-left">
                                    <span>
                                        <span class="btn-text">Get a quote</span>
                                        <span class="btn-icon"><i class="feather icon-feather-mail"></i></span>
                                        <span class="btn-icon"><i class="feather icon-feather-mail"></i></span>
                                    </span>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </nav>
    <!-- end navigation -->
</header>
<!-- end header -->
