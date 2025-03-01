<?php
$website = \App\Models\WebsiteSetting::first();
$agent = new \Jenssegers\Agent\Agent();
?>

<div class="hero-section">
    <div class="hero-slider owl-carousel">

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
                        <div class="hero-single layer" style="background-image: url({{ $foto }}); height: {!! $slide_height !!}; ">

                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="hero-content">

                                            @if($title[\App::getLocale()])
                                            <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s" style="color: {{ $value->title_background }};">
                                                {!! $title[\App::getLocale()] !!}
                                            </h1>
                                            @endif

                                            @if($abstract[\App::getLocale()])
                                                <p data-animation="fadeInLeft" data-delay=".75s">
                                                    {!! $abstract[\App::getLocale()] !!}
                                                </p>
                                            @endif

                                            @if(trim($button[\App::getLocale()])!="")

                                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="theme-btn" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};">
                                                        {{ $button[\App::getLocale()] }}<i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                @endforeach
            @endif

    </div>
</div>


