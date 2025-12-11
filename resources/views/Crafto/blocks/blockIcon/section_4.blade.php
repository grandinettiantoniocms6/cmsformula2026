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

<section class="cover-background " style="background-color: {{ $item->bg_section_icon }}!important; padding-top: 110px; padding-bottom: 110px;" >
    <div class="{{ $item->fullwidth }}">
        <div class="row justify-content-center mb-3">
            @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
                <div class="col-lg-8 text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 900, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="mb-5px text-uppercase d-block" style="color: {{ $website->color_gen3 }}!important;" >{{ $titleBlocco[\App::getLocale()] }}</span>
                    <h2 class="text-white fw-600 ls-minus-1px">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                </div>
            @endif
        </div>
        <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "scale":[0.8,1], "opacity": [0,1], "duration": 500, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>

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


                            <div class="col-lg-{{ $item->col }} icon-with-text-style-05 transition-inner-all lg-mb-30px" data-anime='{"scale": [0.1, 1], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <div class="feature-box hover-box dark-hover border-radius-10px border border-color-transparent-white-light border-color-transparent-on-hover last-paragraph-no-margin overflow-hidden">
                                    <div class="content-slide-up p-50px">

                                        <!-- icone -->
                                        @if($value->icon)
                                            <div class="feature-box-icon" style="color: {{ $item->color_icon }}!important; font-size: 70px; margin-bottom: 20px; display: flex; align-items: center; ">
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

                                        <!-- icone -->



                                       <!-- titolo e descriz -->



                                        <div class="feature-box-content">

                                            @if($url != "#")
                                                <a target="{{ $type_href }}" href="{{ $url }}">
                                                    <span class="d-inline-block alt-font fw-500 fs-17 mb-5px" style="color:{!! $value->color_title !!}; margin-top: 25px;">{{ $title[\App::getLocale()] }}</span>
                                                    <p>{!! $description[\App::getLocale()] !!} </p>
                                                </a>
                                            @else
                                                <span class="d-inline-block alt-font fw-500 fs-17 mb-5px" style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</span>
                                                <p>{!! $description[\App::getLocale()] !!} </p>
                                            @endif

                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" href="{{ $url }}" class="btn btn-very-small" style="color:{!! $value->color_text_button !!} ; background-color:{!! $value->bgcolor_button !!}; border-color: {!! $value->bgcolor_button !!};"><span>{{ $button[\App::getLocale()] }}</span></a>
                                            @endif
                                            <!-- If PDF exist -->
                                            @if(trim($value->file) != "" || $value->file)
                                                <br><br><a href="{{ $value->file }}" target="_blank" class="btn btn-link underline-on-hover btn-medium text-dark-gray d-table d-lg-inline-block xl-mb-15px md-mx-auto">
                                                    <span><i class="far fa-file-pdf"></i> {{ @$labels['pdf-download'] }}</span>
                                                </a>
                                            @endif






                                        </div>
                                        <div class="feature-box-overlay bg-gradient-fast-blue-purple"></div>




                                        <!-- titolo e descriz -->





                                    </div>
                                </div>
                            </div>

                @endforeach
            @endif

        </div>
    </div>
</section>
<!-- end section -->
