<?php
    $website = \App\Models\WebsiteSetting::first();
    $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>

        @if($array)
            @foreach($array as $value)

                <?php

                $pt = $item->pt;
                $pt = $item->mt;
                $pt = $item->mb;

                $bgcolor = $value->bgcolor;
                $color_title = $value->color_title;

                $title = json_decode($value->title, true);
                if($title === null){
                    $title = [];
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

                if(!key_exists(\App::getLocale(), $description)){
                    $description[\App::getLocale()] = "";
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

                $url = "#";
                if(trim($url_interno[\App::getLocale()]) != ""){
                    $url = "/{$url_interno[\App::getLocale()]}";
                }else{
                    if(trim($url_esterno[\App::getLocale()]) != ""){
                        $url = $url_esterno[\App::getLocale()];
                    }
                }

                // serve per le thumbs
                $photo = $value->foto;

                // serve per le thumb
                if($photo){
                    $basename = basename($photo);
                    $temp = explode(".", $basename);

                    $check = "thumb/blocks_htmlbooks/$temp[0]-large.webp";
                    if(file_exists($check)){
                        $foto = url($check);
                    }else{
                        $foto = url($photo);
                    }
                }

                //serve per la thumbs foto2
                $photo2 = $value->foto2;

                if($photo2){
                    $basename = basename($photo2);
                    $temp = explode(".", $basename);

                    $check = "thumb/blocks_htmlbooks/$temp[0]-large.webp";
                    if(file_exists($check)){
                        $foto2 = url($check);
                    }else{
                        $foto2 = url($photo2);
                    }
                }

                //serve per la thumbs foto3
                $photo3 = $value->foto3;

                if($photo3){
                    $basename = basename($photo3);
                    $temp = explode(".", $basename);

                    $check = "thumb/blocks_htmlbooks/$temp[0]-large.webp";
                    if(file_exists($check)){
                        $foto3 = url($check);
                    }else{
                        $foto3 = url($photo3);
                    }
                }

                //serve per la thumbs foto4
                $photo4 = $value->foto4;

                if($photo4){
                    $basename = basename($photo4);
                    $temp = explode(".", $basename);

                    $check = "thumb/blocks_htmlbooks/$temp[0]-large.webp";
                    if(file_exists($check)){
                        $foto4 = url($check);
                    }else{
                        $foto4 = url($photo4);
                    }
                }

                // fine thumb
                ?>


                <section class="pt pt-{{ $item->pt }}" style="background-color:{!! $value->bgcolor !!};">
                    <div class="{{ $item->fullwidth }}" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div class="row justify-content-{{ $item->text_align }}" style="margin-top: {{ $item->mt }}px; margin-bottom: {{ $item->mb }}px;">

                            <div class="col-xl-12 col-lg-12 col-md-10 text-{{ $item->text_align }}">
                                <h3 class="fw-700 ls-minus-1px appear anime-complete" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</h3>
                                <p class="w-95 md-w-100">{!! $description[\App::getLocale()] !!}</p>

                            </div>

                        </div>


                        <div class="row" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <div class="col-xl-6 col-lg-6 col-md-10 text-{{ $item->text_align }} gallery-box">
                                    @if(trim($value->foto) != "")
                                        <a href="{{ $foto }}">
                                            <div class="feature-box-icon mb-30px sm-mb-20px" >
                                                <img src="{{ $foto }}" data-group="lightbox-group-gallery" title="" loading="lazy">
                                            </div>
                                        </a>
                                    @endif
                                </div>

                            <div class="col-xl-6 col-lg-6 col-md-10 text-{{ $item->text_align }} gallery-box">
                                @if(trim($value->foto2) != "")
                                    <a href="{{ $foto2 }}">
                                        <div class="feature-box-icon mb-30px sm-mb-20px" >
                                            <img src="{{ $foto2 }}" data-group="lightbox-group-gallery" title="" loading="lazy">
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="row" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            <div class="col-xl-6 col-lg-6 col-md-10 text-{{ $item->text_align }} gallery-box">
                                @if(trim($value->foto3) != "")
                                    <a href="{{ $foto3 }}">
                                        <div class="feature-box-icon mb-30px sm-mb-20px" >
                                            <img src="{{ $foto3 }}" data-group="lightbox-group-gallery" title="" loading="lazy">
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-10 text-{{ $item->text_align }} gallery-box">
                                @if(trim($value->foto4) != "")
                                    <a href="{{ $foto4 }}">
                                        <div class="feature-box-icon mb-30px sm-mb-20px" >
                                            <img src="{{ $foto4 }}" data-group="lightbox-group-gallery" title="" loading="lazy">
                                        </div>
                                    </a>
                                @endif

                            </div>
                        </div>
                            @if(trim($button[\App::getLocale()])!="")
                                <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="color:{{ $website->btn_txt_color }} ; background-color:{{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }};"><span>{{ $button[\App::getLocale()] }}</span></a>
                            @endif

                        </div>
                    </div>
                </section>

            @endforeach
        @endif
