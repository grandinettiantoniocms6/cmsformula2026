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

                    ?>

                <div class="row align-items-center justify-content-center" style="padding-bottom: {{ $item->pb }}px;">
                    @if($perc == 0)

                        <!-- secondo item -->
                        <div class="col-xl-5 offset-xl-1 col-lg-6 col-md-8">
                            @if(trim($title[\App::getLocale()])!="")
                                <h3 style="color: {{ $value->txtcolor }};" class="fw-600 mb-60px md-mb-40px mt-20px text-dark-gray alt-font ls-minus-2px" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>{{ $title[\App::getLocale()] }}</span></h3>
                            @endif
                            <div class="row row-cols-1" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <div class="col-12 process-step-style-05 position-relative hover-box">
                                    @if(trim($description[\App::getLocale()])!="")
                                        <p class="w-80 lg-w-90 sm-w-100">{!! $description[\App::getLocale()] !!}</p>
                                    @endif
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-link-gradient expand btn-extra-large text-dark-gray d-table d-lg-inline-block xl-mb-15px md-mx-auto" href="{{ $url }}">{{ $button[\App::getLocale()] }}
                                            <span class="bg-dark-gray"></span>
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 text-center md-mb-50px order-1 order-lg-2">
                            <figure class="position-relative m-0" style="background-color: rgba(255,255,255,0);">
                                <div class="position-relative d-inline-block"  data-anime='{ "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                    @if(trim($foto) != "")
                                        <img class="w-90 border-radius-5px animation-float" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy" />
                                    @endif
                                </div>

                                <figcaption style="background-color: {{ $value->bgcolor }};" class="position-absolute box-shadow-quadruple-large border-radius-5px bottom-50px xs-bottom-35px left-minus-0px md-left-minus-0px ps-50px pe-50px pt-35px pb-35px xs-p-20px w-320px xs-w-250px text-center last-paragraph-no-margin" data-anime='{ "translateY": [50, 0], "scale": [0.8,1], "opacity": [0,1], "duration": 800, "delay": 300, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                    <div class="icon-with-text-style-06">
                                        <div class="feature-box feature-box-left-icon-middle">
                                            <div class="feature-box-icon me-15px">
                                                @if(trim($value->icon) != "")
                                                    <div class="icon-extra-large" style="color: {{ $value->txtcolor }}!important;">
                                                        {!! $value->icon !!}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="feature-box-content last-paragraph-no-margin">
                                                <div class="alt-font fw-600 text-dark-gray lh-26">{!! $text_box_icon[\App::getLocale()] !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </figcaption>

                            </figure>
                        </div>

                    @else

                        <!-- primo item -->
                        <div class="col-lg-6 text-center md-mb-50px" >
                            <figure class="position-relative m-0" style="background-color: rgba(255,255,255,0);">
                                <div class="position-relative d-inline-block" data-anime='{ "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                    @if(trim($foto) != "")
                                        <img class="w-90 border-radius-5px animation-float" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy" />
                                    @endif

                                </div>

                                <!-- da fare migration per il testo sopra immagine -->
                                <figcaption style="background-color: {{ $value->bgcolor }};" class="position-absolute box-shadow-quadruple-large border-radius-5px bottom-50px xs-bottom-35px left-minus-0px md-left-minus-0px ps-50px pe-50px pt-35px pb-35px xs-p-20px w-320px xs-w-250px text-center last-paragraph-no-margin" data-anime='{ "translateY": [50, 0], "scale": [0.8,1], "opacity": [0,1], "duration": 800, "delay": 300, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                    <div class="icon-with-text-style-06">
                                        <div class="feature-box feature-box-left-icon-middle">
                                            <div class="feature-box-icon me-15px">
                                                @if(trim($value->icon) != "")
                                                    <div class="icon-extra-large" style="color: {{ $value->txtcolor }}!important;">
                                                        {!! $value->icon !!}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="feature-box-content last-paragraph-no-margin">
                                                <div class="alt-font fw-600 text-dark-gray lh-26">{!! $text_box_icon[\App::getLocale()] !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </figcaption>

                            </figure>
                        </div>

                        <div class="col-xl-5 offset-xl-1 col-lg-6 col-md-8">
                            @if(trim($title[\App::getLocale()])!="")
                                <h3 style="color: {{ $value->txtcolor }};" class="fw-600 mb-60px md-mb-40px mt-20px text-dark-gray alt-font ls-minus-2px" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>{{ $title[\App::getLocale()] }}</span></h3>
                            @endif
                            <div class="row row-cols-1" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <div class="col-12 process-step-style-05 position-relative hover-box">
                                    @if(trim($description[\App::getLocale()])!="")
                                        <p class="w-80 lg-w-90 sm-w-100">{!! $description[\App::getLocale()] !!}</p>
                                    @endif
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-link-gradient expand btn-extra-large text-dark-gray d-table d-lg-inline-block xl-mb-15px md-mx-auto" href="{{ $url }}">{{ $button[\App::getLocale()] }}
                                            <span class="bg-dark-gray"></span>
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
