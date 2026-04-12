<style>
    :root {
        --bexo-menu-link-color: {{ $website->header_color ?: '#111111' }};
        --bexo-menu-link-hover-color: {{ $website->header_color_hover ?: '#0d6efd' }};
        --bexo-menu-link-visited-color: {{ $website->menu_link_visited_color ?: ($website->header_color_hover ?: '#0d6efd') }};
        --bexo-header-bg: {{ $website->header_background ?: 'transparent' }};
        --bexo-menu-mobile-bg: {{ $website->menu_mobile_panel_background ?: ($website->hamburger_menu_background ?: '#000000') }};
        --bexo-hamburger-btn-bg: {{ $website->hamburger_menu_background ?: '#000000' }};
        --bexo-menu-submenu-desktop-bg: {{ $website->submenu_desktop_bgcolor ?: '#ffffff' }};
        --bexo-menu-mobile-link-color: {{ $website->mobile_menu_color ?: '#111111' }};
        --bexo-menu-submenu-bg: {{ $website->submenu_mobile_bgcolor ?: '#f5f5f5' }};
        --bexo-menu-submenu-link-color: {{ $website->submenu_txt_color ?: '#111111' }};
        --bexo-menu-submenu-mobile-link-color: {{ $website->submenu_txt_color_mobile ?: ($website->submenu_txt_color ?: '#111111') }};
        --bexo-menu-icon-color: {{ $website->bgcolor_menu_mobile ?: '#ffffff' }};
    }

    .header-area.header-1 .header-wrapper {
        background-color: var(--bexo-header-bg) !important;
    }

    .header-area .mainmenu > ul > li > a,
    .header-area .mainmenu ul li .sub-menu li > a {
        color: var(--bexo-menu-link-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-link-color) !important;
    }

    .header-area .mainmenu > ul > li > a:hover,
    .header-area .mainmenu ul li .sub-menu li > a:hover {
        color: var(--bexo-menu-link-hover-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-link-hover-color) !important;
    }

    .header-area .mainmenu ul li .sub-menu,
    .header-area .mainmenu ul li .sub-menu li {
        background-color: var(--bexo-menu-submenu-desktop-bg) !important;
    }

    .header-area .mainmenu ul li .sub-menu li > a {
        color: var(--bexo-menu-submenu-link-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-submenu-link-color) !important;
    }

    .header-area .mainmenu > ul > li.is-current-menu > a,
    .header-area .mainmenu ul li .sub-menu li.is-current-menu > a,
    .header-area .mainmenu a.is-current-menu-link {
        color: var(--bexo-menu-link-visited-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-link-visited-color) !important;
    }

    .mean-container .mean-bar,
    .mean-container .mean-nav,
    .mean-container .mean-nav ul,
    .hamburger_menu,
    .hamburger-area .hamburger_wrapper {
        background: var(--bexo-menu-mobile-bg) !important;
    }

    .mean-container .mean-nav ul li > a {
        color: var(--bexo-menu-mobile-link-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-mobile-link-color) !important;
    }
    .menu_bar.mobile_menu_bar {
        background-color: var(--bexo-hamburger-btn-bg) !important;
    }
    .mean-container .mean-nav ul li > a.mean-expand,
    .mean-container .mean-nav ul li > a.mean-expand i,
    .hamburger_close_btn,
    .hamburger_close_btn i {
        color: var(--bexo-menu-icon-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-icon-color) !important;
        background-color: transparent !important;
    }
    .menu_bar.mobile_menu_bar span {
        background-color: var(--bexo-menu-icon-color) !important;
    }

    .mean-container .mean-nav ul li > a:hover,
    .mean-container .mean-nav ul li > a:focus {
        color: var(--bexo-menu-link-hover-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-link-hover-color) !important;
    }

    .mean-container .mean-nav ul li ul li > a {
        background-color: var(--bexo-menu-submenu-bg) !important;
        color: var(--bexo-menu-submenu-mobile-link-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-submenu-mobile-link-color) !important;
    }
    .mean-container .mean-nav ul li ul,
    .mean-container .mean-nav ul li ul.sub-menu,
    .mean-container .mean-nav ul li ul.sub-menu li {
        background-color: var(--bexo-menu-submenu-bg) !important;
    }

    .mean-container .mean-nav ul li > a.is-current-menu-link,
    .mean-container .mean-nav ul li.is-current-menu > a {
        color: var(--bexo-menu-link-visited-color) !important;
        -webkit-text-fill-color: var(--bexo-menu-link-visited-color) !important;
    }
</style>
