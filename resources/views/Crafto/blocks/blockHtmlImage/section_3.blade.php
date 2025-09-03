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

<section class="big-section overflow-hidden ps-6 pe-6" style="background-color: {{ $item->bgcolor }}; margin-top: 0px" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">

        @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
            <div class="row justify-content-center mb-3">
                <div class="col-12 col-xl-8 text-center">
                    <span class="text-uppercase text-dark-gray fw-500 lh-22 mb-10px d-block">{{ $titleBlocco[\App::getLocale()] }}</span>
                    <h2 class="fw-700 ls-minus-1px w-90 mx-auto sm-w-100">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                </div>
                <div class="col-lg-12"></div>
            </div>
        @endif

        <div class="row align-items-center">
            <div class="col-12 col-md-12">
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

                                    <!-- start text slider item -->
                                <div class="swiper-slide">
                                    @if(trim($foto) != "")
                                        <img src="{{ $foto }}" alt="" />
                                    @endif
                                    <div class="container position-absolute sm-position-relative bottom-0 right-0px z-index-1 swiper-slide-content">
                                        <div class="row justify-content-end align-items-end h-100">
                                            <div class="col-lg-5 col-md-7 p-0">
                                                <div class="bg-white p-16 lg-p-12">
                                                    @if(trim($title[\App::getLocale()]) != "")
                                                        <h2 class="alt-font text-dark-gray fw-600 mb-20px ls-minus-2px">{{ $title[\App::getLocale()] }}</h2>
                                                    @endif

                                                    @if(trim($description[\App::getLocale()]) != "")
                                                        <p class="w-90 mb-10px">{!! $description[\App::getLocale()] !!}</p>
                                                    @endif

                                                    @if(trim($button[\App::getLocale()])!="")
                                                        <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-link btn-hover-animation-switch btn-large text-dark-gray fw-800">
                                                            <span>
                                                                <span class="btn-text">{{ $button[\App::getLocale()] }}</span>
                                                                <span class="btn-icon"><i class="fa-solid fa-arrow-right fs-14"></i></span>
                                                                <span class="btn-icon"><i class="fa-solid fa-arrow-right fs-14"></i></span>
                                                            </span>
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end text slider item -->

                            @endforeach
                        @endif
                    </div>

                    <!-- start slider navigation -->
                    <div class="slider-one-slide-prev-1 icon-small swiper-button-prev slider-navigation-style-07 bg-dark-gray text-white box-shadow-small"><i class="bi bi-arrow-down-left"></i></div>
                    <div class="slider-one-slide-next-1 icon-small swiper-button-next slider-navigation-style-07 bg-dark-gray text-white box-shadow-small"><i class="bi bi-arrow-up-right"></i></div>
                </div>

            </div>
        </div>
</section>
<!-- end section -->

