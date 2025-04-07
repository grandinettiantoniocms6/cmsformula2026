<?php
    $website = \App\Models\WebsiteSetting::first();
    $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

    $titleBlocco = json_decode($item->title, true);
    if($titleBlocco){
        if(!key_exists(\App::getLocale(), $titleBlocco)){
            $titleBlocco[\App::getLocale()] = "";
        }
    }else{
        $titleBlocco[\App::getLocale()] = "";
    }

    $descriptionBlocco = json_decode($item->description, true);
    if($descriptionBlocco){
        if(!key_exists(\App::getLocale(), $descriptionBlocco)){
            $descriptionBlocco[\App::getLocale()] = "";
        }
    }else{
        $descriptionBlocco[\App::getLocale()] = "";
    }

?>

@if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-xl-12 col-lg-8 text-center position-relative page-title-double-large">
                <div class="d-flex flex-column justify-content-center extra-very-small-screen">
                    <h1 class="text-dark-gray alt-font ls-minus-1px fw-700 mb-20px">{{ $titleBlocco[\App::getLocale()] }}</h1>
                    <h2 class="d-inline-block fw-400 ls-0px w-80 xs-w-100 mx-auto">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="block-grids style-{{ $item->style }}" id="block-grids-{{ $item->id }}" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-12 filter-content">
                <ul class="portfolio-boxed portfolio-wrapper grid-loading grid grid-{{ $item->col }}col grid-{{ $item->col }}col xxxl-grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-{{ $item->col }}col md-grid-{{ $item->col }}col sm-grid-1col xs-grid-1col gutter-large text-center">
                    <li class="grid-sizer"></li>

                        @if($array)
                            @foreach($array as $value)
                               <?php

                            $title = json_decode($value->title, true);
                            if($title === null){
                                $title = [];
                            }

                            $description = json_decode($value->description, true);
                            if($description === null){
                                $description = [];
                            }

                            $text_etichetta = json_decode($value->text_etichetta, true);
                            if($text_etichetta === null){
                                $text_etichetta = [];
                            }

                            $url_interno = json_decode($value->url_interno, true);
                            if($url_interno === null){
                                $url_interno = [];
                            }

                            $url_esterno = json_decode($value->url, true);
                            if($url_esterno === null){
                                $url_esterno = [];
                            }

                            $button = json_decode($value->button, true);
                            if($button === null){
                                $button = [];
                            }

                            $type_href = $value->type_href;

                            $url = "#";
                            if(key_exists(\App::getLocale(), $url_interno)){
                                if(trim($url_interno[\App::getLocale()]) != ""){
                                    $url = "/{$url_interno[\App::getLocale()]}";
                                }
                            }
                            if(key_exists(\App::getLocale(), $url_esterno)){
                                if(trim($url_esterno[\App::getLocale()]) != ""){
                                    $url = $url_esterno[\App::getLocale()];
                                }
                            }

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $description)){
                                $description[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $button)){
                                $button[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $url_interno)){
                                $url_interno[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $url_esterno)){
                                $url_esterno[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $text_etichetta)){
                                $text_etichetta[\App::getLocale()] = "";
                            }

                            // serve per le thumb

                            $photo = $value->foto;

                            if($photo){
                                $basename = basename($photo);
                                $temp = explode(".", $basename);

                                $check = "thumb/blocks_grids/$temp[0]-large.webp";
                                if(file_exists($check)){
                                    $foto = url($check);
                                }else{
                                    $foto = url($photo);
                                }
                            }
                            ?>

                                <!-- start portfolio item -->
                                <li class="grid-item transition-inner-all">
                                    <div class="portfolio-box border-radius-4px">
                                        <div class="portfolio-image border-radius-4px">

                                            @if(trim($value->foto) != "")
                                                <img src="{{ $foto }}" alt="" />
                                            @else
                                                 <img src="{{ url("img/no-image.jpg") }}" alt="" />
                                            @endif

                                            <div class="portfolio-hover d-flex justify-content-center flex-column">
                                                <div class="portfolio-icon d-flex flex-row justify-content-center align-items-center">
                                                    @if($url != "#")
                                                        <a href="{{ $url }}" target="{{ $type_href }}" class="d-flex flex-column justify-content-center text-dark-gray text-dark-gray-hover rounded-circle bg-white w-60px h-60px move-bottom-top">
                                                            <i class="feather icon-feather-link fw-600" aria-hidden="true"></i>
                                                        </a>
                                                   @endif
                                                </div>

                                            </div>
                                                <div class="portfolio-overlay bg-dark-gray" style="background-color: #637c8e;"></div>
                                        </div>

                                        <div class="portfolio-caption pt-30px pb-30px lg-pt-20px lg-pb-20px">
                                            <div class="blog-categories">
                                                <span class="categories-btn text-uppercase alt-font fw-700" style="font-size: 16px!important; margin-bottom: 8px; background-color: {!! $value->bgcolor !!}; color: {!! $value->txtcolor !!};">{{ $text_etichetta[\App::getLocale()] }}</span>
                                            </div>

                                            <div class="fw-600 fs-18 lh-30 text-uppercase" style="color: {{ $item->title_color }}!important;">{{ $title[\App::getLocale()] }}</div>
                                            <span>{!! $description[\App::getLocale()] !!}</span>

                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" href="{{ $url }}" class="btn btn-very-small" style="background-color:{{ $website-> btn_background }}; color:{{  $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};"><span>{{ $button[\App::getLocale()] }}</span></a>
                                            @endif

                                            <!-- If PDF exist -->
                                            @if(trim($value->file) != "" || $value->file)
                                                <a href="{{ $value->file }}" target="_blank" class="btn btn-base-color btn-very-small">
                                                    <span><i class="far fa-file-pdf"></i> {{ @$labels['pdf-download'] }}</span>
                                                </a>
                                            @endif
                                        </div>

                                    </div>
                                </li>
                                <!-- end portfolio item -->

                            @endforeach
                       @endif
                </ul>
            </div>

        </div>
    </div>
</section>
