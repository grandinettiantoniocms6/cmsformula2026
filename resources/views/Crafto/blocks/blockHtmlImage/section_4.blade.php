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
        <div class="row justify-content-center mb-3">

            <div class="col-lg-6 col-md-10 md-mb-50px">
                <div class="swiper swiper-light-pagination" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loop": true, "pagination": { "el": ".swiper-pagination-bullets-07", "clickable": true, "dynamicBullets": false }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "992": { "slidesPerView": 1 }, "768": { "slidesPerView": 1 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
                    <div class="swiper-wrapper align-items-center">

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
                                <div class="swiper-slide border-radius-6px overflow-hidden">
                                    @if(trim($foto) != "")
                                        <img src="{{ $foto }}" alt="" />
                                    @endif
                                </div>
                                <!-- end text slider item -->

                            @endforeach
                        @endif

                        <!-- start slider navigation -->
                        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-style-1 swiper-pagination-bullets-07"></div>
                    </div>

                </div>

            </div>

            @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
                <div class="col-lg-6 col-md-10 md-mb-50px">
                    <span style="background-color: {{ $website->color_gen2 }}; color: {{ $website->color_gen3 }};" class="ps-25px pe-25px mb-15px text-uppercase text-base-color fs-12 lh-40 fw-700 border-radius-100px d-inline-flex" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        {{ $titleBlocco[\App::getLocale()] }}
                    </span>
                    <p>{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
            @endif



        </div>
    </div>
</section>


