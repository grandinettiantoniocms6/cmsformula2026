<?php
$website = \App\Models\WebsiteSetting::first();
$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>

<section class="position-relative big-section" style="background-color: {{ $item->bgcolor }}; margin-top: {{ $item->pt }}px!important;;">
    <div class="container-fluid overlap-section">
        <div class="row position-relative mb-4" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 10, "staggervalue": 150, "easing": "easeOutQuad" }'>
            <div class="col swiper swiper-width-auto text-center" data-slider-options='{ "slidesPerView": "auto", "spaceBetween":{{ $item->spacebetween }}, "speed":{{ $item->speed }}, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": false, "autoplay": { "delay":0, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                <div class="swiper-wrapper marquee-slide">

                    @if($array)
                        @foreach($array as $value)
                                <?php

                                $title = json_decode($value->title, true);
                                if($title === null){
                                    $title = [];
                                }

                                $text_outline = json_decode($value->text_outline, true);
                                if($text_outline === null){
                                    $text_outline = [];
                                }

                                $color_text_outline = json_decode($value->color_text_outline, true);
                                if($color_text_outline === null){
                                    $color_text_outline = [];
                                }

                                $url_interno = json_decode($value->url_interno, true);
                                if($url_interno === null){
                                    $url_interno = [];
                                }

                                $url_esterno = json_decode($value->url, true);
                                if($url_esterno === null){
                                    $url_esterno = [];
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


                                if(!key_exists(\App::getLocale(), $color_text_outline)){
                                    $color_text_outline[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $url_interno)){
                                    $url_interno[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $url_esterno)){
                                    $url_esterno[\App::getLocale()] = "";
                                }

                            ?>

                                <div class="swiper-slide">
                                        <a href="{{ $url }}" target="{{ $type_href }}">
                                            <div class="fs-{{ $value->fs }} ls-minus-2px alt-font {{ $value->text_outline ? 'text-outline' : '' }}"
                                                 style="color:{{ $value->color_title }}; -webkit-text-stroke-color:{{ $value->color_text_outline }}!important; text-transform: uppercase;">
                                                {{ $title[\App::getLocale()] }}
                                            </div>
                                        </a>
                                </div>

                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
