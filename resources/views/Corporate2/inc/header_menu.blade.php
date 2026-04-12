<!-- start header -->
<?php
    $lang = \App::getLocale();
    $lang_ = strtoupper($lang);
?>
<style>
    .header-2 .header-top .lang-select::before {
        display: none !important;
        content: none !important;
    }
</style>
<!-- Header Start -->
<header class="header header-2">
    <div class="sticky-height"></div>
    <div class="header-wrapper">

        <!-- TopBar -->
        <div class="header-top" style="background-color: {{ $website->topbar_background }}; color: {{ $website->color_icon_topbar }};">
            <div class="container ct-container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="header-infos">
                        <ul class="d-none d-xl-flex flex-wrap align-items-center gap-4">
                            @if($website->topbar_contact_mobile)
                                <li>
                                    <i class="{{ $website->icon_topbar2 }} {{ $website->sizeicon }}"></i>
                                    <span style="color: {{ $website->color_txt_topbar }}!important;"><a class="me-25px fs-15 md-m-0" style="color: {{ $website->color_txt_topbar }}!important; font-size: {{ $website->font_size_topbar }};" href="tel:{{ $website->topbar_contact_mobile }}">&nbsp; {{ $website->topbar_contact_mobile }}</a></span>
                                </li>
                            @endif
                            @if($website->topbar_contact_email)
                                <li>
                                    <i class="{{ $website->icon_topbar1 }} {{ $website->sizeicon }}"></i>
                                    <span style="color: {{ $website->color_txt_topbar }}!important; font-size: {{ $website->font_size_topbar }};"><a href="mailto:{{ $website->topbar_contact_email }}">&nbsp; {{ $website->topbar_contact_email }}</a></span>
                                </li>
                            @endif
                        </ul>

                    </div>

                    <!-- Lang -->
                    <div class="header-cta d-flex align-items-center gap-3">

                        <?php
                        $adminLang = \App\Models\AdminLanguage::where("is_active", 1)->where("is_frontend", 1)
                            ->orderBy("lft", "asc")
                            ->get()->pluck("label", "name")->toArray();
                        ?>

                        @if(count($adminLang) > 1)
                            <div class="dropdown lang-select d-none d-sm-block">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img width="24" height="16" src="{{ url("img/".\App::getLocale().".svg") }}" alt="{{ $lang }}">
                                    <span>{{ $lang }}</span>
                                </a>

                                <ul class="dropdown-menu">
                                    @foreach ($adminLang as $lang => $language)
                                        @if ($lang != App::getLocale())
                                            <li>
                                                <a class="dropdown-item" title="{{ $lang }}" href="{{ route('lang.switch', $lang) }}">
                                                    <img width="24" height="16" src="{{ url("img/$lang.svg") }}" alt="{{ $lang }}">
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Social -->
                        <?php $socials = json_decode($website->socials, true); ?>

                        @if($socials)

                            @foreach($socials as $social)
                                <div class="social-share ms-4">
                                    <a href="{{ $social['url'] }}" target="_blank" class="me-25px lg-me-15px">
                                        @if($social['icon'])
                                            <i class="fa-brands fa-{{ $social['icon'] }}" style="color: {{ $website->color_icon_topbar }}!important; "></i>
                                        @else
                                            {{ $social['name'] }}
                                        @endif
                                    </a>
                                </div>
                            @endforeach

                        @endif

                    </div>

                </div>
            </div>

            <!-- Navigation Menu Start -->
            <div class="header-nav-wrapper header-sticky">
                <nav class="navbar navbar-expand-xl">
                    <div class="container ct-container">

                        <a class="navbar-brand" href="/">
                            @if($website->logo)
                                    <?php
                                    if(env('LOCAL') == 0){
                                        list($width, $height, $type, $attr) = getimagesize("$website->logo");
                                    }
                                    ?>
                                <img src="{{ url($website->logo) }}" class="default-logo img-fluid" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>

                            @else
                                {{ $website->title }}
                            @endif
                        </a>

                        <!-- Hamburger Menu mobile_menu_bgcolor {{ $website->bgcolor_menu_mobile }}!important; -->
                        <button class="navbar-toggler offcanvas-nav-btn" type="button">
                             <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" fill="" viewBox="0 0 14 12">
                                <path fill="{{ $website->bgcolor_menu_mobile }}" d="M0 .75Q.063.063.75 0h12.5q.687.063.75.75-.063.687-.75.75H.75Q.063 1.437 0 .75m0 5Q.063 5.063.75 5h12.5q.687.063.75.75-.063.687-.75.75H.75Q.063 6.437 0 5.75m13.25 5.75H.75q-.687-.063-.75-.75.063-.687.75-.75h12.5q.687.063.75.75-.063.687-.75.75" />
                            </svg>
                        </button>

                        <div class="nav-cta d-none d-md-flex  order-lg-3">
                            <div class="d-flex align-items-center justify-content-between gap-3">


                                <a href="quote.html" class="btn btn-primary btn-hover"> Free Quote <i class="fa fa-arrow-right"></i>
                                    <span></span>
                                </a>

                            </div>
                        </div>

                        <div class="offcanvas offcanvas-start offcanvas-nav">
                            <div class="offcanvas-header">
                                <a href="index.html" class="text-inverse"><img src="images/logo-w.svg" alt="Logo"></a>
                                <button type="button" class="btn-close bg-primary" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                            </div>

                            <div class="offcanvas-body pt-0 align-items-center justify-content-between">
                                <ul class="navbar-nav mx-auto align-items-lg-center">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index2.html">Home</a>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="services.html" role="button"
                                           data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="services.html">Services Style 1</a></li>
                                            <li><a class="dropdown-item" href="services-2.html">Services style 2</a></li>

                                        </ul>
                                    </li>


                                </ul>

                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

    </div>
</header>
<!-- Header End -->

