<section class="big-section">
    <div class="container">
        <h3 class="title text-{{ $item->title_align }}">{{ $item->title_it }}</h3>
        <div class="row">

            <div class="row position-relative clients-style-08" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <div class="col swiper text-center feather-shadow" data-slider-options='{ "slidesPerView": 2, "spaceBetween":0, "speed": 6000, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": false, "autoplay": { "delay":0, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 6 }, "992": { "slidesPerView": 4 }, "768": { "slidesPerView": 3 } }, "effect": "slide" }'>
                    <div class="swiper-wrapper marquee-slide">

                        @if($array)
                            @foreach($array as $value)
                                <?php

                                $url_interno = json_decode($value->url_interno, true);
                                if($url_interno === null){
                                    $url_interno = [];
                                }

                                $url_esterno = json_decode($value->url, true);
                                if($url_esterno === null){
                                    $url_esterno = [];
                                }

                                $type_href = $value->type_href;

                                $url = "#";
                                if(key_exists(\App::getLocale(), $url_interno)){
                                    if(trim($url_interno[\App::getLocale()]) != ""){
                                        $url = "/{$url_interno[\App::getLocale()]}";
                                    }
                                }
                                if(key_exists(\App::getLocale(), $url_esterno)){
                                    if(trim($url_esterno[\App::getLocale()]) != ""){
                                        $url = $url_esterno[\App::getLocale()];
                                    }
                                }

                                // serve per le thumb se non lo uso la foto la richiamo così: src="{{ $value->foto }}"
                                $photo = $value->foto;

                                if($photo){
                                    $basename = basename($photo);
                                    $temp = explode(".", $basename);

                                    $check = "thumb/blocks_brands/$temp[0]-large.webp";
                                    if(file_exists($check)){
                                        $foto = url($check);
                                    }else{
                                        $foto = url($photo);
                                    }
                                }

                                ?>


                                <div class="swiper-slide">
                                    @if(trim( $url_interno[\App::getLocale()], $url_esterno[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" href="{{ $url }}">
                                            <img class="img-fluid mx-auto" src="{{ $foto }}" title="Brand" loading="lazy">
                                        </a>
                                    @else
                                        <img class="img-fluid mx-auto" src="{{ $foto }}" title="" loading="lazy">
                                    @endif


                                </div>


                    @endforeach
                @endif

            </div>

        </div>
    </div>
</section>






