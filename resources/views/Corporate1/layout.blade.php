<?php
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$plugin = \App\Models\PluginProductsSettings::first();
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
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

    <link rel="canonical" href="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>">

    @include('common.consent_solution_iubenda')
    @include('common.gdprtools')
    <!-- {!! \NoCaptcha::renderJs() !!} -->

    @include('common.css_common')
    @include('common.engine_body_style')
    @include('common.engine_header_style')
    @include('common.engine_footer_style')
    {!! \NoCaptcha::renderJs() !!}

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
    <!-- Cookie Consent -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />

    @include('common.tag_analytics')
    @include('common.mailchimp')
    @include('common.recaptcha')

</head>
<body>
<?php
//serve per leggere le label da amdin
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>

<main class="main">
<!-- preloader -->
<div class="preloader" style="background-color:{{ $website->color_gen2 }}!important;">
    <div class="loader-ripple">
        <div></div>
        <div></div>
    </div>
</div>
<!-- preloader end -->
<div id="modal_view"></div>
@include('common.engine_googlegta')
<div id="modal_view"></div>

@yield('topbar')
@yield('header_menu')

    @if($website->header_background)
        <header id="header" class="header default fullWidth" style="background-color: {{ $website->header_background }}!important; position:relative!important;">
    @else
        <header id="header" class="header default fullWidth" style="position:relative!important;">
    @endif
        </header>

    @yield('content_header')
    @yield('content')
    @yield('content_footer')

    <!-- scroll-top -->
    <a href="#" id="scroll-top" style="background-color:{{ $website->color_gen2 }}!important;"><i class="far fa-arrow-up"></i></a>
    <!-- scroll-top end -->

    <!-- javascript libraries -->
    <script src="{{ url("templates/Corporate1/assets/js/jquery-3.7.1.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/modernizr.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/imagesloaded.pkgd.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/jquery.magnific-popup.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ url("templates/Corporate1/assets/js/isotope.pkgd.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/jquery.appear.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/jquery.easing.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/owl.carousel.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/counter-up.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/jquery.nice-select.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/wow.min.js") }}"></script>
    <script src="{{ url("templates/Corporate1/assets/js/main.js") }}"></script>

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
