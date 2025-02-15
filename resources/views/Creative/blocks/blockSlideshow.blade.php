<?php
$agent = new \Jenssegers\Agent\Agent();
?>

<div class="box-layout">
    <div class="hero-banner-four">
            @if($array)
            <div class="hero_slider_two">
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

                            // serve per le thumb
                            if($photo){
                                $basename = basename($photo);
                                $temp = explode(".", $basename);

                                $check = "thumb/blocks_slideshows/$temp[0]-large.{$temp[1]}";
                                if(file_exists($check)){
                                    $foto = url($check);
                                }else{
                                    $foto = url($photo);
                                }
                            }

                            ?>

                                <!-- cicla -->
                                <div class="item" id="id-{{ $value->id }}">
                                    <div class="content-wrapper" style="height: {!! $slide_height !!};">
                                        @if($foto)
                                            <img src="{{ $foto }}" alt="" class="hero-img">
                                        @endif
                                        <div class="slider-inner">
                                            <div class="hero-content">
                                                <h2 class="hero-heading position-relative" style="color: {{ $value->title_background }};">{{ $title[\App::getLocale()] }}</h2>
                                                <p class="hero-sub-heading position-relative">{!! $abstract[\App::getLocale()] !!}</p>
                                                @if(trim($button[\App::getLocale()])!="")
                                                    <a target="{{ $type_href }}" href="{{ $url }}" class="theme-btn-one border0 ripple-btn">{{ $button[\App::getLocale()] }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end cicla -->

                                @endforeach
                        </div>

            @endif

        </div>
</div>






