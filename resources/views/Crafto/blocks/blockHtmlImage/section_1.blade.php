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

<section class="background-position-center-top pb-0" style="background-color: {{ $item->bgcolor }}; margin-top: 0px">
    <div class="{{ $item->fullwidth }}">
        <div class="row mb-0 xs-mb-10 overlap-section">
            <div class="col-12 position-relative">
                <div class="swiper position-relative text-slider-style-04" data-slider-options='{ "autoHeight": true, "loop": true, "allowTouchMove": true, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "effect": "fade" }'>
                    <div class="swiper-wrapper">
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
                                    if(trim($url_interno[\App::getLocale()]) != ""){
                                        $url = "/{$url_interno[\App::getLocale()]}";
                                    }else{
                                        if(trim($url_esterno[\App::getLocale()]) != ""){
                                            $url = $url_esterno[\App::getLocale()];
                                        }
                                    }

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


                                    // serve per le thumb
                                    $photo = $value->foto;

                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }

                                    ?>

                                    <!-- start ciclo -->
                                <div class="swiper-slide">

                                    <!-- gallery 1 -->
                                    <div class="gallery-box">
                                        <a href="{{ $value->foto }}" data-group="lightbox-group-gallery-item-6" title="">
                                            <div class="position-relative gallery-image bg-slate-blue">
                                                <img src="{{ $value->foto }}" alt="" />
                                                <div class="d-flex align-items-center justify-content-center position-absolute top-0px left-0px w-100 h-100 gallery-hover move-bottom-top">
                                                    <i class="bi bi-camera icon-medium text-white"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="container position-absolute sm-position-relative bottom-0 right-0px z-index-1 swiper-slide-content">
                                        <div class="row justify-content-end align-items-end h-100">
                                            <div class="col-lg-5 col-md-7 p-0">
                                                <div class="bg-white p-12 lg-p-12" style="background-color: #f7f6f6!important;">
                                                    <h5 class="alt-font text-dark-gray fw-300 mb-20px ls-minus-2px">{{ $titleBlocco[\App::getLocale()] }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end ciclo -->
                            @endforeach
                        @endif

                    </div>

                    <!-- start slider navigation -->
                    <div class="slider-one-slide-prev-1 icon-small swiper-button-prev slider-navigation-style-07 bg-dark-gray text-white box-shadow-small"><i class="bi bi-arrow-down-left"></i></div>
                    <div class="slider-one-slide-next-1 icon-small swiper-button-next slider-navigation-style-07 bg-dark-gray text-white box-shadow-small"><i class="bi bi-arrow-up-right"></i></div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <!-- box bianco fisso -->
                <div class="bg-white p-6 lg-p-6">

                    <p class="w-50 mb-10px">{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
                <!-- box bianco fisso -->
            </div>
        </div>
    </div>
</section>

