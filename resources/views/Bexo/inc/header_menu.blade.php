<!-- start: Hamburger Menu -->
@php
    $menuMobilePanelBg = $website->menu_mobile_panel_background ?: ($website->hamburger_menu_background ?: '#000000');
    $mobileMenuBgLayer = $website->mobile_menu_bgcolor ?: '#000000';
    $defaultLanguageCode = (string) config('app.locale', 'it');
    $currentLanguageCode = (string) app()->getLocale();
    $frontendLanguages = \App\Models\AdminLanguage::where('is_active', 1)
        ->where('is_frontend', 1)
        ->orderBy('lft', 'asc')
        ->get(['name', 'label']);
    $hasAdditionalFrontendLanguages = $frontendLanguages
        ->filter(function ($language) use ($defaultLanguageCode) {
            return (string) $language->name !== $defaultLanguageCode;
        })
        ->count() > 0;
    $languageFlagUrl = static function (string $code): string {
        return url("img/{$code}.svg");
    };
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
            @if($website->is_extra_button_menu == 1 || $hasAdditionalFrontendLanguages)
                <div class="hamburger_bottom_actions">
                    @if($website->is_extra_button_menu == 1)
                        <a href="{{ $website->link_extra_button_menu }}" target="{{ $website->type_href }}" class="hamburger_extra_btn" style="background-color: {{ $website->bgcolor_extra_button_menu }}; color: {{ $website->txtcolor_extra_button_menu }};">
                            <span>{{ $website->label_extra_button_menu }}</span>
                        </a>
                    @endif
                    @if($hasAdditionalFrontendLanguages)
                        <div class="dropdown bexo-lang-switch bexo-lang-switch-mobile">
                            <a class="bexo-lang-toggle dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false" aria-label="Selettore lingua mobile">
                                <img src="{{ $languageFlagUrl($currentLanguageCode) }}" alt="{{ strtoupper($currentLanguageCode) }}">
                                <span class="bexo-lang-code">{{ strtoupper($currentLanguageCode) }}</span>
                            </a>
                            <ul class="dropdown-menu bexo-lang-menu">
                                @foreach($frontendLanguages as $language)
                                    @if($language->name !== $currentLanguageCode)
                                        <li>
                                            <a class="dropdown-item" title="{{ $language->name }}" href="{{ route('lang.switch', $language->name) }}">
                                                <img src="{{ $languageFlagUrl($language->name) }}" alt="{{ strtoupper($language->name) }}">
                                                <span>{{ strtoupper($language->name) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif
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
            color: {{ $mobileMenuTextColor }} !important;
            -webkit-text-fill-color: {{ $mobileMenuTextColor }} !important;

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

<style>
    .bexo-header-cta-group {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .bexo-header-cta-group .header-right-item {
        margin-left: 0 !important;
    }
    .bexo-header-cta-group .header-button .tj-primary-btn {
        margin-right: 0;
    }
    .bexo-lang-switch {
        margin-left: 0;
        position: relative;
    }
    .bexo-lang-switch .bexo-lang-toggle {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255, 255, 255, .22);
        border-radius: 999px;
        padding: 6px 12px 6px 8px;
        color: inherit;
        text-decoration: none;
        transition: background-color .15s ease, border-color .15s ease;
    }
    .bexo-lang-switch .bexo-lang-toggle:hover {
        background: rgba(255, 255, 255, .10);
        border-color: rgba(255, 255, 255, .35);
        color: inherit;
    }
    .bexo-lang-switch .bexo-lang-toggle img {
        width: 18px;
        height: 12px;
        object-fit: cover;
        border-radius: 2px;
    }
    .bexo-lang-switch .bexo-lang-code {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        line-height: 1;
    }
    .bexo-lang-switch .bexo-lang-menu {
        min-width: 150px;
        margin-top: 8px;
        border: 0;
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 14px 28px rgba(11, 23, 46, .18);
    }
    .bexo-lang-switch .bexo-lang-menu .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 8px;
        padding: 7px 10px;
        font-size: .82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .bexo-lang-switch .bexo-lang-menu .dropdown-item img {
        width: 18px;
        height: 12px;
        object-fit: cover;
        border-radius: 2px;
    }
    .hamburger_bottom_actions {
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, .18);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }
    .hamburger_extra_btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        min-height: 36px;
        padding: 8px 14px;
        font-size: .82rem;
        font-weight: 700;
        text-decoration: none;
    }
    .hamburger_extra_btn:hover {
        text-decoration: none;
        filter: brightness(0.95);
    }
    .bexo-lang-switch-mobile {
        margin-left: 0;
        width: 100%;
    }
    .bexo-lang-switch-mobile .bexo-lang-toggle {
        min-height: 36px;
        background: rgba(255, 255, 255, .08);
        width: 100%;
        justify-content: center;
    }
    .bexo-lang-switch-mobile .bexo-lang-menu {
        width: 100%;
        min-width: 100%;
        left: 0 !important;
        right: auto !important;
    }
    @media (min-width: 992px) {
        .bexo-header-cta-group .bexo-lang-switch .bexo-lang-toggle {
            padding: 4px 8px 4px 6px;
            gap: 5px;
        }
        .bexo-header-cta-group .bexo-lang-switch .bexo-lang-toggle img {
            width: 16px;
            height: 11px;
        }
        .bexo-header-cta-group .bexo-lang-switch .bexo-lang-code {
            font-size: .68rem;
            letter-spacing: .02em;
        }
        .bexo-header-cta-group .bexo-lang-switch .bexo-lang-menu {
            min-width: 92px;
        }
    }
    @media (max-width: 991px) {
        .hamburger_bottom_actions {
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            margin-top: auto;
        }
        .hamburger_bottom_actions .hamburger_extra_btn,
        .hamburger_bottom_actions .bexo-lang-switch-mobile {
            width: 100%;
        }
        .hamburger_bottom_actions .bexo-lang-switch-mobile .bexo-lang-toggle {
            justify-content: flex-start;
        }
        .hamburger-area .hamburger_wrapper {
            justify-content: flex-start !important;
        }
        .hamburger-area .hamburger_inner {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
        .hamburger-area .hamburger_menu {
            flex: 1 1 auto;
            min-height: 0;
        }
        .hamburger-area .bexo-lang-switch-mobile .bexo-lang-menu {
            position: static !important;
            transform: none !important;
            inset: auto !important;
            width: 100%;
            min-width: 100%;
            margin-top: 8px;
        }
    }
</style>

<!-- Header -->
<header class="header-area header-1 section-gap-x" style="background-color: {{ $website->header_background }}!important; height: {{ $website->menubar_height }}!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header-wrapper" style="border-radius: 80px;">
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

                    <div class="bexo-header-cta-group d-none d-lg-inline-flex">
                        <!-- Info extra button menu -->
                        @if($website->is_extra_button_menu == 1)
                            <div class="header-right-item">
                                <div class="header-button">
                                    <a href="{{ $website->link_extra_button_menu }}" target="{{ $website->type_href }}" class="tj-primary-btn" style="background-color: {{ $website->bgcolor_extra_button_menu }}; color: {{ $website->txtcolor_extra_button_menu }};">
                                        <span class="btn-text"><span>{{ $website->label_extra_button_menu }}</span></span>
                                        <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <!-- / Info extra button menu -->

                        @if($hasAdditionalFrontendLanguages)
                            <div class="header-right-item bexo-lang-switch dropdown">
                                <a class="bexo-lang-toggle dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false" aria-label="Selettore lingua">
                                    <img src="{{ $languageFlagUrl($currentLanguageCode) }}" alt="{{ strtoupper($currentLanguageCode) }}">
                                    <span class="bexo-lang-code">{{ strtoupper($currentLanguageCode) }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end bexo-lang-menu">
                                    @foreach($frontendLanguages as $language)
                                        @if($language->name !== $currentLanguageCode)
                                            <li>
                                                <a class="dropdown-item" title="{{ $language->name }}" href="{{ route('lang.switch', $language->name) }}">
                                                    <img src="{{ $languageFlagUrl($language->name) }}" alt="{{ strtoupper($language->name) }}">
                                                    <span>{{ strtoupper($language->name) }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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
