<section class="page-section-ptb">
    <div class="container">
        <div class="row mt-70">
            <div class="col-lg-12 col-md-12">
                @if($array)
                    <div class="owl-carousel" id="slider-carosello" data-autoheight="true" data-nav-dots="true" data-items="{{ $item->pc }}" data-md-items=" {{ $item->notebook }}" data-sm-items=" {{ $item->tablet }}" data-xs-items=" {{ $item->smartphone }}" data-xx-items="1" data-space="20">

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
                            ?>
                            <div class="item">
                                <div class="blog-overlay">
                                    <div class="blog-image">
                                        @if(trim($value->foto) != "")
                                             <img class="img-fluid full-width" alt="" src="{{ $value->foto }}">
                                        @endif
                                    </div>
                                        <div class="blog-name">
                                            <h4 class="mt-15 text-white">{{ $title[\App::getLocale()] }}</h4>
                                            <span class="text-white">{{ $abstract[\App::getLocale()] }}</span>
                                                @if(trim($button[\App::getLocale()])!="")
                                                    <p><a target="{{ $type_href }}" class="button button-xl button-radius button-outline-white margin-top-40 button-font-2" href="{{ $url }}" target="_blank">
                                                        {{ $button[\App::getLocale()] }}
                                                    </a></p>
                                                @endif
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
