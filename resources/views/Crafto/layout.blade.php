<?php
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
$craftoPageBlockTypes = collect();
if (isset($page) && $page && $page->id) {
    $craftoPageBlockTypes = \App\Models\PageBlock::where("page_id", $page->id)
        ->where("is_active", 1)
        ->pluck("type");
}
$craftoHasFormCss = $craftoPageBlockTypes->intersect(["blockContact", "blockPluginForm", "blockPluginParking"])->isNotEmpty();
$craftoHasSidebarCss = isset($page) && $page && in_array($page->template, ["sidebar_left", "sidebar_right"], true);
$craftoHasProductsCss = $craftoPageBlockTypes->intersect(["blockPluginCounter"])->isNotEmpty();
$craftoHasCartCss = request()->is("cart*") || request()->is("checkout*");
$craftoHasLightbox = $craftoPageBlockTypes->intersect(["blockGallery", "blockLastwork", "blockPortfolio", "blockReference"])->isNotEmpty();
?>
<?php $thema = env('TEMA'); ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('head')
    @yield('meta')

    @if(is_numeric(strpos(env('APP_URL'), "stage")))
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
    @endif

    @if($craftoHasLightbox)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    @endif
    <link rel="canonical" href="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>">

    @if(env('IUBENDA') == 1 && $website->consent_solution_iubenda)
        {!! $website->consent_solution_iubenda !!}
    @endif
    @include('common.gdprtools')

    @if($craftoHasSidebarCss)
        <link rel="stylesheet" type="text/css" href="{{ url("css_common/sidebar.css") }}" />
    @endif
    @if($craftoHasProductsCss)
        <link rel="stylesheet" type="text/css" href="{{ url("css_common/products.css") }}" />
    @endif
    @if($craftoHasCartCss)
        <link rel="stylesheet" type="text/css" href="{{ url("css_common/cart.css") }}" />
    @endif
    @include('common.engine_body_style')
    @include('common.engine_header_style')
    @include('common.engine_footer_style')
    @yield('recaptcha')

    <!-- Css per personalizzazioni extra commons -->
    @if($website->custom_css)
        <link rel="stylesheet" href="{{ url("$website->custom_css") }}">
    @endif

    @if($website->custom_css_style)
        <style>
            {!! $website->custom_css_style !!}
        </style>
    @endif
    @include('common.tag_analytics')
    @include('common.mailchimp')
</head>
<?php
//serve per leggere le label da amdin
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
$admin_template = \App\Models\AdminTemplate::where("name", $thema)->first();

$nav_style = "classic";
if($admin_template->nav_style){
    $nav_style = $admin_template->nav_style;
}

?>

<body data-mobile-nav-style="{{ $nav_style }}">

<!-- start cursor -->
<div class="cursor-page-inner">
    <div class="circle-cursor circle-cursor-inner"></div>
    <div class="circle-cursor circle-cursor-outer"></div>
</div>
<!-- end cursor -->
<div id="modal_view"></div>
@include('common.engine_googlegta')
<div id="modal_view"></div>

@yield('topbar')
@yield('header_menu')

<!-- K righe 78-82 ?
    @if($website->header_background)
        <header id="header" class="header default fullWidth" style="background-color: {{ $website->header_background }}!important; position:relative!important;">
    @else
        <header id="header" class="header default fullWidth" style="position:relative!important;">
    @endif

