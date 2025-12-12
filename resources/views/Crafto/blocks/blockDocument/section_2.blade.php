<?php
    $website = \App\Models\WebsiteSetting::first();
    $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

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

@if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")

    <section class="position-relative overflow-hidden ml pt-{{ $item->pt }}">
        <div class="container">
            <div class="row justify-content-center mb-2">
                <div class="col-xl-12 col-lg-9 col-md-10 text-center" data-anime='{ "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="ps-25px pe-25px mb-15px text-uppercase text-base-color fs-12 lh-40 fw-700 border-radius-100px d-inline-flex" style="background-color: {{ $item->bgcolor }}; color: {{ $item->color_title }}!important;" >{{ $titleBlocco[\App::getLocale()] }}</span>
                    <p>{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
            </div>
        </div>


@endif

    <div class="row p-1" data-anime='{ "el": "childs", "translateY": [0, 0], "perspective": [1200,1200], "scale": [1.1, 1], "rotateX": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>

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

                            $check = "thumb/blocks_documents/$temp[0]-large.webp";
                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($photo);
                            }
                        }

                    ?>

                    @if(trim($value->file) != "" || $value->file)
                            <?php $title = json_decode($value->title, true); ?>

                    <div class="col-lg-{{ $item->col }} sm-grid-2col xs-grid-1col p-2">
                        <a href="{{ $value->file }}" target="{{ $type_href }}">
                            <div class="h-100 border-radius-6px box-shadow-quadruple-large text-center box-shadow-quadruple-large-hover" style="text-align: {{ $item->text_align }};">
                                <div class="pt-5 pb-5" style="background-color: {{ $value->bgcolor }};">
                                    @if(trim($value->foto) != "")
                                        <div class="feature-box-icon mb-30px sm-mb-20px" >
                                            <img src="{{ $foto }}" title="Immagine" loading="lazy">
                                        </div>
                                    @endif
                                </div>
                                <div class="border-top fs-16 p-15px lg-ps-25px lg-pe-25px md-ps-15px md-pe-15px last-paragraph-no-margin">
                                    <span style="color: {{ $value->color_title }}!important; font-size: 16px; font-weight: bold;">{{ $title[\App::getLocale()] }}</span><br>
                                    {!! $description[\App::getLocale()] !!}
                                </div>
                            </div>
                        </a>
                    </div>


                    @endif

                @endforeach
            @endif

    </div>
</section>
