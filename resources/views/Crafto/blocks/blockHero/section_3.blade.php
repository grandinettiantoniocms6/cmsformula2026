<?php
$website = \App\Models\WebsiteSetting::first();
$agent = new \Jenssegers\Agent\Agent();
?>

@if($array)
    @foreach($array as $value)
        <?php

        //$bgcolor = $value->bgcolor;

        $title = json_decode($value->title, true);
        if($title === null){
            $title = [];
        }

        $color_title = $value->color_title;
        $height = $item->height;
        $alpha = $item->alpha;

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

            // Foto Mobile
            $photo_mobile1 = $value->foto_mobile_1;
            if($photo_mobile1){
                if($agent->isMobile() || $agent->isTablet()){
                    if($value->foto_mobile_1){
                        $photo_mobile1 = $value->foto_mobile_1;
                    }else{
                        $photo_mobile1 = $value->sfondo;
                    }
                }else{
                    $photo_mobile1 = $value->sfondo;
                }
            }

            $photo_mobile2 = $value->foto_mobile_2;
            if($photo_mobile2){
                if($agent->isMobile() || $agent->isTablet()){
                    if($value->foto_mobile_2){
                        $photo_mobile2 = $value->foto_mobile_2;
                    }else{
                        $photo_mobile2 = $value->foto;
                    }
                }else{
                    $photo_mobile2 = $value->foto;
                }
            }

            // serve per le thumb
            $foto = $value->foto;
            if($foto){
                $basename = basename($foto);
                $temp = explode(".", $basename);
                $check = "thumb/blocks_heros/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto = url($check);
                }else{
                    $foto = url($foto);
                }
            }


            // serve per le thumb
            $sfondo = $value->sfondo;
            if($sfondo){
                $basename = basename($sfondo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_heros/$temp[0]-large.webp";
                if(file_exists($check)){
                    $sfondo = url($check);
                }else{
                    $sfondo = url($sfondo);
                }
            }


        ?>

        <style>
            @if($sfondo)
                #block-hero-{{ $value->block_id }} { background-image: url('{{ $sfondo }}' ); }
            @endif
            @if($value->foto_mobile_1)
                @media (max-width: 575px) {
                #block-hero-{{ $value->block_id }} { background-image: url('{{ $value->foto_mobile_1 }}'); }
            }
            @endif
            @if($value->color_title)
                #block-hero-{{ $value->block_id }} .title { color: {!! $value->color_title !!}; }
            @endif
            #block-hero-{{ $value->block_id }} .container { min-height: {!! $height !!}; }
            #block-hero-{{ $value->block_id }} .hero-img-block img { max-height: {!! $height !!}; }
        </style>

        <section class="block-hero style-{{ $item->style }} image-wrapper bg-overlay bg-overlay-black-{{ $item->alpha }}" id="block-hero-{{ $value->block_id }}" style="background-color: {!! $value->bgcolor !!}!important;">
            <div class="container">

                <div class="row d-flex align-items-center wow animate__fadeInUp" data-wow-duration=".6s">
                    @if($foto)
                        <div class="col-md-12">
                            <div class="hero-img-block">
                                <picture>
                                    @if($agent->isMobile() || $agent->isTablet())
                                        @if($value->foto)
                                            <source media="(max-width:575px)" srcset="{{ $value->foto_mobile_2 }}">
                                        @endif
                                    @endif
                                    <img class="img-fluid jump" src="{{ $value->foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                                </picture>
                            </div>
                        </div>

                    @endif
                </div>

                <div class="row d-flex align-items-center wow animate__fadeInLeft" data-wow-duration=".6s" style="margin-top: 40px;" >
                    <div class="col-md-12 col-xl-6">
                        <div class="hero-txt-block">
                            <h3 class="title">{{ $title[\App::getLocale()] }}</h3>
                            <div class="description">{!! $description[\App::getLocale()] !!}</div>
                            @if(trim($button[\App::getLocale()])!="")
                                <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}"><span>{{ $button[\App::getLocale()] }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </section>
    @endforeach
@endif
