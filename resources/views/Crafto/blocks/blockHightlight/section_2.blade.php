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

<?php
    $bgimage = $item->bgimage;
?>


@if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
    <section class="overflow-hidden bg-very-light-gray position-relative pt-3 sm-pt-50px" style="background-color: {{ $item->background_color }}!important; @if($item->bgimage) background-image: url('{{ $item->bgimage }}') @endif" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
        <div class="{{ $item->fullwidth }}">
            <div class="row align-items-center mb-5 sm-mb-30px text-center text-lg-start" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-lg-5 md-mb-30px">
                    <h3 class="text-dark-gray fw-700 ls-minus-2px mb-0">{{ $titleBlocco[\App::getLocale()] }}</h3>
                </div>
                <div class="col-lg-4 offset-xl-1 last-paragraph-no-margin md-mb-30px">
                    <p class="w-85 md-w-100">{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
                <div class="col-xl-2 col-lg-3 d-flex justify-content-center">
                    <!-- start slider navigation -->
                    <div class="slider-one-slide-prev-1 icon-small text-dark-gray swiper-button-prev slider-navigation-style-04 bg-white box-shadow-large"><i class="fa-solid fa-arrow-left"></i></div>
                    <div class="slider-one-slide-next-1 icon-small text-dark-gray swiper-button-next slider-navigation-style-04 bg-white box-shadow-large"><i class="fa-solid fa-arrow-right"></i></div>
                    <!-- end slider navigation -->
                </div>
            </div>
            @endif

            <div class="row align-items-center mb-6" data-anime='{ "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
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
                                                    <!-- start services box style -->
                                                    <div class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                                        <div class="position-relative">
                                                            @if($url != "#")
                                                                <a href="{{ $url }}" target="{{ $type_href }}" >
                                                                    @if(trim($value->foto) != "")
                                                                        <img src="{{ $foto }}" alt=""></a>
                                                                    @endif
                                                            @endif
                                                        </div>
                                                        <div class="bg-white">
                                                            <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                                @if($url != "#")
                                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">{{ $title[\App::getLocale()] }}</a>
                                                                @endif
                                                                <p>{!! $description[\App::getLocale()] !!}</p>
                                                            </div>

                                                            <div class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                                @if($url != "#")
                                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                                @endif
                                                                <span>
                                                                    <span class="btn-text">{{ $button[\App::getLocale()] }}</span>
                                                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                                                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                                                                </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end services box style -->
                                                </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>



