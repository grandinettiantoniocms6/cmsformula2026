<section class="block-banner wow animate__fadeInUp" data-wow-duration=".3s">
    <div class="container">
        <div class="row gx-0">
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

                            <!-- cliclo qui -->
                            <div class="col-lg-{{ $item->col }} col-md-6">
                                <!-- se uso class="card-img" le immagini restano boxate -->
                                <a class="card" target="{{ $type_href }}" href="{{ $url }}">
                                    <img src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                                    <div class="card-img-overlay">
                                        @if(trim($title[\App::getLocale()])!="")
                                            <h5 class="title">{{ $title[\App::getLocale()] }}</h5>
                                        @endif
                                        <div class="description">{!! $description[\App::getLocale()] !!}</div>
                                        @if(trim($button[\App::getLocale()])!="")
                                            <span target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                                                {{ $button[\App::getLocale()] }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </div>


                @endforeach
            @endif
        </div>
    </div>
</section>





