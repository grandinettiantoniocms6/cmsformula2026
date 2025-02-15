<section class="block-carousel">
    <div class="container">
        @if($array)
            <div id="carousel-block-{{ $item->id }}" class="owl-carousel owl-theme owl-block-carousel"
                 data-toggle='owlcarousel'
                 data-margin='[20,20,20,20,20,20,20]'
                 data-autowidth='[false,false,false,false,false,false,false]'
                 data-autoplay='[true,5000]'
                 data-responsive='[1,{{ $item->smartphone }},{{ $item->tablet }},{{ $item->notebook }},{{ $item->pc }},{{ $item->pc }},{{ $item->pc }}]'
                 data-dots='[true,true,true,true,true,true,true]'
                 data-nav='[false,false,false,false,false,false,false]'
                 data-loop='true'
            >
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
                    <div class="item">
                        <div class="card bg-dark">
                            @if(trim($value->foto) != "")
                                <img class="card-img" alt="{{ $title[\App::getLocale()] }}" src="{{ $value->foto }}" class="img-fluid" loading="lazy">
                            @endif
                            <div class="card-img-overlay">
                                <h4 style="color:{!! $item->color_title !!};">{{ $title[\App::getLocale()] }}</h4>
                                <div class="description">{{ $abstract[\App::getLocale()] }}</div>
                                @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}" target="_blank">{{ $button[\App::getLocale()] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
