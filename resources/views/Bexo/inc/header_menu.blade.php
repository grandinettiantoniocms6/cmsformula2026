<!-- start: Hamburger Menu -->
@php
    $menuMobilePanelBg = $website->menu_mobile_panel_background ?: ($website->hamburger_menu_background ?: '#000000');
    $mobileMenuBgLayer = $website->mobile_menu_bgcolor ?: '#000000';
@endphp
<div class="hamburger-area d-lg-none" style="background-color: {{ $menuMobilePanelBg }}!important;">
    <div class="hamburger_bg" style="background-color: {{ $mobileMenuBgLayer }}!important;"></div>
    <div class="hamburger_wrapper">
        <div class="hamburger_inner">
            <div class="hamburger_top d-flex align-items-center justify-content-between">
                <div class="hamburger_logo">
                    <a href="/" class="mobile_logo">
                        @if($website->logo2)
                            <img src="{{ url($website->logo2) }}" alt="{{ $website->title }}">
                        @elseif($website->logo)
                            <img src="{{ url($website->logo) }}" alt="{{ $website->title }}">
                        @else
                            {{ $website->title }}
                        @endif
                    </a>
                </div>
                <div class="hamburger_close">
                    <button class="hamburger_close_btn"><i class="fa-thin fa-times"></i></button>
                </div>
            </div>
            <div class="hamburger_menu">
                <div class="mobile_menu"></div>
            </div>
        </div>
    </div>
</div>
<!-- end: Hamburger Menu -->

<!-- Style inline per gestire input pilotati da admin in vista mobile     ####mobile_menu_color#### -->
<style>
    @php
        $mobileSubmenuBgColor = $website->submenu_mobile_bgcolor ?: '#f5f5f5';
        $mobilePanelBgColor = $website->menu_mobile_panel_background ?: ($website->hamburger_menu_background ?: '#000000');
        $hamburgerButtonBgColor = $website->hamburger_menu_background ?: '#000000';
        $mobileMenuTextColor = $website->mobile_menu_color ?: '#111111';
        $submenuMobileTextColor = $website->submenu_txt_color_mobile ?: ($website->submenu_txt_color ?: '#111111');
        $menuIconColor = $website->bgcolor_menu_mobile ?: '#ffffff';
    @endphp

    @media only screen and (min-width: 280px) and (max-width: 991px) {

        .menu_bar.mobile_menu_bar { background-color: {{ $hamburgerButtonBgColor }}!important; color: {{ $mobileMenuTextColor }}!important; }
        .menu_bar.mobile_menu_bar span { background-color: {{ $menuIconColor }} !important; }
        .hamburger_close_btn,
        .hamburger_close_btn i,
        .mean-container .mean-nav ul li a.mean-expand,
        .mean-container .mean-nav ul li a.mean-expand i {
            color: {{ $menuIconColor }} !important;

        }
        .mean-container .mean-nav ul > li > a {
            color: {{ $mobileMenuTextColor }} !important;
            -webkit-text-fill-color: {{ $mobileMenuTextColor }} !important;
        }
        #mobile-menu .sub-menu,
        .mean-container .mean-nav ul li ul,
        .mean-container .mean-nav ul li ul.sub-menu,
        .mean-container .mean-nav ul li ul.sub-menu li,
        .mean-container .mean-nav ul li ul.sub-menu li > a {
            background-color: {{ $mobileSubmenuBgColor }} !important;
        }
        .mean-container .mean-nav ul li ul.sub-menu li > a {
            color: {{ $submenuMobileTextColor }} !important;
            -webkit-text-fill-color: {{ $submenuMobileTextColor }} !important;
        }


        .hamburger-area .hamburger_menu,
        .hamburger-area .mobile_menu,
        .mean-container .mean-nav > ul,
        .mean-container .mean-nav > ul > li {
            background-color: {{ $mobilePanelBgColor }} !important;
        }
        .hamburger_menu .mean-nav ul li.dropdown-opened > a,
        .hamburger_menu .mean-nav ul li a.mean-expand.mean-clicked {
            background-color: {{ $mobileSubmenuBgColor }} !important;
            color: {{ $mobileMenuTextColor }} !important;
            -webkit-text-fill-color: {{ $mobileMenuTextColor }} !important;
        }
    }

</style>

<!-- start: Header Area -->
@php
    $normalizeMenuPath = static function ($slug) {
        $slug = trim((string) $slug);
        $path = '/' . ltrim($slug, '/');
        $path = rtrim($path, '/');

        return $path === '' ? '/' : $path;
    };

    $currentMenuPath = $normalizeMenuPath(request()->path() === '/' ? '/' : request()->path());
@endphp

<!-- Header -->
<header class="header-area header-2 header-absolute section-gap-x" style="background-color: {{ $website->header_background }}!important; height: {{ $website->menubar_height }}!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header-wrapper">
                    <div class="site_logo">
                        <a class="logo" href="/">
                            @if($website->logo)
                                <img src="{{ url($website->logo) }}" alt="{{ $website->title }}">
                            @else
                                {{ $website->title }}
                            @endif
                        </a>
                    </div>

                    <div class="menu-area d-none d-lg-inline-flex align-items-center">
                        <nav id="mobile-menu" class="mainmenu">
                            <ul>
                                @if($menu)
                                    @foreach($menu as $item)
                                        @php
                                            $hasChildren = count($item->figli) > 0;
                                            $target = $item->is_in_blank == 1 ? '_blank' : '';
                                            $href = $item->slug == '/' ? '/' : '/' . ltrim($item->slug, '/');
                                            $itemPath = $normalizeMenuPath($item->slug);
                                            $hasCurrentChild = false;
                                            if ($hasChildren) {
                                                foreach ($item->figli as $figlioMenu) {
                                                    if ($normalizeMenuPath($figlioMenu->slug) === $currentMenuPath) {
                                                        $hasCurrentChild = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            $isCurrentParent = !$hasChildren && $itemPath === $currentMenuPath;
                                            $isCurrentMenu = $isCurrentParent || $hasCurrentChild;
                                        @endphp
                                        <li class="{{ $hasChildren ? 'has-dropdown' : '' }} {{ $isCurrentMenu ? 'is-current-menu' : '' }}">
                                            <a href="{{ $hasChildren ? '#' : $href }}" @if(!$hasChildren && $target) target="{{ $target }}" @endif>{{ $item->title }}</a>
                                            @if($hasChildren)
                                                <ul class="sub-menu">
                                                    @foreach($item->figli as $figlio)
                                                        @php
                                                            $childTarget = $figlio->is_in_blank == 1 ? '_blank' : '';
                                                            $childHref = $figlio->slug == '/' ? '/' : '/' . ltrim($figlio->slug, '/');
                                                            $childIsCurrent = $normalizeMenuPath($figlio->slug) === $currentMenuPath;
                                                        @endphp
                                                        <li class="{{ $childIsCurrent ? 'is-current-menu' : '' }}">
                                                            <a href="{{ $childHref }}" @if($childTarget) target="{{ $childTarget }}" @endif>{{ $figlio->title }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </nav>
                    </div>

                    <div class="header-right-item d-none d-lg-inline-flex">
                        <div class="header-button">
                            <a class="tj-primary-btn" href="/contact">
                                <span class="btn-text"><span>Let's Talk</span></span>
                                <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                            </a>
                        </div>
                    </div>

                    <div class="menu_bar mobile_menu_bar d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- end: Header Area -->
