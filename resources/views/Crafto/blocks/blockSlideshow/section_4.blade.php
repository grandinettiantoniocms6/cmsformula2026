<?php
$website = \App\Models\WebsiteSetting::first();
$agent = new \Jenssegers\Agent\Agent();
?>

<section class="p-0 top-space-margin overflow-hidden pb-25px">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col-12 col-md-12">
                <div class="outside-box-right-30 sm-outside-box-right-0" data-anime='{ "translateX": [40, 0], "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="swiper base-color" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 25, "loop": true, "autoplay": { "delay": 3000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
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

                                        <!-- start content carousal item -->
                                        <div class="swiper-slide">
                                            <div class="interactive-banner-style-09 position-relative overflow-hidden">
                                                <img class="w-100" src="{{ $foto }}" alt="" />
                                                <div class="opacity-full-dark bg-gradient-bottom-dark-transparent"></div>
                                                <div class="image-content h-100 w-100 p-10 xl-p-30px sm-pe-15px sm-ps-15px text-center d-flex justify-content-end align-items-end flex-column">
                                                    <div class="w-100">
                                                        @if($url != "#")
                                                            <div class="alt-font fw-700 sliding-box-title mb-10px w-80 xl-w-100 md-w-90 sm-w-70 xs-w-100 mx-auto">
                                                                <a href="{{ $url }}" target="{{ $type_href }}" class="alt-font fw-600 fs-40 lg-fs-24 ls-minus-1px lg-ls-0px">
                                                                    @if($title[\App::getLocale()])
                                                                        {!! $title[\App::getLocale()] !!}
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="alt-font fw-700 sliding-box-title mb-10px w-80 xl-w-100 md-w-90 sm-w-70 xs-w-100 mx-auto">
                                                                    @if($title[\App::getLocale()])
                                                                        <span class="alt-font fw-600 fs-40 lg-fs-24 ls-minus-1px lg-ls-0px" style="color:{!! $value->title_background !!};">{!! $title[\App::getLocale()] !!}</span>
                                                                    @endif
                                                            </div>
                                                        @endif
                                                            @if($abstract[\App::getLocale()])
                                                                <div class="fs-22 lg-fs-20 fw-300 ls-minus-1px md-w-80 sm-w-100 xs-w-90">
                                                                    <span>{!! $abstract[\App::getLocale()] !!}</span>
                                                                </div>
                                                            @endif

                                                        <div class="d-flex justify-content-center align-items-center xs-lh-22">
                                                            @if(trim($button[\App::getLocale()])!="")
                                                                <div class="ms-10px me-10px">
                                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-medium btn-rounded btn-box-shadow btn-white text-uppercase fw-700 ps-15px pe-15px pt-5px pb-5px lh-16 mb-20px">{{ $button[\App::getLocale()] }}</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end content carousal item -->




                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
