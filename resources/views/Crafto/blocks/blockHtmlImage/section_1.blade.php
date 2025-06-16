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
    <section class="overflow-hidden bg-regal-blue position-relative border-radius-6px lg-border-radius-0px z-index-0">
        <div class="{{ $item->fullwidth }}">
            <div class="row align-items-center mb-6 sm-mb-9 text-center text-lg-start mt-5">
                <div class="col-lg-5 md-mb-20px">
                    <h3 class="text-dark fw-700 mb-0 ls-minus-1px">{{ $titleBlocco[\App::getLocale()] }}</h3>
                </div>
                <div class="col-lg-5 last-paragraph-no-margin md-mb-20px">
                    <p class="w-85 md-w-100">{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
                <div class="col-lg-2 d-flex justify-content-center justify-content-lg-end">
                    <!-- start slider navigation -->
                    <div class="slider-one-slide-prev-1 icon-extra-medium text-white swiper-button-prev slider-navigation-style-04 border border-1 border-color-transparent-dark-light">
                        <i class="feather icon-feather-chevron-left text-dark-gray"></i>
                    </div>
                    <div class="slider-one-slide-next-1 icon-extra-medium text-white swiper-button-next slider-navigation-style-04 border border-1 border-color-transparent-dark-light">
                        <i class="feather icon-feather-chevron-right text-dark-gray"></i>
                    </div>
                    <!-- end slider navigation -->
                </div>
            </div>
            @endif
            <div class="row align-items-center mb-6">
                <div class="col-12">
                    <div class="outside-box-right-25 sm-outside-box-right-0">
                        <div class="swiper slider-one-slide" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loop": true, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
                            <div class="swiper-wrapper">

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

                                            // serve per le thumb

                                            $photo = $value->foto;

                                            if($photo){
                                                $basename = basename($photo);
                                                $temp = explode(".", $basename);

                                                $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                                if(file_exists($check)){
                                                    $foto = url($check);
                                                }else{
                                                    $foto = url($photo);
                                                }
                                            }
                                            ?>

                                            <!-- start slider item -->
                                        <div class="swiper-slide">
                                            <!-- start interactive banner item -->
                                            <div class="interactive-banner-style-09 border-radius-6px overflow-hidden position-relative">
                                                @if(trim($value->foto) != "")
                                                    <img src="{{ $foto }}" alt="" />
                                                @endif

                                                <div class="opacity-extra-medium bg-gradient-dark-transparent"></div>
                                                <div class="image-content h-100 w-100 ps-15 pe-15 pt-13 pb-13 md-p-10 d-flex justify-content-bottom align-items-start flex-column">

                                                    <div class="mt-auto d-flex align-items-start w-100 z-index-1 position-relative overflow-hidden flex-column">
                                                        <span class="text-white fw-600 fs-20">{{ $title[\App::getLocale()] }}</span>
                                                        <span class="content-title text-white fs-13 fw-500 text-uppercase ls-05px">{!! $description[\App::getLocale()] !!}</span>
                                                        @if($url != "#")
                                                            <a href="{{ $url }}" target="{{ $type_href }}" class="content-title-hover fs-13 lh-24 fw-500 ls-05px text-uppercase text-white opacity-6 text-decoration-line-bottom">
                                                                {{ $button[\App::getLocale()] }}
                                                            </a>
                                                        @endif
                                                        <span class="content-arrow lh-42px rounded-circle bg-white w-50px h-50px ms-20px text-center"><i class="fa-solid fa-chevron-right text-dark-gray fs-16"></i></span>
                                                    </div>
                                                    <div class="position-absolute left-0px top-0px w-100 h-100 bg-gradient-regal-blue-transparent opacity-9">
                                                    </div>
                                                    <div class="box-overlay bg-gradient-base-color-transparent"></div>
                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="position-absolute z-index-1 top-0px left-0px h-100 w-100"></a>
                                                </div>
                                            </div>
                                            <!-- end interactive banner item -->
                                        </div>
                                        <!-- end slider item -->

                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

