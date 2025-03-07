<?php
$thema = env('TEMA');
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$cat_prod_name = "";
$cat_prod_slug = "no-categoria";
$cat_prod = $itemProduct->category();
if($cat_prod){
    $cat_prod_name = $cat_prod->name;
    $cat_prod_slug = $cat_prod->slug;
}
$shopSetting = \App\Models\ShopSettings::first();
?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")


@endsection

@section('recaptcha')
    @if($plugin->show_form_contact == 1 && $adminPlugin->version < 3)
         @include('common.recaptcha')
    @endif
@endsection

@section('player_video')
    @if($itemProduct->video)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.3/plyr.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.3/plyr.min.js" defer></script>
    @endif
@endsection

@section('meta')
    <title>@if($itemProduct && trim($itemProduct->meta_title != "")) {{ $website->title }} - {{ $itemProduct->meta_title }} @else {{ $itemProduct->title }} @endif</title>
    <meta property="og:title" content="@if($itemProduct && trim($itemProduct->meta_title != "")) {{ $website->title }} - {{ $itemProduct->meta_title }} @else {{ $itemProduct->title }} @endif" />
    <meta property="og:url" content="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>" />

    @if($itemProduct && (trim($itemProduct->meta_description) != ""))
        <meta name="description" content="{{ $itemProduct->meta_description }}">
        <meta property="og:description" content="{{ $itemProduct->meta_description }}" />
    @else
        <meta name="description" content="{{ $website->meta_description }}">
        <meta property="og:description" content="{{ $website->meta_description }}" />
    @endif
    @if($itemProduct && (trim($itemProduct->meta_key) != ""))
        <meta name="keywords" content="{{ $itemProduct->meta_key }}">
    @else
        <meta name="keywords" content="{{ $website->meta_keywords }}">
    @endif

    @if($website->favicon)
        <meta property="og:image" content="{{ url("$website->favicon") }}" />
    @endif

    <meta property="og:type" content="website" />
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
           @if($itemProduct->cover_photo)
               <section class="page-title-block image-wrapper bg-overlay bg-overlay-black-60 jarallax block-parallax py-5" @if($plugin->image_height) style="--page-title-height: {{ $plugin->image_height }}px;" @endif>
                   @if($itemProduct->cover_photo)
                       <?php
                       // serve per le thumb
                       $photo = $itemProduct->cover_photo;
                       if($photo){
                           $basename = basename($photo);
                           $temp = explode(".", $basename);

                           $check = "thumb/plugin_products_headers/$temp[0].webp";
                           if(file_exists($check)){
                               $foto = url($check);
                           }else{
                               $foto = url($photo);
                           }
                       }
                       ?>

                       <img class="jarallax-img" src="{{ $foto }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto" alt="{{ env('APP_NAME') }}">
                   @endif
                   <div class="container-fluid container-2xl">
                       <h1 class="page-title">{{ $plugin->title }}</h1>
                       <div  class="page-subtitle">{{ $plugin->subtitle }}</div>
                   </div>
               </section>
           @endif

           @include("$thema.plugins.pluginProducts.v3.shop.$plugin->layout_detail")
    @endsection

    @section('content_footer')
        <?php $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


@section('after_scripts')

        @if($shopSetting->delete_zoom_hover != 1)
            <script src="{{ url('templates/Webshop/js/vendor/jquery.zoom.min.js') }}"></script>
            <script>
                $(document).ready(function(){
                    if ($(window).width() > 767) {
                        $('.product-image').zoom();
                    }
                });
            </script>
        @endif

        @if($adminPlugin->version == 3)
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#first_attribute').change(function(){
                        var val = $(this).val();
                        if(val != ""){
                            var token = '{{ csrf_token() }}';
                            var product_id = "{{ $itemProduct->id }}";
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('get_second_attribute_detail_product') }}',
                                data: 'product_id='+product_id+'&val='+val+'&_token=' + token,
                                dataType: 'json',
                                success: function (data) {
                                    if(data.slug){
                                        window.location.href = data.slug;
                                    }else{
                                        $('#second_attribute_box').html(data.contents);
                                    }
                                },
                                error: function() {}
                            });
                        }
                    });
                });
                function redirectVariant(value){
                    var url = value.value;
                    if(url != ""){
                        window.location.href = url;
                    }
                }
            </script>
        @endif

        <script>
            $(document).ready(function() {
                /** Product Detail Carousel */
                var $owl1 = $('#image-carousel');
                var $owl2 = $('#thumb-carousel');
                var flag = false;

                $owl1.owlCarousel({
                    items: 1,
                    lazyLoad: false,
                    loop: false,
                    margin: 0,
                    nav: false,
                    dots: false,
                    responsiveClass: true
                }).on('changed.owl.carousel', function(e) {
                    if (!flag) {
                        flag = true;
                        $owl2.find('.owl-item').removeClass('current').eq(e.item.index).addClass('current');
                        if ( $owl2.find('.owl-item').eq(e.item.index).hasClass('active') ) {
                        } else {
                            $owl2.trigger("to.owl.carousel", [e.item.index, 300, true]);
                        }
                        flag = false;
                    }
                });

                $owl2.on('initialized.owl.carousel', function() {
                    $owl2.find('.owl-item').eq(0).addClass('current');
                }).owlCarousel({
                    items: 4,
                    lazyLoad: false,
                    loop: false,
                    margin: 5,
                    nav: false,
                    dots: true,
                    responsive: {
                        0: {
                            items: 4,
                        },
                        576: {
                            items: 4,
                        },
                        767: {
                            items: 4,
                        },
                        992: {
                            items: 4,
                        },
                        1200: {
                            items: 5,
                        }
                    },
                    responsiveClass: true
                }).on('click', '.owl-item', function(e) {
                    e.preventDefault();
                    var number = $(this).index();
                    $owl1.trigger('to.owl.carousel', [number, 300, true]);
                });
            });
        </script>
@endsection
