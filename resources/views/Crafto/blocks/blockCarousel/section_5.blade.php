<section class="mt-2" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="container">
        <div class="row">

            <div class="col-md-12 mb-40px sm-mb-30px">
                <div class="swiper swiper-number-pagination-progress" data-slider-options='{ "slidesPerView": 1, "loop": true, "pagination": { "el": ".swiper-number-line-pagination", "clickable": true }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 4000, "stopOnLastSlide": true, "disableOnInteraction": false },"keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "fade" }' data-swiper-number-pagination-progress="true">
                    <div class="swiper-wrapper align-items-center">

                        @if($array)
                            @foreach($array as $value)
                                    <?php
                                    $title = json_decode($value->title, true);
                                    if($title === null){
                                        $title = [];
                                    }

                                    $abstract = json_decode($value->abstract, true);
                                    if($abstract === null){
                                        $abstract = [];
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

                                    if(!key_exists(\App::getLocale(), $abstract)){
                                        $abstract[\App::getLocale()] = "";
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

                                        $check = "thumb/blocks_carousels/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }

                                    ?>


                                <div class="swiper-slide border-radius-6px overflow-hidden">
                                    @if(trim($value->foto) != "")
                                        <img src="{{ $foto }}" alt="" />
                                    @endif
                                </div>

                            @endforeach
                        @endif

                    </div>

                    <!-- start slider pagination -->
                    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets d-block d-sm-none"></div>
                    <!-- end slider pagination -->
                    <!-- start slider pagination -->
                    <div class="swiper-pagination-wrapper d-flex align-items-center justify-content-center mt-25px">
                        <div class="number-prev fs-14 fw-600 text-dark-gray"></div>
                        <div class="swiper-pagination-progress bg-extra-medium-gray">
                            <span class="swiper-progress"></span>
                        </div>
                        <div class="number-next fs-14 fw-600 text-dark-gray"></div>
                    </div>
                    <!-- end slider pagination -->

                </div>
            </div>
        </div>
    </div>
    </div>
</section>
