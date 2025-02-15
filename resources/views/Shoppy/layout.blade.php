<!DOCTYPE html>
<html lang="it">
<head>
    @yield('meta')
    @yield('head')
    @include('common.css_common')
    @include('common.engine_body_style')
    @include('common.engine_header_style')
    @include('common.engine_footer_style')
    {!! \NoCaptcha::renderJs() !!}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Cookie Consent -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />

    @if(is_numeric(strpos(env('APP_URL'), "stage")))
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
    @endif

</head>
<body class="home">
<?php
    //serve per leggere le label da amdin
    $labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<div class="page-wrapper">
    @if($website->header_background)
        <header id="header" class="header" style="background-color: {{ $website->header_background }}!important;">
    @else
        <header id="header" class="header">
    @endif
        @yield('topbar')
        @yield('header_menu')
        </header>

    @yield('content_header')
    @yield('content')
    <!-- qui stat per evitare vuoto footer -->
    @include('common.tag_analytics_shiny')
    @yield('content_footer')
</div>
    <!-- Scroll to top button -->
        <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="d-icon-arrow-up"></i></a>
    <!-- end Scroll to top button -->
@include('Shoppy.inc.mobile_menu')
<!-- Plugins JS File -->
<script src="{{ url("templates/Shoppy/vendor/jquery/jquery.min.js") }}"></script>
<script src="{{ url("templates/Shoppy/vendor/imagesloaded/imagesloaded.pkgd.min.js") }}"></script>
<script src="{{ url("templates/Shoppy/vendor/elevatezoom/jquery.elevatezoom.min.js") }}"></script>
<script src="{{ url("templates/Shoppy/vendor/magnific-popup/jquery.magnific-popup.min.js") }}"></script>
<script src="{{ url("templates/Shoppy/vendor/isotope/isotope.pkgd.min.js") }}"></script>

<script src="{{ url("templates/Shoppy/vendor/owl-carousel/owl.carousel.min.js") }}"></script>
<!-- Main JS File -->
<script src="{{ url("templates/Shoppy/js/main.min.js") }}"></script>

@include('common.engine_customerly')
@include('common.engine_popup_modal')
@include('common.script_autocomplete')
@include('common.js_common')
<script>
    $( "div.alert-success" ).fadeIn( 300 ).delay( 2500 ).fadeOut( 500 );
</script>

<!-- CoockeBar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
<script>
    window.addEventListener('load', function(){
        window.cookieconsent.initialise({
            'palette': {
                'popup': {
                    'background': '#000000',
                    'text': '#ffffff'
                },
                'button': {
                    'background': '#f5d948'
                }
            },
            'theme': 'classic',
            'position': 'bottom-left',
            'content': {
                'message': '{{ $labelSite['cookiebar_message'] }}',
                'dismiss': '{{ $labelSite['cookiebar_ok'] }}',
                'allow': 'Accetta',
                'link': '{{ $labelSite['cookiebar_leggi_informativa'] }}',
                'href': '{{ url('cookie') }}'
            }
        })});
</script>

@yield('after_scripts')
</body>
</html>
