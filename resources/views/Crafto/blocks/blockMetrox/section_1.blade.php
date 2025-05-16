<?php $website = \App\Models\WebsiteSetting::first(); ?>

@if($array)
    <?php
    $i = 1;
    ?>
    @foreach($array as $value)
        <?php

        $title = json_decode($value->title, true);
        if($title === null){
            $title = [];
        }

        $subtitle = json_decode($value->subtitle, true);
        if($subtitle === null){
            $subtitle = [];
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

        if(!key_exists(\App::getLocale(), $title)){
            $title[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $subtitle)){
            $subtitle[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $description)){
            $description[\App::getLocale()] = "";
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

        if(key_exists(\App::getLocale(), $url_interno)){
            if(trim($url_interno[\App::getLocale()]) != ""){
                $url = "/{$url_interno[\App::getLocale()]}";
            }else{
                if(key_exists(\App::getLocale(), $url_esterno)){
                    if(trim($url_esterno[\App::getLocale()]) != ""){
                        $url = $url_esterno[\App::getLocale()];
                    }
                }
            }
        }

        $perc = $i%2;

            // serve per le thumb

            $photo = $value->foto;

            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_metroxs/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto = url($check);
                }else{
                    $foto = url($photo);
                }
            }

        ?>

        <section class="block-metrox pt-0 pb-0">
            <div class="{{ $item->fullwidth }}">
                <div class="row @if($item->fullwidth == 'container-full') g-0 @endif" style="margin-top:{{ $item->mt }}px;">

                @if($perc == 0)

                    <!-- Secondo blocco -->

                    <div class="col-md-auto col-lg-6 order-2 order-lg-1" style="padding:{{ $item->pd }}px; background-color: {{ $value->bg_color }};" data-anime='{"translateX": [50, 0], "opacity": [1,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <h2 class="title" style="font-size: {{ $value->h_title }}px; color: {{ $value->color_title }};">{{ $title[\App::getLocale()] }}</h2>
                        <h3 class="subtitle" style="font-size: {{ $value->h_subtitle }}px; color: {{ $value->color_subtitle }};">{{ $subtitle[\App::getLocale()] }}</h3>
                        <div class="description">{!! $description[\App::getLocale()] !!}</div>
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

                        @if(trim($value->foto) != "")
                            <div class="img-dx order-1 order-lg-2 col-md-auto col-lg-6 img-right" data-anime='{"translateX": [-50, 0], "opacity": [1,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <img class="img-fluid mx-auto" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                            </div>
                        @endif

                @else

                    <!-- Primo blocco -->

                        @if(trim($value->foto) != "")
                            <div class="img-sx col-md-auto col-lg-6" data-anime='{"translateX": [-50, 0], "opacity": [1,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <img class="img-fluid mx-auto" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                            </div>
                        @endif

                            <div class="col-md-auto col-lg-6" style="padding:{{ $item->pd }}px; background-color: {{ $value->bg_color }};" data-anime='{"translateX": [50, 0], "opacity": [1,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <h2 class="title" style="font-size: {{ $value->h_title }}px; color: {{ $value->color_title }}; font-family: "{{ $value->google_font }}", Helvetica, Arial, sans-serif ;">{{ $title[\App::getLocale()] }}</h2>
                                <h3 class="subtitle" style="font-size: {{ $value->h_subtitle }}px; color: {{ $value->color_subtitle }};">{{ $subtitle[\App::getLocale()] }}</h3>
                                <div class="description">{!! $description[\App::getLocale()] !!}</div>

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

                @endif

                </div>
            </div>
        </section>

        <?php $i++;?>
    @endforeach
@endif
