<section class="mt-2">
    <div class="container">
        <div class="row">

            <div class="col-md-12 mb-40px sm-mb-30px">
                <div class="swiper" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loop": true, "navigation": { "nextEl": ".slider-one-slide-next-08", "prevEl": ".slider-one-slide-prev-08" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "992": { "slidesPerView": 1 }, "768": { "slidesPerView": 1 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
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
                                    @if(trim($value->foto) != "")
                                        <img src="{{ $foto }}" alt="" />
                                    @endif
                                </div>

                            @endforeach
                        @endif

                    </div>

                    <!-- start slider navigation -->
                        <div class="slider-one-slide-prev-08 swiper-button-prev bg-white-transparent-very-light text-white h-50px w-50px slider-navigation-style-01"><i class="fa-solid fa-angle-left"></i></div>
                        <div class="slider-one-slide-next-08 swiper-button-next bg-white-transparent-very-light text-white h-50px w-50px slider-navigation-style-01"><i class="fa-solid fa-angle-right"></i></div>
                        <!-- end slider navigation -->

                </div>
            </div>
        </div>
    </div>

</section>
