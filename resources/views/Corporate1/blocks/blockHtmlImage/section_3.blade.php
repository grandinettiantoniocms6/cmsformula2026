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

    <!-- start section -->
<section class="bg-nero-grey overlap-height" style="padding-top: 60px!important;">
    <div class="container overlap-gap-section">
        <div class="row">
            <div class="col-lg-12">
                @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
                    <span class="text-base-color fs-12 fw-600 ls-3px text-uppercase mb-5px d-block">{{ $titleBlocco[\App::getLocale()] }}</span>
                    <p>{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                @endif
            </div>
        </div>
    </div>
</section>


<section class="bg-dark-gray background-position-center-top pb-0">
    <div class="{{ $item->fullwidth }}">
        <div class="row mb-8 xs-mb-10 overlap-section">
            <div class="col-12 position-relative">
                <div class="vertical-title-center align-items-center position-absolute top-0px left-15px bg-base-color p-10px xs-p-5px h-270px sm-h-190px z-index-9 w-50px xs-w-40px">
                    <div class="title fs-14 ls-2px text-dark-gray fw-700 text-uppercase">Recent projects</div>
                </div>
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
                                    <img src="{{ $foto }}" alt="" />
                                    <div class="container position-absolute sm-position-relative bottom-0 right-0px z-index-1 swiper-slide-content">
                                        <div class="row justify-content-end align-items-end h-100">
                                            <div class="col-lg-5 col-md-7 p-0">
                                                <div class="bg-white p-16 lg-p-12">
                                                    <span class="text-dark-gray fs-15 text-uppercase ls-1px fw-700">Architecture</span>
                                                    <h2 class="alt-font text-dark-gray fw-600 mb-20px ls-minus-2px">{{ $title[\App::getLocale()] }}</h2>
                                                    <p class="w-90 mb-10px">{!! $description[\App::getLocale()] !!}</p>
                                                    <a href="demo-architecture-single-project-gallery.html" class="btn btn-link btn-hover-animation-switch btn-large text-dark-gray fw-800">
                                                                    <span>
                                                                        <span class="btn-text">Explore project</span>
                                                                        <span class="btn-icon"><i class="fa-solid fa-arrow-right fs-14"></i></span>
                                                                        <span class="btn-icon"><i class="fa-solid fa-arrow-right fs-14"></i></span>
                                                                    </span>
                                                    </a>
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

