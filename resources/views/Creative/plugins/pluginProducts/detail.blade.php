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

    @if($adminPlugin->version == 3)

    <!-- Keivan se mi usi questi file dentro Shoppy ci saranno sempre problemi con icone e font riode!!! -->
        <!-- Main CSS File -->
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/fontawesome-free/css/all.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/animate/animate.min.css") }}">

        <!-- Plugins CSS File -->
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/magnific-popup/magnific-popup.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/owl-carousel/owl.carousel.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/photoswipe/photoswipe.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ url("templates/Shoppy/vendor_plugins/photoswipe/default-skin/default-skin.min.css") }}">

        <!-- Css Shoppy personalizzato -->
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
    <title>@if($itemProduct && trim($itemProduct->meta_title != "")) {{ $website->title }} - {{ $itemProduct->meta_title }} @else {{ $itemProduct->title }} @endif</title>
    @if($itemProduct && (trim($itemProduct->meta_description) != ""))
        <meta name="description" content="{{ $itemProduct->meta_description }}">
    @else
        <meta name="description" content="{{ $website->meta_description }}">
    @endif
    @if($itemProduct && (trim($itemProduct->meta_key) != ""))
        <meta name="keywords" content="{{ $itemProduct->meta_key }}">
    @else
        <meta name="keywords" content="{{ $website->meta_keywords }}">
    @endif
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
               <section class="page-title slider-parallax parallax" data-jarallax="{&quot;speed&quot;: 0.6}" style="@if($plugin->image_height) height:{{ $plugin->image_height }}px; @endif background-image: url({{ url($itemProduct->cover_photo) }});">
                   <div class="container">
                       <div class="row">
                           <div class="col-lg-12">
                               <div class="page-title-name">
                                   @if($page->color_title_page)
                                       <h1 style="color: {{ $page->color_title_page }}">{{ $plugin->title }}</h1>
                                   @else
                                       <h1>{{ $plugin->title }}</h1>
                                   @endif

                                   @if($page->color_subtitle_page)
                                       <p style="color: {{ $page->color_subtitle_page }}">{{ $plugin->subtitle }}</p>
                                   @else
                                       <p>{{ $plugin->subtitle }}</p>
                                   @endif
                               </div>
                           </div>
                       </div>
                   </div>
               </section>
          @else
               @if($plugin->image)
                   <!-- <section class="page-title slider-parallax parallax" data-jarallax="{&quot;speed&quot;: 0.6}" style="@if($plugin->image_height) height:{{ $plugin->image_height }}px; @endif background-image: url({{ url($plugin->image) }});"> -->
               @else
                   <!-- <section class="page-title" style="display: block;
                        padding-top: 100px;
                        padding-bottom: 100px;
                        position: relative;">
                   </section>-->
                @endif
           @endif


        @if($adminPlugin->version == 3)
            @include("common.pluginProducts.shop.detail")
        @else
            <section class="shop grid py-4 py-lg-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3" id="sidebar-shop">
                            {{--@include("$thema.plugins.pluginProducts.inc.sidebar")--}}
                            @include("common.pluginProducts.inc.sidebar")
                        </div>
                        <div class="col-lg-9">

                            <!-- pulsante filtro: visualizzato solo da step md in giù -->
                            <div class="d-lg-none mb-4">
                                <button class="btn btn-light btn-sm px-2 py-1" id="btn-filter" data-toggle="show" data-target="#sidebar-shop">
                                    <i class="fa fa-filter"></i><span class="pl-1">Filtri</span>
                                </button>
                            </div>
                            <!-- ## pulsante filtro: visualizzato solo da step md in giù ## -->

                            @if($itemProduct)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="slider-slick">
                                            @if(count($itemProduct->images))
                                                {{-- <div class="slider slider-for detail-big-car-gallery"> --}}
                                                <div class="popup-gallery slider-for detail-big-car-gallery">
                                                    @foreach($itemProduct->images as $image)
                                                        <?php
                                                        if(is_numeric(strpos($image->image, "uploads"))){
                                                            $url = url("$image->image");
                                                        }else{
                                                            $url = url("uploads/products/$image->image");
                                                        }
                                                        ?>

                                                        <a class="popup portfolio-img" href="{{ $url }}">
                                                            <img class="img-fluid" src="{{ $url }}" alt="">
                                                        </a>
                                                    @endforeach
                                                </div>
                                                <div class="slider slider-nav">
                                                    @foreach($itemProduct->images as $image)
                                                        <?php
                                                        if(is_numeric(strpos($image->image, "uploads"))){
                                                            $url = url("$image->image");
                                                        }else{
                                                            $url = url("uploads/products/$image->image");
                                                        }
                                                        ?>

                                                        <img class="img-fluid" src="{{ $url }}" alt="">
                                                    @endforeach
                                                </div>
                                            @else
                                                <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <!-- Nome prod e descr breve -->
                                        <div class="product-detail clearfix">
                                            <div class="product-detail-title mb-20 sm-mt-40">
                                                <h5 class="mb-10">{{ $itemProduct->name }}</h5>
                                                {{-- <span>{{ $itemProduct->description_short }} </span> --}}
                                            </div>
                                            <!-- Prezzo se attivo -->
                                            <div class="clearfix mb-30">
                                                @if($plugin->show_prices && $itemProduct->price !== null && trim($itemProduct->price) != "")
                                                    <div class="product-detail-price">
                                                        @if($itemProduct->in_promo == 1)
                                                            @if($itemProduct->promo_price < $itemProduct->price)
                                                                <ins>&euro; {{ number_format($itemProduct->promo_price, 2, ",", ".") }}</ins>
                                                                <del class="badge badge-primary badge-size-normal badge-weight-normal">&euro; {{ number_format($itemProduct->price, 2, ",", ".") }}</del>
                                                            @else
                                                                <ins>&euro; {{ number_format($itemProduct->price, 2, ",", ".") }}</ins>
                                                            @endif
                                                        @else
                                                            <ins>&euro; {{ number_format($itemProduct->price, 2, ",", ".") }}</ins>
                                                        @endif
                                                    </div>

                                                    @include("common.pluginProducts.promo")
                                                @endif
                                            </div>

                                            <!-- Dettagli: q.ta - sku - categ - tags  -->
                                            <div class="clearfix mb-30">
                                                <div class="product-detail-meta">

                                                    @if($plugin->show_quantities == 1 && $itemProduct->qty != null)
                                                        <span>{{ @$labels['qty'] }}: {{ $itemProduct->qty }} </span> <br>
                                                    @endif

                                                    <span>{{ @$labels['sku'] }}: {{ $itemProduct->sku }} </span> <br>

                                                    <span>{{ @$labels['categoria'] }}:
                                                        <?php
                                                           $cat_prod = $itemProduct->category();
                                                        ?>
                                                        @if($cat_prod)
                                                            <a href="{{ route("pluginProducts.".\App::getLocale(), [$cat_prod->slug]) }}">{{ $cat_prod->name }}</a>
                                                        @endif
                                                    </span>
                                                    <br>
                                                    @if($itemProduct->tags != "")
                                                        <?php
                                                        $tags = explode(",", $itemProduct->tags);
                                                        ?>
                                                        @if(count($tags) > 0)
                                                            <span class="tag-row">{{ @$labels['tags'] }}:
                                                            @foreach($tags as $itemTag)
                                                                    <a href="{{ route("pluginProductsTags.".\App::getLocale(), $itemTag) }}">{{ $itemTag }}</a>
                                                                @endforeach
                                                        </span>
                                                        @endif
                                                    @endif
                                                    <br>
                                                </div>
                                            </div>
                                            <!-- / dettagli -->

                                            <!-- Pulsanti prodotto -->
                                            <div class="product-detail-des mb-30">
                                                @if($plugin->is_print_pdf == 1)
                                                    <p class="mb-30"><a class="button btn-block" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};" href="{{ route("pluginProducts.pdf.".\App::getLocale(), $itemProduct->id) }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ @$labels['scarica-pdf'] }}</a> </p>
                                                @endif
                                                @if($plugin->show_form_contact == 1)
                                                    <p class="mb-30"><a class="button btn-block" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};" href="#form_contact"><i class="fa fa-eur"></i> <span style="color: {{ $website->btn_txt_color }}"> {{ @$labels['richiedi-preventivo'] }}</a> </span></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-lg-12 col-md-12">
                                        <br><h4>{{ @$labels['description-long'] }}</h4>
                                        {!! $itemProduct->description !!}
                                        @include("$thema.plugins.pluginProducts.inc.video")
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tab tab-border mt-50">
                                            <?php
                                            $activeTab1 = "";
                                            $activeTab2 = "";
                                            if(count($itemProduct->options) > 0){
                                                $activeTab1 = "active show";
                                            }else{
                                                $activeTab2 = "active show";
                                            }
                                            ?>

                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                @if(count($itemProduct->options))
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo $activeTab1;?>" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="false">{{ @$labels['proprieta-prodotto'] }} </a>
                                                    </li>
                                                @endif
                                                @if(count($itemProduct->attachmentsList))
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo $activeTab2;?>" id="additional-tab2" data-toggle="tab" href="#additional2" role="tab" aria-controls="additional2" aria-selected="false">{{ @$labels['allegati-prodotto'] }} </a>
                                                    </li>
                                                @endif
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade <?php echo $activeTab1;?>" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                                                    @if(count($itemProduct->options))
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                            @foreach($itemProduct->options as $option)
                                                                <?php
                                                                $name = json_decode($option->name, true);
                                                                if(!key_exists(\App::getLocale(), $name)){
                                                                    continue;
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <th scope="row"> {{ $name[\App::getLocale()] }}</th>
                                                                    <td>{{ $option->value }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </div>

                                                <div class="tab-pane fade <?php echo $activeTab2;?>" id="additional2" role="tabpanel" aria-labelledby="additional-tab2">
                                                    @include("$thema.plugins.pluginProducts.inc.attachments")
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    @include("$thema.plugins.pluginProducts.inc.productRelated")
                                    @include("$thema.plugins.pluginProducts.inc.formContact")

                                </div>
                            @endif
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
        <script src="{{ url("templates/Shoppy/vendor_plugins/imagesloaded/imagesloaded.pkgd.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/sticky/sticky.min.js") }}"></script>

        @if($shopSetting->delete_zoom_hover != 1)
            <script src="{{ url("templates/Shoppy/vendor_plugins/elevatezoom/jquery.elevatezoom.min.js") }}"></script>
        @endif

        <script src="{{ url("templates/Shoppy/vendor_plugins/magnific-popup/jquery.magnific-popup.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/owl-carousel/owl.carousel.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/photoswipe/photoswipe.min.js") }}"></script>
        <script src="{{ url("templates/Shoppy/vendor_plugins/photoswipe/photoswipe-ui-default.min.js") }}"></script>
        <!-- Main JS File -->
        <script src="{{ url("templates/Shoppy/js/basicshop.js") }}"></script>

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

            function click_radio(val){
                if(val != ""){
                    var token = '{{ csrf_token() }}';
                    var product_id = "{{ $itemProduct->id }}";
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('get_second_attribute_detail_product') }}',
                        data: 'radio=1&product_id='+product_id+'&val='+val+'&_token=' + token,
                        dataType: 'json',
                        success: function (data) {

                            if(data.redirect == 1 && data.slug){
                                window.location.href = data.slug;
                            }else{
                                if(data.slug){
                                    window.location.href = data.slug;
                                }else{
                                    $('#second_attribute_box').html(data.contents);
                                }
                            }

                        },
                        error: function() {}
                    });
                }
            }
        </script>
    @endif
@endsection
