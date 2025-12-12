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

<section class="pt-{{ $item->pt }} pb-{{ $item->pb }}" style="background-color: {{ $item->bg_section_icon }}!important;" data-anime='{"scale": [0.1, 1], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
<div class="{{ $item->fullwidth }}">
        <div class="row justify-content-center mb-3">
            @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
                <div class="col-12 col-lg-12 text-center" data-anime='{"translateY": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="ps-25px pe-25px mb-15px text-uppercase text-base-color fs-12 lh-40 fw-700 border-radius-100px d-inline-flex" style="background-color: {{ $website->color_gen2 }}; color: {{ $website->color_gen3 }}!important;" >{{ $titleBlocco[\App::getLocale()] }}</span>
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


                                <div class="col-lg-{{ $item->col }} col-md-6 col-sm-6 mb-3 icon-with-text-style-09 transition-inner-all md-mb-30px" data-anime='{"scale": [0.1, 1], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                    <div class="feature-box" >
                                        <div class="box-move-bottom-top pt-10 pb-10 ps-10 pe-10 transition-inner-all" style="background-color: {{ $value->bgcolor }}!important;">

                                            @if($value->icon)
                                                <div class="feature-box-icon feature-box-icon-rounded icon-extra-large bg-slate-blue w-120px h-120px rounded-circle mb-25px box-shadow-medium mx-auto" style="color: {{ $item->color_icon }}!important;">
                                                    @if($url != "#")
                                                        <a target="{{ $type_href }}" href="{{ $url }}">{!! $value->icon !!}</a>
                                                    @else
                                                        {!! $value->icon !!}
                                                    @endif
                                                </div>
                                            @else
                                                @if(trim($value->foto) != "")
                                                    @if($url != "#")
                                                        <a target="{{ $type_href }}" href="{{ $url }}" ><img src="{{ $foto }}" title="" loading="lazy"></a>
                                                    @else
                                                        <img src="{{ $foto }}" title="" loading="lazy" class="mx-auto">
                                                    @endif
                                                @endif
                                            @endif

                                            <div class="feature-box-content last-paragraph-no-margin overflow-hidden">

                                                @if($url != "#")
                                                    <span class="d-inline-block fw-700 fs-20 pb-5 pt-10" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</span>
                                                    <p class="w-90 m-auto">{!! $description[\App::getLocale()] !!}</p>

                                                @else
                                                    <span class="d-inline-block fw-500 fs-18" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</span>
                                                    <p class="w-90 m-auto">{!! $description[\App::getLocale()] !!}</p>
                                                @endif
                                                @if(trim($button[\App::getLocale()])!="")
                                                    <div class="move-bottom-top mt-15px mb-30px">
                                                        <a target="{{ $type_href }}" href="{{ $url }}" style="color:{!! $value->color_text_button !!} ; background-color:{!! $value->bgcolor_button !!}; border-color: {!! $value->bgcolor_button !!};" class="btn btn-very-small btn-rounded btn-box-shadow ps-15px pe-15px pt-5px pb-5px lh-16">{{ $button[\App::getLocale()] }}</a>
                                                    <!-- If PDF exist -->
                                                    @if(trim($value->file) != "" || $value->file)
                                                        <a href="{{ $value->file }}" target="_blank" class="btn btn-very-small btn-rounded d-table d-lg-inline-block ps-15px pe-15px pt-5px pb-5px lh-16">
                                                            <span><i class="far fa-file-pdf"></i> {{ @$labels['pdf-download'] }}</span>
                                                        </a>
                                                    @endif


                                                        </div>
                                                @endif

                                            </div>
                                        </div>

                                    </div>
                                </div>


                    @endforeach
                @endif

            </div>
        </div>
</section>



