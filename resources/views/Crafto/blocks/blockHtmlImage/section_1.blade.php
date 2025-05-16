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

<section class="big-section overflow-hidden ps-6 pe-6" style="background-color: {{ $item->bgcolor }}; margin-top: 0px">
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
                    <div class="outside-box-right-30 sm-outside-box-right-0">
                        <div class="swiper" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 25, "loop": true, "autoplay": { "delay": 300000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
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

                                        <!-- start content carousal item -->
                                        <div class="swiper-slide">
                                            <div class="interactive-banner-style-09 position-relative overflow-hidden">
                                                @if(trim($foto) != "")
                                                    <img src="{{ $foto }}" alt="" />
                                                @endif
                                                <div class="opacity-full-dark bg-gradient-black-bottom-transparent"></div>
                                                <div class="image-content h-100 w-100 p-10 xl-p-30px sm-pe-15px sm-ps-15px text-center d-flex justify-content-end align-items-end flex-column">
                                                    <div class="w-100">
                                                        @if(trim($button[\App::getLocale()])!="")
                                                            <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-medium btn-rounded btn-box-shadow btn-white text-uppercase fw-700 ps-15px pe-15px pt-5px pb-5px lh-16 mb-20px">{{ $button[\App::getLocale()] }}</a>
                                                        @endif

                                                        <div class="alt-font fw-700 sliding-box-title mb-10px w-80 xl-w-100 md-w-90 sm-w-70 xs-w-100 mx-auto">
                                                            @if(trim($title[\App::getLocale()]) != "")
                                                                <a href="{{ $url }}" target="{{ $type_href }}" class="text-white alt-font fw-600 fs-40 lg-fs-24 ls-minus-1px lg-ls-0px">{{ $title[\App::getLocale()] }}</a>
                                                            @endif
                                                            @if(trim($description[\App::getLocale()]) != "")
                                                                <p>{!! $description[\App::getLocale()] !!}</p>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end content carousal item -->

                                        @endforeach
                                    @endif

                                </div>

                        </div>
                    </div>
                </div>

            </div>
    </div>
</section>

