<?php $website = \App\Models\WebsiteSetting::first(); ?>

<section class="pt-5 pb-5" data-anime='{"translateX": [50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">
        @if($array)
                <?php $i = 1;?>
            @foreach($array as $value)
                    <?php

                    $pb = $item->pb;
                    $icon = $value->icon;
                    $foto = $value->foto;
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
                <div class="row align-items-center justify-content-md-center g-xl-0 g-1" style="padding-bottom: {{ $item->pb }}px;">
                    @if($perc == 0)

                        <!-- secondo item -->

                        <!-- A -->

                        <div class="col-lg-6 col-md-10 md-mb-50px" data-anime='{"opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                            @if(trim($foto) != "")
                                <figure class="position-relative m-0">
                                    <img class="lg-w-100 border-radius-0px" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}">
                                </figure>
                            @endif
                        </div>

                        <!-- B -->
                        <div class="col-xl-5 offset-xl-1 col-lg-6" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

                            @if(trim($title[\App::getLocale()])!="")
                                <h3 style="color: {{ $value->txtcolor }};" class="fw-700 ls-minus-1px mb-20px" class="ps-25px pe-25px mb-15px text-uppercase fs-12 lh-40 fw-700 border-radius-100px d-inline-flex" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>{{ $title[\App::getLocale()] }}</h3>
                            @endif

                            @if(trim($description[\App::getLocale()])!="")
                                <p class="w-80 lg-w-100 sm-w-100">{!! $description[\App::getLocale()] !!}</p>
                            @endif

                            <div class="d-inline-flex flex-wrap">
                                @if(trim($button[\App::getLocale()])!="")
                                    <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-large btn-dark-gray btn-hover-animation-switch btn-box-shadow btn-rounded me-25px xs-me-0" >
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

                    @else

                        <!-- primo item -->

                        <!-- B -->

                        <div class="col-lg-6" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

                            @if(trim($title[\App::getLocale()])!="")
                                <h3 style="color: {{ $value->txtcolor }};" class="fw-700 ls-minus-1px mb-20px" class="ps-25px pe-25px mb-15px text-uppercase fs-12 lh-40 fw-700 border-radius-100px d-inline-flex" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>{{ $title[\App::getLocale()] }}</h3>
                            @endif

                            @if(trim($description[\App::getLocale()])!="")
                                <p class="w-80 lg-w-100 sm-w-100">{!! $description[\App::getLocale()] !!}</p>
                            @endif

                            <div class="d-inline-flex flex-wrap">
                                @if(trim($button[\App::getLocale()])!="")
                                    <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-large btn-dark-gray btn-hover-animation-switch btn-box-shadow btn-rounded me-25px xs-me-0" >
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

                        <!-- A -->

                        <div class="col-lg-6 col-md-10 md-mb-50px" data-anime='{"opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                            @if(trim($foto) != "")
                                <figure class="position-relative m-0">
                                    <img class="lg-w-100 border-radius-0px" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}">
                                </figure>
                            @endif
                        </div>

                    @endif

                </div>
                <div class="row space-{{ $item->pb }}"></div>

                    <?php $i++;?>

            @endforeach
        @endif

    </div>
</section>
