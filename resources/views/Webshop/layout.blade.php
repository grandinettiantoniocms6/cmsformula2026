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

    @include('Webshop.inc.engine_style')

    @if(is_numeric(strpos(env('APP_URL'), "stage")) || is_numeric(strpos(env('APP_URL'), "dev")))
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
    @endif

    <link rel="canonical" href="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>">

    @include('common.consent_solution_iubenda')
    @include('common.gdprtools')
    <!-- {!! \NoCaptcha::renderJs() !!} -->
    @include('common.tag_analytics')
    @include('common.mailchimp')

    @yield('recaptcha')

    @if($website->custom_css_style)
        <style>{!! $website->custom_css_style !!}</style>
    @endif
</head>

<body>


@include('common.engine_googlegta')
<div id="modal_view"></div>

<?php $labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray(); ?>

@yield('topbar')
@yield('header_menu')

<main id="main">
    @yield('content_header')
    @yield('content')
    @yield('content_footer')

    <div id="pre-loader"><img src="{{ url('templates/Webshop/img/loader.svg') }}" alt="Caricamento"></div>
</main>

<div id="back-to-top" role="button" aria-label="Torna Sopra"><i class="bi bi-chevron-up"></i></div>

@include('common.engine_customerly')
@include('Webshop.inc.script')
@include('Webshop.engine_popup_modal')
@include('common.tag_analytics_shiny')

@include('Webshop.inc.script_autocomplete')
@include('common.engine_wapp')
@include('common.js_common')

@yield('after_scripts')
@stack('custom_scripts')

@if(env('WAPP'))
    <script src="{{ url("css_common/whatsapp/plugin/whatsapp-chat-support.js") }}" class="_iub_cs_activate" type="text/plain" defer></script>
    <script src="{{ url("css_common/whatsapp/plugin/whatsapp-chat-init.js") }}" class="_iub_cs_activate" type="text/plain" defer></script>
@endif

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
                $('[data-bs-toggle="tooltip"]').tooltip('hide');
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
                $("#compare_"+id).html('<a href="javascript:remove_compare('+id+')" class="btn-product-icon" data-bs-toggle="tooltip" title="Rimuovi da comparazione"><i class="far fa-minus-square"></i></a>');
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
                $("#compare_"+id).html('<button onclick="add_compare('+id+')" class="btn-product-icon" data-bs-toggle="tooltip" title="Compara questo articolo"><i class="fas fa-exchange-alt"></i></button>');
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

</body>
</html>
