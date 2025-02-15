<?php
$thema = env('TEMA');
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")
    @if($adminPlugin->version == 3)
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/fontawesome-free/css/all.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/animate/animate.min.css") }}">

        <!-- Plugins CSS File -->
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/magnific-popup/magnific-popup.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/owl-carousel/owl.carousel.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/nouislider/nouislider.min.css") }}">

        <!-- Main CSS File -->
        @if($website->style_css_shoppy)
            <link rel="stylesheet" type="text/css" href="{{ url("$website->style_css_shoppy") }}" />
        @else
            <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/css/style.min.css") }}">
        @endif

        <link rel="stylesheet" type="text/css" href="{{ url("css_common/basic_shoppy_fix.css") }}">
        <style>
            .btn-shoppy:hover {
                background-color: {{ $website->btn_hover_background }}!important;
            }
        </style>
    @endif
@endsection

@section('meta')
    @include("$thema.inc.meta")
@endsection
@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @include("$thema.inc.topbar")
    @endsection

@section('topbar_ecommerce')
    @include("$thema.inc.topbar_ecommerce")
@endsection

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content')
             @if($category && $category->image)
                 <section class="page-title small" style="@if($plugin->image_height) height:{{ $plugin->image_height }}px; @endif background-image: url({{ url($category->image) }}); background-position: center; background-size: cover; background-repeat: no-repeat; position: relative;">
                 <!-- <section class="page-title small slider-parallax parallax" data-jarallax="{&quot;speed&quot;: 0.6}" style="@if($plugin->image_height) height:{{ $plugin->image_height }}px; @endif background-image: url({{ url($category->image) }});"> -->
             @else
                @if($plugin->image)
                     <section class="page-title small" style="@if($plugin->image_height) height:{{ $plugin->image_height }}px; @endif background-image: url({{ url($plugin->image) }}); background-size: cover; background-repeat: no-repeat; position: relative;">
                 @else
                     <section style="display: block;
                         padding-top: 60px;
                         padding-bottom: 100px;
                         position: relative;">

                 @endif
             @endif
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title-name">

                            @if($page->color_title_page)
                                <br><h4 style="color: {{ $page->color_title_page }}">{{ $plugin->title }}</h4>
                            @else
                                <h4>{{ $plugin->title }}</h4>
                            @endif

                            @if($page->color_subtitle_page)
                                <p style="color: {{ $page->color_subtitle_page }}">{{ $plugin->subtitle }}
                            @else
                                <p>{{ $plugin->subtitle }}</p>
                            @endif

                            @if($category)
                                <i class="fa fa-angle-double-right"></i> {{ $category->name }} </p>
                            @endif


                        </div>


                    </div>
                </div>
            </div>
        </section>

        @if($adminPlugin->version == 3)
            @include("common.pluginProducts.shop.productList")
        @else
            <section class="shop grid py-4 py-lg-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3" id="sidebar-shop">
                            @include("common.pluginProducts.inc.sidebar")
                        </div>
                        <div class="col-lg-9">
                            @include("common.pluginProducts.inc.productList")
                            @include("$thema.plugins.pluginProducts.inc.brands")
                        </div>
                    </div>
                </div>
            </section>
        @endif

    @endsection

    @section('content_footer')
        <?php  $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif

@section('after_scripts')
    @if($adminPlugin->version == 3)
        <script src="{{ url("templates/Shoppy/vendor_plugins/sticky/sticky.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/imagesloaded/imagesloaded.pkgd.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/elevatezoom/jquery.elevatezoom.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/magnific-popup/jquery.magnific-popup.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/owl-carousel/owl.carousel.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/nouislider/nouislider.min.js") }}"></script>
        <!-- Main JS File -->
       <script src="{{ url("templates/Shoppy/js/basicshop.js") }}"></script>

         <script type="text/javascript">
             function reload_list(){
                 var order_by = $("#order_by").val();
                 var show_number =  $("#show_number").val();

                 @if(isset($_GET['search']))
                     $.ajax({
                         type: 'GET',
                         url: "?search={{ $_GET['search'] }}&order_by="+order_by+"&show_number="+show_number,
                         success: function (data) {
                             $("#box_pagination").hide();
                             $("#box_result_products").html(data.html);
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

                             $("#box_pagination").hide();
                             $("#box_result_products").html(data.html);

                             $("#box_attributes_filters").html(data.html_filter_attributes);
                             $("#box_tags_filters").html(data.html_filter_tags);
                             $("#box_prices_filters").html(data.html_filter_prices);

                             $("#pre-loader").hide();

                             /** console.log(data); */
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
                 $("#box_result_products").html("Caricamento...");
                 $("#box_pagination").hide();

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

                         $("#box_pagination").hide();
                         $("#box_result_products").html(data.html);
                         $("#box_attributes_filters").html(data.html_filter_attributes);
                         $("#box_tags_filters").html(data.html_filter_tags);
                         $("#box_prices_filters").html(data.html_filter_prices);

                         $("#back-to-top > a").trigger( 'click' );

                         $("#pre-loader").hide();

                         console.log(data);
                     },
                     error: function() {}
                 });
             }

             function apply_price_max(){
                 $('#pre-loader').show();
                 $("#box_result_products").html("Caricamento...");
                 $("#box_pagination").hide();

                 var order_by = $("#order_by").val();
                 var show_number =  $("#show_number").val();

                 var output = $("#myRange").val();

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

                         $("#box_result_products").html(data.html);
                         $("#box_attributes_filters").html(data.html_filter_attributes);
                         $("#box_tags_filters").html(data.html_filter_tags);
                         $("#box_prices_filters").html(data.html_filter_prices);

                         $('#pre-loader').hide();

                         /** console.log(data); */
                     },
                     error: function() {}
                 });

                 console.log(output);
             }

             function filtersCounter() {
                 /** var count = $('#sidebar input:checked').length;
                 if (count>0) {
                     $('#btn-filter .counter').text('('+count+')');
                 } else {
                     $('#btn-filter .counter').text('');
                 } **/
             }

             $(document).on('click', '.pagination a', function(event){
                 event.preventDefault();
                 var page = $(this).attr('href').split('page=')[1];

                 $('#pre-loader').show();
                 $("#box_result_products").html("Caricamento...");
                 $("#box_pagination").hide();

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

                         $("#box_result_products").html(data.html);
                         $("#box_attributes_filters").html(data.html_filter_attributes);
                         $("#box_tags_filters").html(data.html_filter_tags);
                         $("#box_prices_filters").html(data.html_filter_prices);

                         $("#back-to-top > a").trigger( 'click' );

                         $('#pre-loader').hide();

                         /** console.log(data); */
                     },
                     error: function() {}
                 });
             });


             var slider = document.getElementById("myRange");
             var output = document.getElementById("resultRange");
             //output.innerHTML = ""; //slider.value; // Display the default slider value

             // Update the current slider value (each time you drag the slider handle)
             slider.oninput = function() {
                 output.innerHTML = "Prezzo massimo: "+parseFloat(this.value).toFixed(2)+" &euro;";
             }

         </script>
    @endif


@endsection
