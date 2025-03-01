<?php
$website = \App\Models\WebsiteSetting::first();

$titleBlocco = json_decode($item->title, true);
if($titleBlocco){
    if(!key_exists(\App::getLocale(), $titleBlocco)){
        $titleBlocco[\App::getLocale()] = "";
    }
}else{
    $titleBlocco[\App::getLocale()] = "";
}

$descriptionBlocco = json_decode($item->description, true);
if($descriptionBlocco){
    if(!key_exists(\App::getLocale(), $descriptionBlocco)){
        $descriptionBlocco[\App::getLocale()] = "";
    }
}else{
    $descriptionBlocco[\App::getLocale()] = "";
}

?>

<section class="pt-5 pb-5">
    <div class="{{ $item->fullwidth }}">
        <div class="row justify-content-center mb-4">
            @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
                <div class="col-12 col-lg-12 text-center" data-anime='{"translateY": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="ps-25px pe-25px mb-15px text-uppercase text-dark-gray text-base-color fs-12 lh-40 fw-700 border-radius-100px bg-solitude-blue d-inline-flex">{{ $titleBlocco[\App::getLocale()] }}</span>
                    <h2 class="fw-600 text-dark-gray alt-font ls-minus-1px">{!! $descriptionBlocco[\App::getLocale()] !!} </h2>
                </div>
            @endif
        </div>

        <div class="contact-area py-120">
            <div class="container">
                <div class="contact-content">
                    <div class="row">

                        @if($array)
                            @foreach($array as $value)

                                    <?php

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

                                    if(!key_exists(\App::getLocale(), $title)){
                                        $title[\App::getLocale()] = "";
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

                                    // serve per le thumb

                                    $photo = $value->foto;

                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_icons/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    ?>

                                    <div class="col-md-{{ $item->col }}" >
                                        <div class="contact-info" style="background-color: {{ $value->bgcolor }}!important;">
                                            @if($value->icon)
                                                <div style="color: {{ $value->color_icon }}!important;">
                                                    <span style="color: {{ $item->color_icon }}!important;"> {!! $value->icon !!}</span>
                                                </div>
                                            @else
                                                @if(trim($value->foto) != "")
                                                    <div class="feature-box-icon mb-30px sm-mb-20px" >
                                                        <img src="{{ $foto }}" title="" loading="lazy" class="mx-auto h-65px">
                                                    </div>
                                                @endif
                                            @endif

                                            <div class="content">
                                                @if($url != "#")
                                                    <span class="d-inline-block fw-500 fs-18" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</span>
                                                    <p class="w-90 m-auto">{!! $description[\App::getLocale()] !!}</p>

                                                @else
                                                    <span class="d-inline-block fw-500 fs-18" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</span>
                                                    <p class="w-90 m-auto">{!! $description[\App::getLocale()] !!}</p>
                                                @endif
                                                @if(trim($button[\App::getLocale()])!="")
                                                    <div class="move-bottom-top mt-15px">
                                                        <a target="{{ $type_href }}" href="{{ $url }}" style="color:{!! $value->color_text_button !!};" class="hover-link btn btn-link btn-medium ls-05px">{{ $button[\App::getLocale()] }}</a>
                                                    </div>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>







                @endforeach
            @endif
                    </div>
                </div>

        </div>
    </div>
</section>
