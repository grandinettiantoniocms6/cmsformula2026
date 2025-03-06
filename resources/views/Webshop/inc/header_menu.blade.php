<?php $adminTemplate = \App\Models\AdminTemplate::where("name", "Webshop")->first(); ?>
@if(!$adminTemplate->header)
    <?php $adminTemplate->header = 'header-standard logo-left'; ?>
@endif
@if($website->is_topbar_fixed_desktop == 1)
    <?php $adminTemplate->header .= ' sticky-header-desktop'; ?>
@endif
@if($website->is_topbar_fixed_mobile == 1)
    <?php $adminTemplate->header .= ' sticky-header-mobile'; ?>
@endif

@if($website->transparent_header == 1)
    <?php $adminTemplate->header .= ' transparent-header-desktop'; ?>
@endif
@if($website->transparent_header_mobile == 1)
    <?php $adminTemplate->header .= ' transparent-header-mobile'; ?>
@endif

<header id="header" class="header-expand--2xl {{$adminTemplate->header}}">
    <div class="container-fluid">
        <nav class="navbar navbar-expanded">
            <a class="navbar-brand" href="{{ url('/') }}" title="{{ $website->title }}">
                @if($website->logo)
                    <?php
                    if(env('LOCAL') == 0){
                        list($width, $height, $type, $attr) = getimagesize("$website->logo");
                    }

                    $logo_exist = false;
                    if(file_exists(public_path($website->logo))){
                        $logo_exist = true;
                    }
                    ?>

                    @if($logo_exist)
                        <img id="header-logo" src="{{ url($website->logo) }}" class="img-fluid" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
                    @endif
                @else
                    {{ $website->title }}
                @endif
            </a>

            {{--CERCA IN HEADER --}}
            <div class="navbar-search d-none d-md-block">
                @include("$thema.plugins.pluginProducts.v3.inc.search_top")
            </div>
            {{--CERCA IN HEADER --}}

            <div class="collapse navbar-collapse" id="navbar-main-collapse">
                <div class="navbar-header">
                    <a class="navbar-brand-mobile" href="{{ url('/') }}">
                        @if($website->logo2)
                            <?php
                            if(env('LOCAL') == 0){
                                list($width, $height, $type, $attr) = getimagesize("$website->logo2");
                            }
                            ?>
                            <img id="header-logo-mobile" src="{{ url($website->logo2) }}" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
                        @else
                            @if($website->logo)
                                    <?php
                                    if(env('LOCAL') == 0){
                                        list($width, $height, $type, $attr) = getimagesize("$website->logo");
                                    }
                                    ?>
                                <img id="header-logo-mobile" src="{{ url($website->logo) }}" alt="{{ $website->title }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
                            @else
                                {{ $website->title }}
                            @endif
                        @endif
                    </a>
                    <button class="close close-navbar" data-bs-toggle="collapse" data-bs-target="#navbar-main-collapse" aria-expanded="true" aria-label="Chiudi">
                        {{--<i class="fas fa-times"></i>--}}
                        <span class="lines"></span>
                    </button>
                </div>

                @include('Webshop.inc.menu')

                <div class="social-mobile">
                    @include('Webshop.inc.socials')
                </div>
            </div>
            <div class="navbar-backdrop close-navbar" data-bs-toggle="collapse" data-bs-target="#navbar-main-collapse" aria-label="Chiudi" role="button"></div>

            <?php
            $adminPluginProducts = \App\Models\AdminPlugin::where("name", "pluginProducts")
                ->where("version", 3)
                ->where("is_active", 1)->first();
            $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
            ?>
            @if($adminPluginProducts)
                @include('Webshop.plugins.pluginProducts.inc.topbar_menu')
            @endif
            @if($adminPluginBooking)
                @include('Webshop.plugins.pluginBooking.inc.topbar_menu')
            @endif

            {{--CERCA IN HEADER --}}
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#search-mobile" aria-expanded="false" aria-label="Cerca">
                <i class="bi bi-search"></i>
            </button>
            {{--CERCA IN HEADER --}}

            <button class="navbar-toggler open-navbar" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main-collapse" aria-expanded="false" aria-label="Menu">
                <span class="lines"></span>
            </button>

        </nav>
    </div>

    {{--CERCA IN HEADER --}}
    <div class="d-block d-md-none">
        <div class="collapse" id="search-mobile">
            <div class="container-fluid">
                @include("$thema.plugins.pluginProducts.v3.inc.search_top_mobile")
            </div>
        </div>
    </div>
    {{--CERCA IN HEADER --}}

    @yield('topbar_ecommerce')
</header>
