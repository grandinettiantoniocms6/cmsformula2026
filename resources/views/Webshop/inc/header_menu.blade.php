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
                    $logo_exist = false;
                    if(file_exists(public_path($website->logo))){
                        $logo_exist = true;
                    }
                    ?>

                    @if($logo_exist)
                        <img id="header-logo" src="{{ url($website->logo) }}" class="img-fluid" alt="{{ $website->title }}">
                    @endif
                @else
                    {{ $website->title }}
                @endif
            </a>

            <div class="collapse navbar-collapse" id="navbar-main-collapse">
                <div class="navbar-header">
                    <a class="navbar-brand-mobile" href="{{ url('/') }}">
                        @if($website->logo2)
                            <?php
                            $logo_exist = false;
                            if(file_exists(public_path($website->logo2))){
                                $logo_exist = true;
                            }
                            ?>
                            @if($logo_exist)
                                <img id="header-logo-mobile" src="{{ url($website->logo2) }}" alt="{{ $website->title }}">
                            @endif
                        @else
                            @if($website->logo)
                                    <?php
                                    $logo_exist = false;
                                    if(file_exists(public_path($website->logo))){
                                        $logo_exist = true;
                                    }

                                    ?>
                                @if($logo_exist)
                                <img id="header-logo-mobile" src="{{ url($website->logo) }}" alt="{{ $website->title }}">
                                @endif
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


            <button class="navbar-toggler open-navbar" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main-collapse" aria-expanded="false" aria-label="Menu">
                {{--<svg viewBox="0 0 100 80" width="24" height="24">
                    <rect width="100" height="10"></rect>
                    <rect y="30" width="100" height="10"></rect>
                    <rect y="60" width="50" height="10"></rect>
                </svg>--}}
                <span class="lines"></span>
            </button>

        </nav>
    </div>

    @yield('topbar_ecommerce')
</header>
