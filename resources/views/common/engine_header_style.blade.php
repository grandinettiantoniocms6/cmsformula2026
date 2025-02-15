<style>
    #header {
        @if($website->photo_header)
            background-image: url('{{ $website->photo_header }}') !important;
        @else
            @if($website->header_background)
                background: {{ $website->header_background }} !important;
            @endif
        @endif

        @if($website->header_color)
             color: {{ $website->header_color }} !important;
        @endif
    }

    @if($website->header_color)
        #header a {
            color: {{ $website->header_color }};
        }
    @endif

    @if($website->header_color_hover)
        #header a:hover {
            color: {{ $website->header_color_hover }} !important;
        }
    @endif

    /* Colore Pilotato da admin > tab Header/Top-Menu by WI  */

    @if($website->submenu_txt_color)
        .mega-menu .menu-links > li.active .drop-down-multilevel a {
            color: {{ $website->submenu_txt_color }} !important;
        }
        #navbar-main .dropdown-item {
            --bs-dropdown-link-color: {{ $website->submenu_txt_color }};
        }
    @endif

    @if($website->submenu_bgcolor)
        .mega-menu .drop-down-multilevel {
            background: {{ $website->submenu_bgcolor }} !important;
        }
    @endif

    @if($website->bgcolor_active_submenu)
        .mega-menu .menu-links > li.active .drop-down-multilevel li.active a {
             background: {{ $website->bgcolor_active_submenu }} !important;
        }
    @endif

    @if($website->bgcolor_menu_mobile)
        .mega-menu .menu-mobile-collapse-trigger::before, .mega-menu .menu-mobile-collapse-trigger::after, .mega-menu .menu-mobile-collapse-trigger span {
            background: {{ $website->bgcolor_menu_mobile }} !important;
        }
    @endif

    /* Regola che vale solo su Mobile */

    @media screen and (max-width: 991px) {
        @if($website->mobile_menu_bgcolor)
        .mega-menu .menu-links {
            background: {{ $website->mobile_menu_bgcolor }}  !important;
        }
        @endif
    }

    @if($website->header_color)
        .mega-menu menu-links {
            background: {{ $website->header_color }} !important;
        }
    @endif
</style>
