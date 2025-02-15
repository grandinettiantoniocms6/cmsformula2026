<?php $thema = env('TEMA'); ?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")
@endsection

@section('meta')
    <title>@if($itemProduct && trim($itemProduct->meta_title != "")) {{ $website->title }} - {{ $itemProduct->meta_title }} @else {{ $itemProduct->title }} @endif</title>
    @if($itemProduct && (trim($itemProduct->meta_description != "")))
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

@section('header_menu')
    @include("$thema.inc.header_menu")
@endsection

@section('content')
    <section class="page-title slider-parallax parallax" data-jarallax="{&quot;speed&quot;: 0.6}"
             @if($plugin->image)
             style="background-image: url({{ url($plugin->image) }});"
        @endif
    >
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

    @if($itemProduct)
        <!-- HTML SHOPPY -->
        <main class="main mt-6 single-product">
                        <div class="page-content mb-10 pb-6">
                            <div class="container">
                                <div class="product product-single row mb-7">
                                    <div class="col-md-6 sticky-sidebar-wrapper">
                                        @if(count($itemProduct->images))
                                        <div class="product-gallery pg-vertical sticky-sidebar"
                                             data-sticky-options="{'minWidth': 767}">
                                            <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1">
                                                @foreach($itemProduct->images as $image)
                                                    <figure class="product-image">
                                                        <img src="{{ url("uploads/products/$image->image") }}"
                                                             data-zoom-image="{{ url("uploads/products/$image->image") }}"
                                                             alt="" width="800" height="900">
                                                    </figure>
                                                @endforeach
                                            </div>
                                            @foreach($itemProduct->images as $image)
                                                <div class="product-thumbs-wrap">
                                                    <div class="product-thumbs">
                                                        <div class="product-thumb active">
                                                            <img src="{{ url("uploads/products/$image->image") }}" alt=""
                                                                 width="109" height="122">
                                                        </div>
                                                    </div>
                                                    <button class="thumb-up disabled"><i class="fas fa-chevron-left"></i></button>
                                                    <button class="thumb-down disabled"><i class="fas fa-chevron-right"></i></button>
                                                </div>
                                            @endforeach

                                            <div class="product-label-group">
                                                <label class="product-label label-new">new</label>
                                            </div>

                                            @else
                                                <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="">
                                        @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="product-details">
                                            <h1 class="product-name">{{ $itemProduct->name }}</h1>
                                            <div class="product-meta">

                                                @if($plugin->show_quantities == 1 && $itemProduct->qty != null)
                                                    <span>{{ @$labels['qty'] }}: {{ $itemProduct->qty }} </span> <br>
                                                @endif

                                                <span class="product-sku">{{ @$labels['sku'] }}: {{ $itemProduct->sku }} </span> <br>
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

                                            </div>
                                            <!-- Prezzo se attivo -->
                                            <div class="product-price">
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

                                            <p class="product-short-desc">{{ $itemProduct->description_short }}</p>

                                            <div class="product-form product-variations product-size">
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
                                            <hr class="product-divider">

                                            <div class="product-footer">
                                                <div class="social-links mr-4">
                                                    <a href="#" class="social-link social-facebook fab fa-facebook-f"></a>
                                                    <a href="#" class="social-link social-twitter fab fa-twitter"></a>
                                                    <a href="#" class="social-link social-pinterest fab fa-pinterest-p"></a>
                                                </div>
                                                <span class="divider d-lg-show"></span>
                                                <a href="#" class="btn-product btn-wishlist mr-6"><i class="d-icon-heart"></i>Add to
                                                    wishlist</a>
                                                <a href="#" class="btn-product btn-compare"><i class="d-icon-compare"></i>Add
                                                    to
                                                    compare</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                        </div>
                    </main>
        <!-- / HTML SHOPPY -->


    @endif

@endsection

@section('content_footer')
    <?php  $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
    @include("$thema.inc.content_footer")
@endsection
@else
    @include("$thema.inc.content_offline")
@endif


