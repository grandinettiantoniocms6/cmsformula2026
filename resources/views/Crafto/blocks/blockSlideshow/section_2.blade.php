<?php
$website = \App\Models\WebsiteSetting::first();
$agent = new \Jenssegers\Agent\Agent();
?>

<section class="p-0 bg-dark-gray">
    <div class="swiper lg-no-parallax full-screen md-h-600px sm-h-500px swiper-light-pagination ipad-top-space-margin" data-slider-options='{ "slidesPerView": 1, "loop": true, "parallax": true, "speed": 1200, "pagination": { "el": ".swiper-pagination-bullets", "clickable": true }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "{{ $item->effect }}" }'>
        <div class="swiper-wrapper">

            @if($array)
                @foreach($array as $value)

                        <?php

                        $title = json_decode($value->title, true);
                        if($title === null){
                            $title = [];
                        }

                        $title_background = $value->title_background;
                        $slide_height = $item->slide_height;
                        $abstract = json_decode($value->abstract, true);
                        if($abstract === null){
                            $abstract = [];
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

                        if(!key_exists(\App::getLocale(), $abstract)){
                            $abstract[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $title)){
                            $title[\App::getLocale()] = "";
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

                        $foto = null;
                        if($agent->isMobile() || $agent->isTablet()){
                            if($value->foto_mobile){
                                $photo = $value->foto_mobile;
                            }else{
                                $photo = $value->foto;
                            }
                        }else{
                            $photo = $value->foto;
                        }

                        $alt_img = '';
                        if($title[\App::getLocale()]){
                            $alt_img = strip_tags($title[\App::getLocale()]);
                        }elseif ($abstract[\App::getLocale()]) {
                            $alt_img = strip_tags($abstract[\App::getLocale()]);
                        }

                        // serve per le thumb
                        if($photo){
                            $basename = basename($photo);
                            $temp = explode(".", $basename);

                            if($agent->isMobile() || $agent->isTablet()){
                                $check = "thumb/blocks_slideshows/$temp[0]-mobile.webp";
                            }else{
                                $check = "thumb/blocks_slideshows/$temp[0]-large.webp";
                            }

                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($photo);
                            }
                        }

                        // Sfondo testo slide
                        $captionbg = 'transparent';

                        if($value->is_alphabg == 1){
                            switch ($value->alpha_bgtext) {
                                case 0:
                                    $alpha_bg = '00';
                                    break;
                                case 100:
                                    $alpha_bg = '';
                                    break;
                                default:
                                    $alpha_bg = $value->alpha_bgtext;
                            }
                            $captionbg = $value->bgcolor.$alpha_bg;
                        }
                        ?>

                        <!-- start slider item -->
                    <div class="swiper-slide overflow-hidden">
                        <div class="cover-background position-absolute top-0 start-0 w-100 h-100" style="background-image:url('{{ $foto }}');" data-swiper-parallax="1000">
                            <div class="container h-100" data-swiper-parallax="-300">
                                <div class="row align-items-center justify-content-center h-100 text-center">
                                    <div class="col-xl-7 col-lg-9 col-md-10 position-relative text-white">

                                        @if($abstract[\App::getLocale()])
                                            <span data-anime='{ "el": "childs", "translateY": [0, 0], "opacity": [0,0.7], "duration": 1500, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                                    <span class="fw-300 fs-22 opacity-7 mb-15px d-inline-block">{!! $abstract[\App::getLocale()] !!}</span>
                                                </span>
                                        @endif

                                        @if($title[\App::getLocale()])
                                            <span class="opacity-7 fs-80 xs-fs-60 alt-font fw-700 text-shadow-extra-large ls-minus-2px mb-45px sm-mb-30px xs-mb-20px d-inline-block swiper-parallax-fancy-text"
                                                  style="color: {{ $value->title_background }};" data-fancy-text='{ "effect": "rotate", "string": ["{!! $title[\App::getLocale()] !!}"] }'>
                                                        </span>
                                        @endif

                                        @if(trim($button[\App::getLocale()])!="")

                                            <div data-anime='{ "el": "childs", "translateY": [80, 0], "opacity": [0,1], "duration": 600, "delay": 1000, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                                <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-large btn-transparent-white-light border-1 btn-hover-animation btn-box-shadow btn-round-edge xs-m-10px">
                                                        <span>
                                                            <span class="btn-text">{{ $button[\App::getLocale()] }}</span>
                                                            <span class="btn-icon"><i class="feather icon-feather-arrow-right"></i></span>
                                                        </span>
                                                </a>
                                            </div>

                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end slider item -->

                @endforeach
            @endif

        </div>

        <!-- start slider pagination -->
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets d-block d-md-none"></div>
        <!-- end slider pagination -->
        <!-- start slider navigation -->
        <div class="slider-one-slide-prev-1 icon-very-medium text-white swiper-button-prev slider-navigation-style-06 bg-black-transparent-medium h-60px w-60px d-none d-sm-flex border-radius-100"><i class="bi bi-arrow-left-short"></i></div>
        <div class="slider-one-slide-next-1 icon-very-medium text-white swiper-button-next slider-navigation-style-06 bg-black-transparent-medium h-60px w-60px d-none d-sm-flex border-radius-100"><i class="bi bi-arrow-right-short"></i></div>
        <!-- end slider navigation -->

    </div>
</section>
