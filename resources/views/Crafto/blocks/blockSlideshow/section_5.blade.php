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

                        <section class="top-space-margin p-0 full-screen md-h-600px sm-h-500px section-dark" data-parallax-background-ratio="0.8" style="background-image: url('{{ $foto }}')">
                            <div class="layer" style="background-color: rgba(0, 0, 0, 0.{{ $item->alpha }}); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                            <div class="container h-100">
                                <div class="row align-items-center h-100">
                                    <div class="col-xl-7 col-md-9 col-sm-9 position-relative text-white" data-anime='{ "el": "childs", "opacity": [0, 1], "translateY": [30, 0], "staggervalue": 200, "easing": "easeInOutSine" }'>
                                        <div class="fs-65 lh-55 sm-fs-45 fw-600 mb-20px text-shadow-large ls-minus-2px" style="color: {{ $value->title_background }};">{!! $title[\App::getLocale()] !!}</div>
                                        <div>
                                            <span class="opacity-5 fs-20 w-70 md-w-85 mb-25px fw-300 d-inline-block">{!! $abstract[\App::getLocale()] !!}</span>
                                        </div>
                                        <div class="icon-with-text-style-08">
                                            <div class="feature-box feature-box-left-icon-middle">
                                                <div class="feature-box-icon feature-box-icon-rounded w-65px h-65px rounded-circle me-15px rounded-box" style="background-color: {{ $website->btn_background }};">
                                                    <i class="feather icon-feather-arrow-right text-dark-gray icon-extra-medium"></i>
                                                </div>
                                                <div class="feature-box-content">
                                                    @if(trim($button[\App::getLocale()])!="")
                                                        <a href="{{ $url }}" target="{{ $type_href }}" class="d-inline-block fs-19 text-shadow-double-large" style="color: {{ $website->btn_txt_color }};">{{ $button[\App::getLocale()] }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>


                @endforeach
            @endif
