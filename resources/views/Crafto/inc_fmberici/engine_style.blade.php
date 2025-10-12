<?php
$p_family = [];
?>

@if($website->h_family)
    <?php
        $temp = explode("family=", $website->h_family);
        if(key_exists(1, $temp)){
            $h_family = explode(":", $temp[1]);
        }
        ?>
        @if(key_exists(1, $temp))
            <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');" href="{{ $website->h_family }}">
            <noscript>
                <link rel="stylesheet" href="{{ $website->h_family }}">
            </noscript>
        @endif
@endif

@if($website->p_family)
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <?php
    $temp = explode("family=", $website->p_family);
    if(key_exists(1, $temp)){
        $p_family = explode(":", $temp[1]);
    }
    ?>
    @if(key_exists(1, $temp))
        <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');" href="{{ $website->p_family }}">
        <noscript>
            <link rel="stylesheet" href="{{ $website->p_family }}">
        </noscript>
    @endif
@endif


<style>
    :root {
        <?php if($page->color_title_page){ ?>
              --page-title: {{ $page->color_title_page }};
        <?php } ?>
        <?php if($page->color_subtitle_page){ ?>
            --page-subtitle: {{ $page->color_subtitle_page }};
            --page-category: {{ $page->color_subtitle_page }};
        <?php } ?>

        @if(count($p_family))
            <?php if($website->p_family){ ?>
                --bs-body-font-family: {{ $p_family[0] }}, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
            <?php } ?>
            <?php if($website->h_family){ ?>
                --headings-font-family: {{ $h_family[0] }}, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
            <?php } ?>
        @endif

        <?php if($website->topbar_background){ ?>
        --topbar-bg: {{ $website->topbar_background }};
        <?php } ?>
        <?php if($website->color_txt_topbar){ ?>
        --topbar-text-color: {{ $website->color_txt_topbar }};
        <?php } ?>
        <?php if($website->color_icon_topbar){ ?>
        --topbar-icon-color: {{ $website->color_icon_topbar }};
        <?php } ?>
        --topbar-font-size: {{ $website->font_size_topbar }};

        <?php if($website->site_background){ ?>
        --bs-body-bg: {{ $website->site_background }};
        <?php } else { ?>
        --bs-body-bg: #fff;
        <?php } ?>

        <?php if($website->site_color){ ?>
        --bs-body-color: {{ $website->site_color }};
        --bs-body-color-rgba: <?php echo hex2rgb( $website->site_color ) ?>;
        <?php } else { ?>
        --bs-body-color-rgba: #000;
        <?php } ?>

        <?php if($website->font_size){ ?>
        --body-font-size: {{ $website->font_size }};
        --header-link-font-size: {{ $website->font_size }};
        <?php } ?>

        --header-bg: {{ $website->header_background }};
        --header-text-color: {{ $website->header_color }};
        --header-link-color: {{ $website->header_color }};
        --header-link-hover-color: {{ $website->header_color_hover }};
        <?php if($website->menubar_height){ ?>
            --header-height: {{ $website->menubar_height }};
        <?php } else { ?>
            --header-height: 120px;
        <?php } ?>

        <?php if($website->bgcolor_menu_mobile){ ?>
           --hamburger-menu-mobile: {{ $website->bgcolor_menu_mobile }};
        <?php } else { ?>
          --hamburger-menu-mobile: #000000;
        <?php } ?>

        <?php if($website->mobile_menu_bgcolor){ ?>
            --menu-mobile-bg: {{ $website->mobile_menu_bgcolor }};
        <?php } else { ?>
            --menu-mobile-bg: #fff;
        <?php } ?>

        <?php if($website->submenu_bgcolor){ ?>
            --submenu-mobile-bg: {{ $website->submenu_bgcolor }};
        <?php } else { ?>
            --submenu-mobile-bg: #fff;
        <?php } ?>

        <?php if($website->bgcolor_active_submenu){ ?>
            --submenu-mobile-bg-active: {{ $website->bgcolor_active_submenu }};
        <?php } else { ?>
            --submenu-mobile-bg-active: var(--bs-primary);
        <?php } ?>

        --footer-bg: {{ $website->footer_background }};
        --footer-text-color: {{ $website->footer_color }};
        --footer-link-color: {{ $website->footer_color }};
        --footer-link-hover-color: {{ $website->footer_color_hover }};

        --topbar-ecommerce-bg: {{ $plugin->topbar_background }};

        <?php if($plugin->bg_btn_search_topbar_ecommerce){ ?>
            --drop-categories-btn-bg: {{ $plugin->bg_btn_search_topbar_ecommerce }};
        <?php } else { ?>
            --drop-categories-btn-bg: #000;
        <?php } ?>

        --drop-categories-btn-color: {{ $plugin->txtcolor_btn_search_topbar_ecommerce }};
        --drop-categories-btn-font-size: {{ $plugin->size_btn_search_topbar_ecommerce }};

        --drop-categories-border:  {{ $plugin->bg_btn_search_topbar_ecommerce }};
        --drop-categories-color: {{ $plugin->txtcolor_btn_search_topbar_ecommerce }};

        <?php if($plugin->bg_submenu_search_topbar_ecommerce){ ?>
            --drop-categories-dropdown-bg: {{ $plugin->bg_submenu_search_topbar_ecommerce }};
        <?php } else { ?>
            --drop-categories-dropdown-bg: #fff;
        <?php } ?>

        --drop-categories-dropdown-color: {{ $plugin->txtcolor_submenu_search_topbar_ecommerce }};
        --drop-categories-dropdown-font-size: {{ $plugin->size_submenu_search_topbar_ecommerce }};

        <?php if($plugin->color_hover_autocomplete_topbar_ecommerce){ ?>
            --autocomplete--item-hover: {{ $plugin->color_hover_autocomplete_topbar_ecommerce }};
        <?php } else { ?>
            --autocomplete--item-hover: #000;
        <?php } ?>

        --bs-btn-bg: {{ $website->btn_background }};
        --bs-btn-bg-rgb: <?php echo hex2rgb( $website->btn_background ) ?>;
        --bs-primary-rgb: <?php echo hex2rgb( $website->btn_background ) ?>;
        --bs-btn-hover-bg: {{ $website->btn_hover_background }};
        --bs-btn-active-bg: {{ $website->btn_hover_background }};
        --bs-btn-color: {{ $website->btn_txt_color }};
        --bs-btn-active-color: {{ $website->btn_txt_color }};

        --button-color: {{ $website->btn_background }};
        --button-text-color: {{ $website->btn_txt_color }};

        --bs-body-line-height: 1.7;
        --bs-body-font-weight: 400;

        --bs-link-color: {{ $website->btn_background }};
        --bs-link-hover-color: {{ $website->btn_background }};
        --product-gallery-current: {{ $website->btn_background }};
        --product-brand-badge: {{ $website->btn_background }};
        --product-tabs-active-color: {{ $website->btn_background }};
        --product-tag-color-hover: {{ $website->btn_background }};
        --scrollbar-color: rgba(<?php echo hex2rgb( $website->btn_background ) ?>, 0.15);

        --timetable-border-color: #000;
    }
    .card {
        --bs-card-cap-bg: rgba(<?php echo hex2rgb( $website->btn_background ) ?>, 0.05);
    }
    .btn-primary, .btn-product {
        --bs-btn-color: {{ $website->btn_txt_color }};
        --bs-btn-bg: {{ $website->btn_background }};
        --bs-btn-border-color: {{ $website->btn_colorborder }};
        --bs-btn-hover-bg: {{ $website->btn_hover_background }};
        --bs-btn-hover-border-color: {{ $website->btn_hover_background }};
        --bs-btn-active-color: {{ $website->btn_txt_color }};
        --bs-btn-active-bg: {{ $website->btn_hover_background }};
        --bs-btn-active-border-color: {{ $website->btn_hover_background }};
    }
    .btn:disabled, .btn.disabled, fieldset:disabled .btn {
        --bs-btn-disabled-bg: {{ $website->btn_background }};
        --bs-btn-disabled-border-color: {{ $website->btn_background }};
    }
    .btn-outline-primary {
        --bs-btn-color: {{ $website->btn_background }};
        --bs-btn-border-color: {{ $website->btn_background }};
    }
    .btn-outline-primary:hover, .btn-outline-primary:focus {
        --bs-btn-hover-bg: {{ $website->btn_background }};
        --bs-btn-hover-color: {{ $website->btn_txt_color }};
        --bs-btn-hover-border-color: {{ $website->btn_background }};
    }
    .pagination {
        --bs-pagination-color: {{ $website->btn_background }};
        --bs-pagination-active-bg: {{ $website->btn_background }};
        --bs-pagination-active-border-color: {{ $website->btn_background }};
    }

    @if($website->submenu_txt_color)
        #navbar-main .dropdown-item {
            --bs-dropdown-link-color: {{ $website->submenu_txt_color }};
        }
    @endif

    #header .dropdown-menu {
        @if($website->submenu_desktop_bgcolor)
            --submenu-desktop-bg: {{ $website->submenu_desktop_bgcolor }};
        @else
            --submenu-desktop-bg: #fff;
        @endif
    }
</style>
