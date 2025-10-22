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

<section class="pt-5 pb-5" style="background-color: {{ $item->bg_section_icon }}!important;" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }' >
    <div class="{{ $item->fullwidth }}">
        <div class="row justify-content-center mb-4">
            @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
                <div class="col-12 col-lg-12 text-center" data-anime='{"translateY": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="ps-25px pe-25px mb-15px text-uppercase text-dark-gray text-base-color fs-12 lh-40 fw-700 border-radius-100px d-inline-flex" style="background-color: {{ $website->color_gen2 }};" >{{ $titleBlocco[\App::getLocale()] }}</span>
                    <p>{!! $descriptionBlocco[\App::getLocale()] !!} </p>
                </div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center">

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



                    <div class="col-lg-{{ $item->col }} icon-with-text-style-03 md-mb-30px transition-inner-all" style="background-color: {{ $value->bgcolor }}!important;" data-anime='{"scale": [0.1, 1], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div class="feature-box ps-7 pe-7 sm-ps-4 sm-pe-4">

                            @if($value->icon)
                                <div class="feature-box-icon mb-30px sm-mb-20px icon-extra-large" style="color: {{ $item->color_icon }}!important;">
                                    {!! $value->icon !!}
                                </div>
                            @else
                                @if(trim($value->foto) != "")
                                    <div class="feature-box-icon mb-30px sm-mb-20px" >
                                        <img src="{{ $foto }}" title="" loading="lazy" class="mx-auto h-65px">
                                    </div>
                                @endif
                            @endif


                            <div class="feature-box-content last-paragraph-no-margin">
                                @if($url != "#")
                                    <span class="d-inline-block alt-font fw-700 text-dark-gray mb-5px fs-20" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</span>
                                    <p class="w-90 m-auto">{!! $description[\App::getLocale()] !!}</p>

                                @else
                                    <span class="d-inline-block alt-font fw-700 text-dark-gray mb-5px fs-20" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</span>
                                    <p class="w-90 m-auto">{!! $description[\App::getLocale()] !!}</p>
                                @endif

                            </div>

                        </div>
                    </div>


                @endforeach
            @endif

        </div>
    </div>
</section>
