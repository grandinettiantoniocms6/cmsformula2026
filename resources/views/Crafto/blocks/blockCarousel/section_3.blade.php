<section class="pt-50px overflow-hidden">
    <div class="container-fluid p-0">
        <div class="row align-items-center g-0">
            <div class="col-12 position-relative swiper-dark-pagination" data-anime='{ "translateX": [150, 0], "opacity": [0,1], "duration": 1200, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <div class="swiper overflow-visible" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 40, "centeredSlides": "true", "loop": true, "pagination": { "el": ".swiper-pagination-bullets-01", "clickable": true, "dynamicBullets": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "992": { "slidesPerView": 1.8 }, "768": { "slidesPerView": 1.8 }, "320": { "slidesPerView": 1.3 } }, "effect": "slide" }'>
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

                                        <div class="swiper-slide">
                                            <div class="gallery-box">
                                                @if(trim($value->foto) != "")
                                                    <a href="{{ $foto }}" data-group="lightbox-gallery" title="">
                                                        <div class="position-relative gallery-image bg-dark-gray overflow-hidden border-radius-6px">
                                                            <img src="{{ $foto }}" class="border-radius-6px w-100" alt="" />
                                                            <div class="d-flex align-items-center justify-content-center position-absolute top-0px left-0px w-100 h-100 gallery-hover move-bottom-top">
                                                                <div class="d-flex align-items-center justify-content-center w-75px h-75px rounded-circle bg-white">
                                                                    <i class="feather icon-feather-search text-dark-gray icon-extra-medium"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                            @endforeach
                        @endif

                    </div>
                </div>
                <!-- start slider pagination -->
                <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-style-01 swiper-pagination-bullets-01 position-static mt-40px"></div>
                <!-- end slider pagination -->
            </div>
        </div>
    </div>

</section>
