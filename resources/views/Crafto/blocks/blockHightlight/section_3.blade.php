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

    <?php
        $bgimage = $item->bgimage;
    ?>

    <section class="background-position-center-top pt-3 sm-pt-50px" style="@if($item->bgimage) background-image: url('{{ $item->bgimage }}') @endif; background-color: {{ $item->background_color }}!important;">
        <div class="{{ $item->fullwidth }}">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <span class="text-white text-uppercase fw-500 d-inline-block ls-1px fs-15">{{ $titleBlocco[\App::getLocale()] }}</span>
                    <h3 class="text-white fw-500 ls-minus-1px">{!! $descriptionBlocco[\App::getLocale()] !!}</h3>
                </div>
            </div>
            @endif

            <div class="row align-items-center mb-6" data-anime='{ "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-xl-12 col-lg-12 testimonials-style-10 position-relative ps-4 pe-4 swiper-number-pagination-progress" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="swiper sm-pt-3 pb-6" data-slider-options='{"slidesPerView": 1, "loop": true, "keyboard": { "enabled": true, "onlyInViewport": true }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "pagination": { "el": ".swiper-number-line-pagination", "clickable": true }, "navigation": { "nextEl": ".swiper-button-next-nav-01", "prevEl": ".swiper-button-previous-nav-01", "effect": "fade" } }' data-swiper-number-pagination-progress="true">
                        <div class="swiper-wrapper">

                                @if($array)
                                    @foreach($array as $value)
                                            <?php

                                            $title = json_decode($value->title, true);
                                            if($title === null){
                                                $title = [];
                                            }

                                            $abstract = json_decode($value->abstract, true);
                                            if($abstract === null){
                                                $abstract = [];
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

                                            if(!key_exists(\App::getLocale(), $abstract)){
                                                $abstract[\App::getLocale()] = "";
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

                                                $check = "thumb/blocks_hightlights/$temp[0]-large.webp";
                                                if(file_exists($check)){
                                                    $foto = url($check);
                                                }else{
                                                    $foto = url($photo);
                                                }
                                            }
                                            ?>

                                                <div class="swiper-slide">
                                                    <!-- start testimonial item -->
                                                    <div class="swiper-slide">
                                                        <div class="d-flex flex-column">
                                                            <div class="align-self-center text-center w-90 last-paragraph-no-margin">
                                                                <span class="fs-22 fw-300 d-block text-white mb-20px lh-36 ls-minus-05px w-70 mx-auto">{!! $description[\App::getLocale()] !!}</span>
                                                                    <span class="text-base-color fw-500">{{ $title[\App::getLocale()] }}</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end testimonial item -->
                                                </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- start slider pagination -->
                        <div class="swiper-pagination-wrapper d-flex align-items-center justify-content-center">

                            <div class="swiper-pagination-progress bg-medium-gray">
                                <span class="swiper-progress"></span>
                            </div>

                        </div>
                        <!-- end slider pagination -->
                        <!-- start slider navigation -->
                        <div class="swiper-button-previous-nav-01 swiper-button-prev icon-extra-medium left-0px"><i class="bi bi-arrow-left icon-extra-medium text-white"></i></div>
                        <div class="swiper-button-next-nav-01 swiper-button-next icon-extra-medium right-0px"><i class="bi bi-arrow-right icon-extra-medium text-white"></i></div>
                        <!-- end slider pagination -->


                </div>
            </div>



        </div>
    </section>



