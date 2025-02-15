<section class="masonry-main o-hidden">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-12">
                <div class="masonry columns-4 popup-gallery no-padding">
                    <div class="grid-sizer"></div>
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
                            ?>


                            <div class="masonry-item">
                                <div class="portfolio-item image-text">
                                    <a class="d-block" target="{{ $type_href }}" href="{{ $url }}">
                                        <img class="img-fluid" src="{{ $value->foto }}" alt="">
                                    </a>
                                        <div class="portfolio-overlay">
                                            <h4 class="text-white">{{ $title[\App::getLocale()] }}</h4>
                                            <span class="text-white">{!! $description[\App::getLocale()] !!}</span>

                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" class="button button-xl button-radius button-outline-white margin-top-20 button-font-2" href="{{ $url }}">
                                                    {{ $button[\App::getLocale()] }}
                                                </a>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
