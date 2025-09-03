<section class="md-pt-0" data-anime='{"translateX": [50, 0], "opacity": [1,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">
        <div class="row">

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

                                if(!key_exists(\App::getLocale(), $url_interno)){
                                    $url = "";
                                }else{
                                    if(trim($url_interno[\App::getLocale()]) != ""){
                                        $url = "/{$url_interno[\App::getLocale()]}";
                                    }else{
                                        if(trim($url_esterno[\App::getLocale()]) != ""){
                                            $url = $url_esterno[\App::getLocale()];
                                        }
                                    }
                                }

                                if(!key_exists(\App::getLocale(), $title)){
                                    $title[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $button)){
                                    $button[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $description)){
                                    $description[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $url_interno)){
                                    $url_interno[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $url_esterno)){
                                    $url_esterno[\App::getLocale()] = "";
                                }

                                // serve per le thumb /
                                $photo = $value->foto;

                                // serve per le thumb
                                if($photo){
                                    $basename = basename($photo);
                                    $temp = explode(".", $basename);

                                    $check = "thumb/blocks_banners/$temp[0]-large.webp";
                                    if(file_exists($check)){
                                        $foto = url($check);
                                    }else{
                                        $foto = url($photo);
                                    }
                                }

                                ?>


                                    <div class="col-lg-{{ $item->col }} text-center interactive-banner-style-01 last-paragraph-no-margin mb-30px mt-30px">
                                        <figure class="m-0 position-relative hover-box border-radius-6px overflow-hidden">
                                            @if(trim($foto) != "")
                                                <img src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" title="{{ $title[\App::getLocale()] }}" />
                                            @endif

                                            <div class="position-absolute top-0px left-0px w-100 h-100 bg-gradient-gray-light-dark-transparent opacity-1"></div>
                                            <figcaption class="w-100 h-100 d-flex flex-column justify-content-end align-items-center p-30px">
                                                <div class="position-relative z-index-1">

                                                    @if(trim($button[\App::getLocale()])!="")

                                                        <a href="{{ $url }}" target="{{ $type_href }}" class="d-flex justify-content-center align-items-center mx-auto icon-box w-70px h-70px rounded-circle bg-white mb-50px box-shadow-quadruple-large"><i class="bi bi-arrow-right-short text-dark-gray icon-medium lh-0px"></i></a>
                                                        <a href="{{ $url }}" target="{{ $type_href }}" class="alt-font fs-22 fw-500 text-white d-block text-uppercase">{{ $button[\App::getLocale()] }}</a>

                                                        @if(trim($title[\App::getLocale()]) != "")
                                                            <span class="text-white fw-500 fs-22 sm-lh-26 xs-lh-28 sm-mb-5px">{{ $title[\App::getLocale()] }}</span>
                                                        @endif

                                                        @if(trim($description[\App::getLocale()]) != "")
                                                            <p class="text-white opacity-6 fs-18">{!! $description[\App::getLocale()] !!}</p>
                                                        @endif

                                                    @endif

                                                </div>
                                                <div class="box-overlay bg-dark-gray"></div>
                                            </figcaption>
                                        </figure>
                                    </div>

                        @endforeach
                    @endif

        </div>

    </div>

    </div>

</section>
