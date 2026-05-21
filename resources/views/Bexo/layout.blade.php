<?php
//$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
//$plugin = \App\Models\PluginProductsSettings::first();
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<?php $thema = env('TEMA'); ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('common.google_public_key_credential_fallback')
    @yield('head')
    @yield('meta')

    @if(is_numeric(strpos(env('APP_URL'), "stage")))
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
    @endif

    <link rel="canonical" href="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>">

    @include('common.consent_solution_iubenda')
    @include('common.gdprtools')

    {{-- {!! \NoCaptcha::renderJs() !!} --}}

    @include('common.css_common')
    @include('common.engine_body_style')
    @include('common.engine_header_style')
    @include('common.engine_footer_style')
    <!-- Css per personalizzazioni extra commons -->
    @if($website->custom_css)
        <link rel="stylesheet" href="{{ url("$website->custom_css") }}">
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>
    @if($website->custom_css_style)
        <style>
            {!! $website->custom_css_style !!}
        </style>
    @endif
    @include('Bexo.inc.menu_override_style')
    <!-- Cookie Consent -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />

    @include('common.tag_analytics')
    @include('common.mailchimp')
    @include('common.recaptcha')

</head>
<body>
<div class="body-overlay"></div>

<!-- Preloader Start -->
@include('Bexo.inc.preloader')
<!-- Preloader end -->

<!-- back to top start -->
<div id="tj-back-to-top"><span id="tj-back-to-top-percentage"></span></div>
<!-- back to top end -->
@include('common.engine_googlegta')
<div id="modal_view"></div>

@yield('topbar')
@yield('header_menu')

    @if($website->header_background)
        <header id="header" class="header-area header-1 section-gap-x" style="background-color: {{ $website->header_background }}!important; position:relative!important;">
    @else
        <header id="header" class="header-area header-1 section-gap-x">
    @endif
        </header>

        <div id="smooth-wrapper">
            <div id="smooth-content">
                <main id="primary" class="site-main">
                    <div class="space-for-header"></div>
                        @yield('content_header')
                        @yield('content')
                        @yield('content_footer')
                </main>
            </div>
        </div>

    <!-- JS here -->
    <script src="{{ url("templates/Bexo/assets/js/jquery.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/gsap.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/ScrollSmoother.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/gsap-scroll-to-plugin.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/gsap-scroll-trigger.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/gsap-split-text.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/jquery.nice-select.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/swiper.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ url("templates/Bexo/assets/js/odometer.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/venobox.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/appear.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/wow.min.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/meanmenu.js") }}"></script>
    <script src="{{ url("templates/Bexo/assets/js/main.js") }}"></script>

    @include('common.engine_wapp')

    <!-- Cookie Banner Corporate1 o Iubenda -->
    @if(trim($website->iubenda_cookie_banner) != "")
       {!! $website->iubenda_cookie_banner !!}
    @else
        <script src="js_common/cookieconsent.min.js"></script>
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
    <script src="{{ url("css_common/whatsapp/plugin/components/moment/moment.min.js") }}"></script>
    <script src="{{ url("css_common/whatsapp/plugin/components/moment/moment-timezone-with-data-10-year-range.min.js") }}"></script>
    <script src="{{ url("css_common/whatsapp/plugin/whatsapp-chat-support.js") }}"></script>
    <script>
        $('#chat').whatsappChatSupport({
            defaultMsg : '',
        });
        // serve nel caso uso anche pulsante in un blocco
        $('#chat-btn').whatsappChatSupport();
    </script>

@yield('after_scripts')

</body>
</html>
