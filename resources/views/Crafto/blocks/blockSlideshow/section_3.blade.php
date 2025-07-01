<?php
$website = \App\Models\WebsiteSetting::first();
$agent = new \Jenssegers\Agent\Agent();
?>

<section class="p-0 top-space-margin position-relative overflow-hidden">
    <div class="swiper full-screen swiper-number-pagination-style-01 md-h-auto" data-slider-options='{ "slidesPerView": 1, "loop": true, "pagination": { "el": ".swiper-number", "clickable": true }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 4000, "disableOnInteraction": false },  "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "{{ $item->effect }}" }' data-number-pagination="1">
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

                        // se non uso le thumb
                        if($value->foto){
                            $basename = basename($value->foto);
                            $temp = explode(".", $basename);
                            $foto = url($value->foto);
                        }
                        // end se non uso le thumb

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

                        <!-- Velina o layer trasparente sopra img o colore sfondo -->
                        <style>
                            .banner::after { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: linear-gradient(120deg, #131313, #1f1f1f); opacity: 0.{{ $value->alpha }}; }
                            .banner { position: relative; min-height: 60vh; background-size: cover; display: flex; }
                            .banner::before { z-index: -1; }
                            .banner > * { z-index: 2; }
                        </style>
                        <!-- Velina o layer trasparente sopra img o colore sfondo -->

                            <!-- start slider item -->
                            <div class="swiper-slide" >
                                <div class="container-fluid h-100 g-0">
                                    <div class="row h-100 p-0">
                                        <div class="col-xxl-5 col-lg-6 text-white bg-very-light-green cover-background ps-6 xxl-ps-4 sm-ps-15px order-2 order-lg-1 md-pt-50px md-pb-15 xs-pb-20" style="background-color: {{ $value->left_bgcolor }}; height: 100%;" >
                                            <div class="d-flex justify-content-center align-items-lg-start align-items-center text-lg-start text-center flex-column h-100" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                                @if($title[\App::getLocale()])
                                                    <span class="fs-15 fw-500 ls-05px mb-20px d-inline-block border-bottom border-2 border-color-transparent-white-very-light text-uppercase" style="color: {{ $value->title_background }};">{!! $title[\App::getLocale()] !!}</span>
                                                @endif
                                                @if($abstract[\App::getLocale()])
                                                <div class="fs-60 lg-fs-60 fw-600 ls-minus-2px md-w-80 sm-w-100 xs-w-90">
                                                    <span>{!! $abstract[\App::getLocale()] !!}</span>
                                                </div>
                                                @endif

                                                @if(trim($button[\App::getLocale()])!="")
                                                <div class="d-inline-block mt-45px sm-mt-30px">
                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="button btn" style='background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }}; color: {{ $website->btn_txt_color }};'>
                                                        <span>
                                                            <span><i class="feather icon-feather-arrow-right"></i></span>
                                                            <span class="btn-double-text ls-minus-05px" data-text="Discover more">{{ $button[\App::getLocale()] }}</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xxl-7 col-lg-6 cover-background sm-background-position-top-center order-1 order-lg-2 md-h-500px sm-h-400px" style="background-image:url('{{ $foto }}');">
                                            <div class="opacity-full-dark bg-gradient-bottom-dark-transparent"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end slider item -->

                @endforeach
            @endif

        </div>

        <!-- start slider navigation -->
        <div class="position-relative">
            <div class="swiper-pagination w-auto left-0 md-right-0px text-center swiper-pagination-clickable swiper-number fs-14 ps-6 xxl-ps-4 md-ps-0" style="bottom: 0px!important; background-color: #040404;"></div>
        </div>
        <!-- end slider navigation -->

    </div>
</section>
