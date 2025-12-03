<?php
$website = \App\Models\WebsiteSetting::first();
$agent = new \Jenssegers\Agent\Agent();
?>

<section class="section-dark p-0 bg-dark-gray">
   <!-- <div class="swiper lg-no-parallax full-screen md-h-600px sm-h-500px swiper-light-pagination" data-slider-options='{ "slidesPerView": 1, "loop": true, "parallax": true, "speed": 1000, "pagination": { "el": ".swiper-pagination-bullets", "clickable": true }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 4000, "disableOnInteraction": false },  "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "{{ $item->effect }}" }'>-->
    <div class="swiper full-screen ipad-top-space-margin md-h-600px sm-h-500px swiper-number-pagination-style-01 base-color" data-slider-options='{ "slidesPerView": 1, "loop": true, "pagination": { "el": ".swiper-number", "clickable": true }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 5000, "disableOnInteraction": false },  "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "{{ $item->effect }}" }' data-number-pagination="1" data-anime-text='{ "translateY": [50,0], "opacity": [0,1], "easing": "easeOutQuad", "duration": 500, "delay": { "staggervalue": 20 } }'>

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
                            <div class="cover-background position-absolute top-0 start-0 w-100 h-100" data-swiper-parallax="500" style="background-image:url('{{ $foto }}');">
                                <div class="layer" style="background-color: rgba(0, 0, 0, 0.{{ $item->alpha }}); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                                <div class="container h-100" data-swiper-parallax="-500">
                                    <div class="row align-items-center h-100">
                                        <div class="col-xl-11 col-lg-8 col-md-10 position-relative text-center text-md-start" data-anime='{ "el": "childs", "translateX": [100, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                            @if($abstract[\App::getLocale()])
                                                <div>
                                                    <span class="fs-20 mt-25px sm-mb-15px d-inline-block fw-300"></span>
                                                </div>
                                            @endif
                                            @if($title[\App::getLocale()])
                                                <h1 class="alt-font w-90 xl-w-100 text-shadow-double-large ls-minus-2px" style="color: {{ $value->title_background }};">{!! $title[\App::getLocale()] !!}</h1>
                                            @endif
                                            @if($abstract[\App::getLocale()])
                                                <div>
                                                    <span class="fs-20 mb-25px sm-mb-15px d-inline-block fw-300">{!! $abstract[\App::getLocale()] !!}</span>
                                                </div>
                                            @endif
                                            @if(trim($button[\App::getLocale()])!="")
                                                <a href="{{ $url }}" target="{{ $type_href }}" class="button btn" style='background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }}; color: {{ $website->btn_txt_color }};'>
                                                    {{ $button[\App::getLocale()] }}<span class="bg-white text-base-color"></span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="position-absolute bottom-minus-45px" data-anime='{ "translateY": [150, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'><span class="alt-font number text-base-color opacity-3 fs-190 fw-600 ls-minus-5px">01</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- end slider item -->

                @endforeach
            @endif

        </div>

        <!-- start slider pagination -->
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"></div>
        <!-- end slider pagination -->

    </div>
</section>
