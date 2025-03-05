<?php
$thema = env('TEMA');
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$agent = new \Jenssegers\Agent\Agent();
$pluginSetting = \App\Models\PluginProductsSettings::first();
?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")
@endsection

@section('meta')
    @if($category)
        <title>{{ $website->title }} - {{ $category->name }}</title>
        <meta property="og:title" content="{{ $website->title }} - {{ $category->name }}" />
        <meta property="og:url" content="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>" />

        @if($category->meta_description)
            <meta name="description" content="{{ $category->meta_description }}">
            <meta property="og:description" content="{{ $category->meta_description }}" />
        @else
            <meta name="description" content="{{ $website->meta_description }}">
            <meta property="og:description" content="{{ $website->meta_description }}" />
        @endif

        <meta name="keywords" content="{{ $website->meta_keywords }}">

        @if($website->favicon)
            <meta property="og:image" content="{{ url("$website->favicon") }}" />
        @endif

        <meta property="og:type" content="website" />
    @else
        @include("$thema.inc.meta")
    @endif
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @include("$thema.inc.topbar")
    @endsection

@section('topbar_ecommerce')
@endsection

    @section('header_menu')
    @endsection

    @section('content')
        @if($agent->isMobile() || $agent->isTablet())
            @if($pluginSetting->show_banner)
                <section class="page-title-block image-wrapper bg-overlay bg-overlay-black-60 jarallax block-parallax" @if($plugin->image_height) style="height: {{ $plugin->image_height }}px" @endif>
                    @if($category && $category->image)
                        <img class="jarallax-img" src="{{ url($category->image) }}" alt="{{ env('APP_NAME') }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto">
                    @else
                        @if($plugin->image)
                            <img class="jarallax-img" src="{{ url($plugin->image) }}" alt="{{ env('APP_NAME') }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto">
                        @endif
                    @endif
                    <div class="container-fluid container-2xl">
                        @if($plugin->title)<h1 class="title">{{ $plugin->title }}</h1>@endif
                        @if($plugin->subtitle)<div class="subtitle">{{ $plugin->subtitle }}</div>@endif
                        @if($category)<h1 class="title">{{ $category->name }}</h1>@endif
                    </div>
                </section>
            @else
                <div class="container">
                    @if($category)
                        <h1 class="page-title">{{ $category->name }}</h1>
                    @else
                        @if($plugin->title)<h1 class="page-title">{{ $plugin->title }}</h1>@endif
                        @if($plugin->subtitle)<div class="page-subtitle">{{ $plugin->subtitle }}</div>@endif
                    @endif
                </div>
            @endif
        @else
            <section class="image-wrapper bg-overlay bg-overlay-black-60 jarallax block-parallax py-5" @if($plugin->image_height) style="height: {{ $plugin->image_height }}px" @endif>
                @if($category && $category->image)
                    <img class="jarallax-img" alt="{{ env('APP_NAME') }}" src="{{ url($category->image) }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto">
                @else
                    @if($plugin->image)
                        <img class="jarallax-img" alt="{{ env('APP_NAME') }}" src="{{ url($plugin->image) }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto">
                    @endif
                @endif
                <div class="container">
                    @if($category)
                        <h1 class="title">{{ $category->name }}</h1>
                    @else
                        @if($plugin->title)<h1 class="title">{{ $plugin->title }}</h1>@endif
                        @if($plugin->subtitle)<div class="subtitle">{{ $plugin->subtitle }}</div>@endif
                    @endif
                </div>
            </section>
        @endif

        @include("$thema.plugins.pluginProducts.v3.shop.productList", ['adminPlugin' => $adminPlugin])

    @endsection

    @section('content_footer')
        <?php $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif

