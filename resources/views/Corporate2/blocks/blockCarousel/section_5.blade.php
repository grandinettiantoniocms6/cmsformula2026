<!-- da fare se mi servisse titolo, descr e link -->

<section class="overflow-hidden bg-very-light-gray position-relative">
    <div class="container">
            <div class="row align-items-center" data-anime='{ "opacity": [0,1], "duration": 600, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-12">
                    <div class="outside-box-right-20 sm-outside-box-right-0">
                        <div class="swiper slider-one-slide" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loop": true, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
                            <div class="swiper-wrapper">

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
                                                <!-- start services box style -->
                                                <div class="services-box-style-03 last-paragraph-no-margin border-radius-6px overflow-hidden">
                                                    <div class="position-relative">
                                                        <a href="{{ $url }}" target="{{ $type_href }}">
                                                            @if(trim($value->foto) != "")
                                                                <img class="card-img" alt="{{ $title[\App::getLocale()] }}" src="{{ $foto }}" class="img-fluid" loading="lazy">
                                                            @endif
                                                        </a>

                                                    </div>
                                                    <div class="bg-white">
                                                        <div class="ps-65px pe-65px pt-30px pb-30px text-center">
                                                            <a href="{{ $url }}" target="{{ $type_href }}" class="d-inline-block fs-18 fw-700 text-dark-gray mb-5px">
                                                                <span style="color:{!! $item->color_title !!};">{{ $title[\App::getLocale()] }}</span></a>
                                                            <p>{{ $abstract[\App::getLocale()] }}</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center border-top border-color-extra-medium-gray pt-20px pb-20px ps-50px pe-50px position-relative text-center">
                                                            <a href="{{ $url }}" class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase">
                                                                @if(trim($button[\App::getLocale()])!="")
                                                                    <a class="btn btn-link btn-hover-animation-switch btn-medium fw-700 text-dark-gray text-uppercase" href="{{ $url }}" target="{{ $type_href }}">{{ $button[\App::getLocale()] }}</a>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end services box style -->
                                            </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
