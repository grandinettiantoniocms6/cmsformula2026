<?php $website = \App\Models\WebsiteSetting::first(); ?>

<section class="bg-very-light-gray pt-5 pb-5">
    <div class="{{ $item->fullwidth }}">
        @if($array)
                <?php $i = 1;?>
            @foreach($array as $value)

                    <?php

                    $pb = $item->pb;
                    $icon = $value->icon;
                    $foto2 = $value->foto2;
                    $foto3 = $value->foto3;
                    $bgcolor = $value->bgcolor;
                    $txtcolor = $value->txtcolor;

                    $title = json_decode($value->title, true);
                    if($title === null){
                        $title = [];
                    }

                    $description = json_decode($value->description, true);
                    if($description === null){
                        $description = [];
                    }

                    $text_box_icon = json_decode($value->text_box_icon, true);
                    if($text_box_icon === null){
                        $text_box_icon = [];
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

                    if(!key_exists(\App::getLocale(), $text_box_icon)){
                        $text_box_icon[\App::getLocale()] = "";
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
                    $perc = $i%2;

                    // serve per le thumbs
                    $photo = $value->foto;

                    // serve per le thumb
                    if($photo){
                        $basename = basename($photo);
                        $temp = explode(".", $basename);

                        $check = "thumb/blocks_images_links/$temp[0]-large.webp";
                        if(file_exists($check)){
                            $foto = url($check);
                        }else{
                            $foto = url($photo);
                        }
                    }

                    //serve per la thumbs foto3
                    $photo = $value->foto3;

                    if($photo){
                        $basename = basename($photo);
                        $temp = explode(".", $basename);

                        $check = "thumb/blocks_images_links/$temp[0]-large.webp";
                        if(file_exists($check)){
                            $foto3 = url($check);
                        }else{
                            $foto3 = url($photo);
                        }
                    }
                    // fine thumb

                    ?>


                <div class="row justify-content-center align-items-center mb-3" style="padding-bottom: {{ $item->pb }}px;">
                    @if($perc == 0)

                        <!-- secondo item -->

                        <!-- B -->
                        <div class="col-xl-5 offset-xl-1 col-lg-6 text-center text-lg-start" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 800, "delay": 150, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            <!-- span sopra title -->
                            <span class="pe-25px mb-20px text-uppercase text-base-color fs-14 lh-42px fw-700 border-radius-100px bg-gradient-very-light-gray-transparent d-inline-block">
                                <div class="feature-box feature-box-left-icon-middle">
                                        <div class="feature-box-icon me-15px">
                                            @if(trim($value->icon) != "")
                                                <div class="icon-large" style="color: {{ $value->txtcolor }}!important;">
                                                    {!! $value->icon !!}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="feature-box-content last-paragraph-no-margin">
                                            <div class="alt-font fw-600 text-dark-gray lh-26">{!! $text_box_icon[\App::getLocale()] !!}</div>
                                        </div>
                                    </div>
                            </span>

                            @if(trim($title[\App::getLocale()])!="")
                                <h3 style="color: {{ $value->txtcolor }};" class="fw-600 mb-60px md-mb-40px mt-20px text-dark-gray alt-font ls-minus-2px" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>{{ $title[\App::getLocale()] }}</span></h3>
                            @endif
                            <div class="row row-cols-1" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <div class="col-12 process-step-style-05 position-relative hover-box">
                                    @if(trim($description[\App::getLocale()])!="")
                                        <p class="w-80 lg-w-90 sm-w-100">{!! $description[\App::getLocale()] !!}</p>
                                    @endif
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-large btn-dark-gray btn-hover-animation-switch btn-box-shadow btn-rounded me-25px xs-me-0" href="{{ $url }}">
                                            <span>
                                                <span class="btn-text">{{ $button[\App::getLocale()] }}</span>
                                                <span class="btn-icon">
                                                    <i class="feather icon-feather-arrow-right"></i>
                                                </span>
                                                <span class="btn-icon">
                                                    <i class="feather icon-feather-arrow-right"></i>
                                                </span>
                                            </span>
                                        </a>

                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- A -->
                        <div class="col-xl-5 col-lg-6 md-mb-14 sm-mb-18 xs-mb-23 position-relative" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            @if(trim($foto) != "")
                                <div class="w-75 sm-w-80" data-animation-delay="200" data-shadow-animation="true" data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)">
                                    <img class="border-radius-6px w-100" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                                </div>
                            @endif

                            @if(trim($foto3) != "")
                                <div class="w-55 overflow-hidden position-absolute right-15px xs-w-55 bottom-minus-50px" data-shadow-animation="true" data-animation-delay="100" data-bottom-top="transform: translateY(20px)" data-top-bottom="transform: translateY(-20px)">
                                    <img src="{{ $foto3 }}" alt="{{ $title[\App::getLocale()] }}" class="border-radius-6px box-shadow-quadruple-large w-100" />
                                </div>
                            @endif

                        </div>



                    @else

                        <!-- primo item -->

                        <!-- A -->
                        <div class="col-xl-5 col-lg-6 md-mb-14 sm-mb-18 xs-mb-23 position-relative" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            @if(trim($foto) != "")
                                <div class="w-75 sm-w-80" data-animation-delay="200" data-shadow-animation="true" data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)">
                                    <img class="border-radius-6px w-100" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                                </div>
                            @endif

                            @if(trim($foto3) != "")
                                <div class="w-55 overflow-hidden position-absolute right-15px xs-w-55 bottom-minus-50px" data-shadow-animation="true" data-animation-delay="100" data-bottom-top="transform: translateY(20px)" data-top-bottom="transform: translateY(-20px)">
                                    <img src="{{ $foto3 }}" alt="{{ $title[\App::getLocale()] }}" class="border-radius-6px box-shadow-quadruple-large w-100" />
                                </div>
                            @endif

                        </div>

                        <!-- B -->
                        <div class="col-xl-5 offset-xl-1 col-lg-6 text-center text-lg-start" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 800, "delay": 150, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            <!-- span sopra title -->
                            <span class="pe-25px mb-20px text-uppercase text-base-color fs-14 lh-42px fw-700 border-radius-100px bg-gradient-very-light-gray-transparent d-inline-block">
                                <div class="feature-box feature-box-left-icon-middle">
                                        <div class="feature-box-icon me-15px">
                                            @if(trim($value->icon) != "")
                                                <div class="icon-large" style="color: {{ $value->txtcolor }}!important;">
                                                    {!! $value->icon !!}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="feature-box-content last-paragraph-no-margin">
                                            <div class="alt-font fw-600 text-dark-gray lh-26">{!! $text_box_icon[\App::getLocale()] !!}</div>
                                        </div>
                                    </div>
                            </span>

                            @if(trim($title[\App::getLocale()])!="")
                                <h3 style="color: {{ $value->txtcolor }};" class="fw-600 mb-60px md-mb-40px mt-20px text-dark-gray alt-font ls-minus-2px" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>{{ $title[\App::getLocale()] }}</span></h3>
                            @endif
                            <div class="row row-cols-1" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <div class="col-12 process-step-style-05 position-relative hover-box">
                                    @if(trim($description[\App::getLocale()])!="")
                                        <p class="w-80 lg-w-90 sm-w-100">{!! $description[\App::getLocale()] !!}</p>
                                    @endif
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-large btn-dark-gray btn-hover-animation-switch btn-box-shadow btn-rounded me-25px xs-me-0" href="{{ $url }}">
                                            <span>
                                                <span class="btn-text">{{ $button[\App::getLocale()] }}</span>
                                                <span class="btn-icon">
                                                    <i class="feather icon-feather-arrow-right"></i>
                                                </span>
                                                <span class="btn-icon">
                                                    <i class="feather icon-feather-arrow-right"></i>
                                                </span>
                                            </span>
                                        </a>

                                    @endif
                                </div>
                            </div>
                        </div>

                    @endif

                </div>

                <div class="row space-{{ $item->pb }}"></div>
                    <?php $i++;?>
            @endforeach
        @endif
    </div>
</section>




