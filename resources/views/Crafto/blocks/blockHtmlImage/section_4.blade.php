
<section class="overflow-hidden big-section position-relative" style="background-color: {{ $item->bgcolor }}; margin-top: 0px" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="outside-box-right-50 lg-outside-box-right-65 sm-me-0">
                    <div class="swiper text-slider-style-02" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loop": true, "autoplay": { "delay": 4500, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1400": { "slidesPerView": 2, "spaceBetween": 130 }, "992": { "slidesPerView": 2, "spaceBetween": 80 }, "768": { "slidesPerView": 2, "spaceBetween": 50 } }, "effect": "slide" }'>
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

                                        <div class="swiper-slide">
                                            <div class="row">
                                                <div class="col-12 col-lg-4 pt-8 order-lg-1 order-2">
                                                    <div class="outside-box-right-10 xl-outside-box-right-15 lg-outside-box-right-30 md-me-0 position-relative">
                                                        @if(trim($title[\App::getLocale()]) != "")
                                                            <h3 class="ls-minus-1px fw-700 word-break-normal mb-40px sm-mb-20px">
                                                                <a href="{{ $url }}" target="{{ $type_href }}" class="text-dark-gray text-dark-gray-hover">{{ $title[\App::getLocale()] }}</a>
                                                            </h3>
                                                        @endif
                                                        @if(trim($description[\App::getLocale()]) != "")
                                                            <p>{!! $description[\App::getLocale()] !!}</p>
                                                        @endif
                                                    </div>
                                                    <div>

                                                        @if(trim($button[\App::getLocale()])!="")
                                                            <div class="d-inline-block align-middle">
                                                                <a href="{{ $url }}" target="{{ $type_href }}" class="text-dark-gray fs-18 fw-600 text-decoration-line-bottom">{{ $button[\App::getLocale()] }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-8 order-lg-2 order-1">
                                                    <a href="{{ $url }}" target="{{ $type_href }}">
                                                        @if(trim($foto) != "")
                                                            <img src="{{ $foto }}" class="border-radius-6px" alt=""/>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
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