-->


    @yield('content_header')

    @yield('content')
    @yield('content_footer')

    <!-- start scroll progress -->
    <div class="scroll-progress d-none d-xxl-block">
        <a href="#" class="scroll-top" aria-label="scroll">
            <span class="scroll-text">{{ @$labelSite['torna-su'] }}</span><span class="scroll-line"><span class="scroll-point"></span></span>
        </a>
    </div>
    <!-- end scroll progress -->

    <!-- javascript libraries -->
    <script src="{{ url("templates/Crafto/js/jquery.js") }}" defer></script>
    <script src="{{ url("templates/Crafto/js/vendors.min.js") }}" defer></script>
    @if($craftoHasLightbox)
        <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js" defer></script>
    @endif
    <script src="{{ url("templates/Crafto/js/main.js") }}" defer></script>

    @include('common.engine_customerly')
    @include('common.engine_popup_modal_crafto')
    @include('common.engine_wapp')
    <!--include('common.js_common') -->
    <script>
        window.addEventListener('load', function () {
            if (!window.jQuery) {
                return;
            }

            jQuery("div.alert-success").fadeIn(300).delay(5000).fadeOut(500);
            jQuery("div.alert-warning").fadeIn(300).delay(5000).fadeOut(500);
            jQuery("div.alert-close").fadeIn(300).delay(2500).fadeOut(500);
        });
    </script>

    <!-- Cookie Banner Crafto o Iubenda -->
    @if(trim($website->iubenda_cookie_banner) != "")
       {!! $website->iubenda_cookie_banner !!}
    @else
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
        <script src="js_common/cookieconsent.min.js" defer></script>
        <script>
            window.addEventListener('load', function(){
                window.cookieconsent.initialise({
                    'palette': {
                        'popup': {
                            'background': '{{ $website->cookie_div_bg }}',
                            'text': '{{ $website->cookie_txt_color }}'
                        },
                        'button': {
                            'background': '{{ $website->cookie_btn_bg }}'
                        }
                    },
                    'theme': 'classic',
                    'position': '{{ $website->cookie_position }}',
                    'content': {
                        'message': '{{ @$labelSite['cookiebar_message'] }}',
                        'dismiss': '{{ @$labelSite['cookiebar_ok'] }}',
                        'allow': '{{ @$labelSite['cookiebar_accetta'] }}',
                        'link': '{{ @$labelSite['cookiebar_leggi_informativa'] }}',
                        'href': '{{ url('privacy') }}'

                    }
                })});
        </script>

    @endif

    <!-- wapp JS file -->
    @if($website->whatsapp_active == 1 && env('WAPP'))
        <script>
            window.addEventListener('load', function () {
                var loadStylesheet = function (href) {
                    var link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = href;
                    document.head.appendChild(link);
                };
                var loadScript = function (src, callback) {
                    var script = document.createElement('script');
                    script.src = src;
                    script.onload = callback;
                    document.body.appendChild(script);
                };

                loadStylesheet('{{ $website->wapp_css1 ? url("$website->wapp_css1") : url("css_common/whatsapp/css/wapp.css") }}');
                loadStylesheet('{{ $website->wapp_css2 ? url("$website->wapp_css2") : url("css_common/whatsapp/plugin/whatsapp-chat-support.css") }}');

                loadScript('{{ url("css_common/whatsapp/plugin/components/moment/moment.min.js") }}', function () {
                    loadScript('{{ url("css_common/whatsapp/plugin/components/moment/moment-timezone-with-data-10-year-range.min.js") }}', function () {
                        loadScript('{{ url("css_common/whatsapp/plugin/whatsapp-chat-support.js") }}', function () {
                            if (window.jQuery && jQuery.fn.whatsappChatSupport) {
                                jQuery('#chat').whatsappChatSupport({
                                    defaultMsg : '',
                                });
                                // serve nel caso uso anche pulsante in un blocco
                                jQuery('#chat-btn').whatsappChatSupport();
                            }
                        });
                    });
                });
            });
        </script>
        <noscript>
            <link rel="stylesheet" type="text/css" href="{{ $website->wapp_css1 ? url("$website->wapp_css1") : url("css_common/whatsapp/css/wapp.css") }}" />
            <link rel="stylesheet" type="text/css" href="{{ $website->wapp_css2 ? url("$website->wapp_css2") : url("css_common/whatsapp/plugin/whatsapp-chat-support.css") }}" />
        </noscript>
    @endif

    @yield('after_scripts')
</body>
</html>
