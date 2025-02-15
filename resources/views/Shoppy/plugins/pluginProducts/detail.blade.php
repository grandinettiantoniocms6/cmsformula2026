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
        <section class="page-title bg-overlay-black-30 parallax" data-jarallax="{&quot;speed&quot;: 0.6}"
                @if($plugin->image)
                     style="background-image: url({{ url($plugin->image) }});"
                @endif
        >
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title-name">
                            <h1>{{ $plugin->title }}</h1>
                            <p>{{ $plugin->subtitle }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                                                 <a class="popup portfolio-img" href="{{ url("uploads/products/$image->image") }}">
                                                     <img class="img-fluid" src="{{ url("uploads/products/$image->image") }}" alt="">
                                                 </a>
                                            @endforeach
                                        </div>
                                        <div class="slider slider-nav">
                                            @foreach($itemProduct->images as $image)
                                                <img class="img-fluid" src="{{ url("uploads/products/$image->image") }}" alt="">
                                            @endforeach
                                        </div>
                                        @else
                                            <img class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <!-- Nome prod e descriz breve -->
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

                                        <!-- Pulsanti prodotto -->
                                        <div class="product-detail-des mb-30">
                                            @if($plugin->is_print_pdf == 1)
                                            <p class="mb-30"><a class="button btn-block" href="{{ route("pluginProducts.pdf.".\App::getLocale(), $itemProduct->id) }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ @$labels['scarica-pdf'] }}</a> </p>
                                            @endif
                                            @if($plugin->show_form_contact == 1)
                                                <p class="mb-30"><a class="button btn-block" href="#form_contact"><i class="fa fa-eur"></i> {{ @$labels['richiedi-preventivo'] }}</a> </p>
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
    @endsection

    @section('content_footer')
        <?php  $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


