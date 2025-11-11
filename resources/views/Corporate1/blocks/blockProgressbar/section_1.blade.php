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
<section class="background-position-center-top overflow-hidden sm-background-image-none pt-{{ $item->mt }}" style="background-color: {{ $item->bgcolor }};">
        <div class="{{ $item->fullwidth }}">
            <div class="row align-items-center justify-content-md-center">
                <div class="col-md-10 col-xl-10 col-lg-8 md-mb-50px" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <h3 class="fw-600 ls-minus-1px mb-20px" style="color: {{ $item->color_title }};">{{ $titleBlocco[\App::getLocale()] }}</h3>
                    <p class="w-85 lg-w-100 mb-35px">{!! $descriptionBlocco[\App::getLocale()] !!}</p>
@endif
                    <div class="row justify-content-center mb-40px">
                        <div class="col-12 progress-bar-style-03 mt-30px">


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

                                        $label = json_decode($value->label, true);
                                        if($label === null){
                                            $label = [];
                                        }

                                        $skill = json_decode($value->skill, true);
                                        if($skill === null){
                                            $skill = [];
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

                                        if(!key_exists(\App::getLocale(), $label)){
                                            $label[\App::getLocale()] = "";
                                        }

                                        if(!key_exists(\App::getLocale(), $skill)){
                                            $skill[\App::getLocale()] = "";
                                        }

                                        // serve per le thumb

                                        $photo = $value->foto;

                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_grids/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        ?>

                                            <!-- da formattare la foto -->
                                            @if(trim($value->foto) != "")
                                                <img src="{{ $foto }}" alt="" />
                                            @endif

                                            <div class="progress mb-13 lg-mb-15 md-mb-60px bg-extra-medium-gray">
                                                <div class="fs-18 fw-600 progress-bar-title d-inline-block" style="color: {{ $value->txtcolor_skill }};">{{ $skill[\App::getLocale()] }}</div>
                                                <div class="progress-bar m-0 border-radius-3px" style="background-color: {{ $value->bgcolor_skill }}; color: {{ $value->txtcolor_skill }};" role="progressbar" aria-valuenow="{{ $value->percent_skill }}" aria-valuemin="0" aria-valuemax="100" aria-label="consulting">
                                                </div>
                                                <span class="progress-bar-percent fs-16 fw-600">{{ $value->percent_skill }}%</span>
                                            </div>
                                            <!-- end progress bar item -->



                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
</section>
