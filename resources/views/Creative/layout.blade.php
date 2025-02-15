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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css">
    <!-- Css per personalizzazioni extra commons -->
    @if($website->custom_css)
        <link rel="stylesheet" href="{{ url("$website->custom_css") }}">
    @endif
    <style>
        .btn-shoppy:hover {
            background-color: {{ $website->btn_hover_background }}!important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>

    @if($website->custom_css_style)
        <style>
            {!! $website->custom_css_style !!}
        </style>
    @endif
    <!-- Cookie Consent -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />

    <?php
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
    $plugin = \App\Models\PluginProductsSettings::first();
    ?>
    @if($adminPlugin->version >= 2)
        @if($plugin->color_hover_autocomplete_topbar_ecommerce)
            <style>
                /*.topbar .ui-menu .ui-menu-item {
                    color: red;
                }*/

                .widget-search .ui-widget.ui-menu .ui-menu-item-wrapper.ui-state-active,
                .search-results-autocomplete .ui-widget.ui-menu .ui-menu-item-wrapper.ui-state-active {
                    background: {{ $plugin->color_hover_autocomplete_topbar_ecommerce }};
                    color: #fff;
                }
            </style>
        @endif
    @endif
@include('common.tag_analytics')
@include('common.mailchimp')

@include('common.recaptcha')
@yield('recaptcha')

</head>
<body>
<?php
    //serve per leggere le label da amdin
    $labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>

<div id="modal_view"></div>
<div class="main-page-wrapper nicescroll">


    <section>
        <div id="preloader">
            <div id="ctn-preloader" class="ctn-preloader">
                <div class="animation-preloader">
                    <div class="icon">
                        @if($website->logo2)
                            <img src="{{ url($website->logo2) }}" alt="" class="m-auto d-block"> <span></span>
                        @else
                            {{ $website->title }}
                        @endif
                    </div>
                    <div class="txt-loading mt-4">
								<span data-text-preloader="." class="letters-loading">
									.
								</span>
                        <span data-text-preloader="." class="letters-loading">
									.
								</span>
                        <span data-text-preloader="." class="letters-loading">
									.
								</span>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($website->header_background)
        <header id="header" class="theme-main-menu sticky-menu theme-menu-one" style="height: {{ $website->menubar_height }};!important; background-color: {{ $website->header_background }}!important;">
    @else
        <header id="header" class="theme-main-menu sticky-menu theme-menu-one">
    @endif
    @yield('header_menu')

        </header>

    @yield('content_header')
    @yield('content')
    @include('common.tag_analytics_shiny')
    @yield('content_footer')


<button class="scroll-top" style="background-color: {{ $website->btn_background }};">
    <i class="bi bi-arrow-up-short"></i>
</button>

<!-- jquery -->
<script src="{{ url("templates/Creative/vendor/jquery.min.js") }}"></script>
<!-- Fancybox -->
<script src="{{ url("templates/Creative/vendor/fancybox/dist/jquery.fancybox.min.js") }}"></script>
<!-- Bootstrap JS -->
<script src="{{ url("templates/Creative/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- AOS js -->
<script src="{{ url("templates/Creative/vendor/aos-next/dist/aos.js") }}"></script>
<!-- Slick Slider -->
<script src="{{ url("templates/Creative/vendor/slick/slick.min.js") }}"></script>
<!-- js Counter -->
<script src="{{ url("templates/Creative/vendor/jquery.counterup.min.js") }}"></script>
<script src="{{ url("templates/Creative/vendor/jquery.waypoints.min.js") }}"></script>
<!-- MixIt Up -->
<script src="{{ url("templates/Creative/vendor/mixitup-3/mixitup.min.js") }}"></script>
<!-- isotop -->
<script  src="{{ url("templates/Creative/vendor/isotope.pkgd.min.js") }}"></script>
<!-- Theme js -->
<script src="{{ url("templates/Creative/js/theme.js") }}"></script>
<!-- Custom -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

@include('common.engine_customerly')
@include('common.engine_popup_modal_creative')
@include('common.script_autocomplete')
@include('common.engine_wapp')
@include('common.js_common')
<script>
    $( "div.alert-success" ).fadeIn( 300 ).delay( 5000 ).fadeOut( 500 );
</script>

<script>
    $( "div.alert-warning" ).fadeIn( 300 ).delay( 5000 ).fadeOut( 500 );
</script>

<script>
    $( "div.alert-close" ).fadeIn( 300 ).delay( 2500 ).fadeOut( 500 );
</script>

<!-- Cookie Banner Basic o Iubenda -->
@if(trim($website->iubenda_cookie_banner) != "")
   {!! $website->iubenda_cookie_banner !!}
@else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
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
                    'message': '{{ $labelSite['cookiebar_message'] }}',
                    'dismiss': '{{ $labelSite['cookiebar_ok'] }}',
                    'allow': 'Accetta',
                    'link': '{{ $labelSite['cookiebar_leggi_informativa'] }}',
                    'href': '{{ url('cookie') }}'
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


<script type="text/javascript">
    function modal_view(id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('get.product_detail') }}',
            data: 'product_id='+id+'&_token=' + token,
            success: function (data) {
                $('#modal_view').html(data);

                $('#modalProductView').modal('show');

            },
            error: function() {}
        });
    }

    function modal_view_list_variant(id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('get.product_variant_list') }}',
            data: 'product_id='+id+'&_token=' + token,
            success: function (data) {
                $('#modal_view').html(data);
                $('#modalProductView').modal('show');

                //$("#box_variants_list_"+id).html(data);

            },
            error: function() {}
        });
    }

    function closeModalView(id){
        $('#modalProductView').modal('hide');
        $(".modal-backdrop").remove();
    }

    function add_compare(id){
        $.ajax({
            type: 'GET',
            url: '/add_compare/'+id+'?list=1',
            success: function (data) {
                $("#compare_"+id).html('<a href="javascript:remove_compare('+id+')" class="btn-product-icon" data-toggle="tooltip" title="Rimuovi da comparazione"><i class="far fa-minus-square"></i></a>');
                $('.tooltip').tooltip('dispose');
            },
            error: function() {}
        });
    }

    function remove_compare(id){
        $.ajax({
            type: 'GET',
            url: '/remove_compare/'+id+'?list=1',
            success: function (data) {
                $("#compare_"+id).html('<a href="javascript:add_compare('+id+')" class="btn-product-icon data-toggle="tooltip" title="Compara questo articolo"><i class="fas fa-exchange-alt"></i></a>');
                $('.tooltip').tooltip('dispose');
            },
            error: function() {}
        });
    }

    function add_modal_cart(id){
        $.ajax({
            type: 'POST',
            url: '{{ route('add.cart.product') }}',
            data: $("#modalFormProductView").serialize(), // serializes the form's elements.
            success: function (data) {
                var attuale = parseInt($("#cart_box").html());
                attuale++;

                $("#cart_box").html(attuale);

                var token = '{{ csrf_token() }}';
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get.product_detail') }}',
                    data: 'product_id='+id+'&_token=' + token,
                    success: function (data2) {
                        $('#modal_view').html(data2);
                        $('#modalProductView').modal('show');
                    },
                    error: function() {}
                });
            },
            error: function() {}
        });
    }

</script>

<script>
    function nascondi_password(id, iconid){
        const password = document.querySelector(id);
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        if(type == "text"){
            $(iconid).removeClass("fa-eye-slash");
            $(iconid).addClass("fa-eye");
        }else{
            $(iconid).removeClass("fa-eye");
            $(iconid).addClass("fa-eye-slash");
        }
    }
</script>

@yield('after_scripts')
</div>
</body>
</html>