@section('after_scripts')
    @if($adminPlugin)
       <script type="text/javascript">
             function reload_list(){
                 var order_by = $("#order_by").val();
                 var show_number =  $("#show_number").val();

                 @if(isset($_GET['search']))
                     $.ajax({
                         type: 'GET',
                         url: "?search={{ $_GET['search'] }}&order_by="+order_by+"&show_number="+show_number,
                         success: function (data) {
                             $('#box_pagination').hide();
                             $('#box_result_products').html(data.html);
                             console.log(data);
                         },
                         error: function() {}
                     });

                 @else

                     var urlClean = "<?php echo env('APP_URL');?><?php echo $_SERVER['REQUEST_URI']; ?>";
                     var url = new URL(urlClean);
                     var search_params = url.searchParams;

                     search_params.set('ajax', 1);
                     search_params.set('order_by', order_by);
                     search_params.set('show_number', show_number);

                     var filters = new Array("brands_check", "tags_check", "options_check");
                     $.each( filters, function( key, value ) {
                         var arr = getChecked(value);
                         if(arr.length > 0){
                             search_params.set(''+value+'', arr.join(","));
                         }else{
                             search_params.delete(''+value+'');
                         }
                     });

                     url.search = search_params.toString();
                     var new_url = url.toString();

                     $.ajax({
                         type: 'GET',
                         url: new_url,
                         success: function (data) {

                             $('#box_pagination').hide();
                             $('#box_result_products').html(data.html);

                             $('#box_attributes_filters').html(data.html_filter_attributes);
                             $('#box_tags_filters').html(data.html_filter_tags);
                             $('#box_prices_filters').html(data.html_filter_prices);

                             $('#pre-loader').hide();

                             scrollTop();
                         },
                         error: function() {}
                     });
                 @endif
             }

             function getChecked(className){
                 var arr = [];
                 var i= 0;
                 $('.'+className+':checked').each(function(){
                     arr[i++] = $(this).val();
                 });
                 return arr;
             }

             function filters_check(class_name){
                 $('#pre-loader').show();
                 $('#box_result_products').html("Caricamento...");
                 $('#box_pagination').hide();

                 var order_by = $("#order_by").val();
                 var show_number =  $("#show_number").val();

                 var urlClean = "<?php echo env('APP_URL');?><?php echo $_SERVER['REQUEST_URI']; ?>";
                 var url = new URL(urlClean);
                 var search_params = url.searchParams;

                 search_params.set('ajax', 1);
                 search_params.set('order_by', order_by);
                 search_params.set('show_number', show_number);

                 var filters = new Array("brands_check", "tags_check", "options_check");
                 $.each( filters, function( key, value ) {
                     var arr = getChecked(value);
                     if(arr.length > 0){
                         search_params.set(''+value+'', arr.join(","));
                     }else{
                         search_params.delete(''+value+'');
                     }
                 });

                 url.search = search_params.toString();
                 var new_url = url.toString();

                 $.ajax({
                     type: 'GET',
                     url: new_url,
                     success: function (data) {
                         if(data.redirect == 1){
                             window.location.href = "/"+data.slug;
                         }

                         $('#box_pagination').hide();
                         $('#box_result_products').html(data.html);
                         $('#box_attributes_filters').html(data.html_filter_attributes);
                         $('#box_tags_filters').html(data.html_filter_tags);
                         $('#box_prices_filters').html(data.html_filter_prices);

                         $('#back-to-top > a').trigger( 'click' );

                         $('#pre-loader').hide();

                         scrollTop();
                     },
                     error: function() {}
                 });
             }

             function apply_price_max(){
                 $('#pre-loader').show();
                 $('#box_result_products').html("Caricamento...");
                 $('#box_pagination').hide();

                 var order_by = $('#order_by').val();
                 var show_number =  $('#show_number').val();

                 var output = $('#myRange').val();

                 var urlClean = "<?php echo env('APP_URL');?><?php echo $_SERVER['REQUEST_URI']; ?>";
                 var url = new URL(urlClean);
                 var search_params = url.searchParams;

                 search_params.set('ajax', 1);
                 search_params.set('price_max', output);
                 search_params.set('order_by', order_by);
                 search_params.set('show_number', show_number);

                 var filters = new Array("brands_check", "tags_check", "options_check");
                 $.each( filters, function( key, value ) {
                     var arr = getChecked(value);
                     if(arr.length > 0){
                         search_params.set(''+value+'', arr.join(","));
                     }else{
                         search_params.delete(''+value+'');
                     }
                 });

                 url.search = search_params.toString();
                 var new_url = url.toString();

                 $.ajax({
                     type: 'GET',
                     url: new_url,
                     success: function (data) {
                         if(data.redirect == 1){
                             window.location.href = "/"+data.slug;
                         }

                         $('#box_result_products').html(data.html);
                         $('#box_attributes_filters').html(data.html_filter_attributes);
                         $('#box_tags_filters').html(data.html_filter_tags);
                         $('#box_prices_filters').html(data.html_filter_prices);
                         $('#pre-loader').hide();

                         scrollTop();
                     },
                     error: function(){}
                 });
             }

             $(document).on('click', '.pagination a', function(event){
                 event.preventDefault();
                 var page = $(this).attr('href').split('page=')[1];

                 $('#pre-loader').show();
                 $('#box_result_products').html("Caricamento...");
                 $('#box_pagination').hide();

                 var order_by = $("#order_by").val();
                 var show_number =  $("#show_number").val();

                 var urlClean = "<?php echo env('APP_URL');?><?php echo $_SERVER['REQUEST_URI']; ?>";
                 var url = new URL(urlClean);
                 var search_params = url.searchParams;

                 search_params.set('ajax', 1);
                 search_params.set('page', page);
                 search_params.set('order_by', order_by);
                 search_params.set('show_number', show_number);

                 var filters = new Array("brands_check", "tags_check", "options_check");
                 $.each( filters, function( key, value ) {
                     var arr = getChecked(value);
                     if(arr.length > 0){
                         search_params.set(''+value+'', arr.join(","));
                     }else{
                         search_params.delete(''+value+'');
                     }
                 });

                 url.search = search_params.toString();
                 var new_url = url.toString();

                 $.ajax({
                     type: 'GET',
                     url: new_url,
                     success: function (data) {
                         if(data.redirect == 1){
                             window.location.href = "/"+data.slug;
                         }

                         $('#box_result_products').html(data.html);
                         $('#box_attributes_filters').html(data.html_filter_attributes);
                         $('#box_tags_filters').html(data.html_filter_tags);
                         $('#box_prices_filters').html(data.html_filter_prices);
                         $('#pre-loader').hide();

                         scrollTop();
                     },
                     error: function() {}
                 });
             });

             @if($adminPlugin->version == 3)
                 var slider = document.getElementById('myRange');
                 var output = document.getElementById('resultRange');

                 slider.oninput = function() {
                     output.innerHTML = 'Prezzo massimo: ' + parseFloat(this.value).toFixed(2) + ' &euro;';
                 }
             @endif
         </script>
    @endif
@endsection
