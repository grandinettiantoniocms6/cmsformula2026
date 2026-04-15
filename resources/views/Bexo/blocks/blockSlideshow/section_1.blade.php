<?php
$website = \App\Models\WebsiteSetting::first();
$agent = new \Jenssegers\Agent\Agent();
?>

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

        <section class="tj-banner-section section-gap-x">
            <div class="banner-area">
                <div class="banner-left-box">
                    <div class="banner-content">
                        @if(trim($title[\App::getLocale()])!="")
                            <h1 class="banner-title title-anim" style="color: {{ $value->title_background }};">{!! $title[\App::getLocale()] !!}</h1>
                        @endif

                        <div class="banner-desc-area wow fadeInUp" data-wow-delay=".7s">

                            @if(trim($button[\App::getLocale()])!="")
                                <a class="banner-link" href="{{ $url }}" target="{{ $type_href }}">
                                    <span><i class="tji-arrow-right-big"></i></span>
                                </a>
                            @endif

                            @if($abstract[\App::getLocale()])
                                <div class="banner-desc">{!! $abstract[\App::getLocale()] !!} </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="banner-right-box">
                    <div class="banner-img">
                        <img data-speed="0.8" src="{{ $value->foto }}" alt="">
                    </div>
                </div>
            </div>
            <div class="banner-scroll wow fadeInDown" data-wow-delay="2s">
                <a href="#choose" class="scroll-down tj-scroll-btn">
                    <span><i class="tji-arrow-down-long"></i></span>
                    Scroll Down
                </a>
            </div>
        </section>


    @endforeach
@endif
