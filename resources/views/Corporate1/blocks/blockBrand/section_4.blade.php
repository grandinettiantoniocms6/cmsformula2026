<section class="block-brand wow animate__fadeInUp style-4" data-wow-duration=".3s">
    <div class="container-lg">
        <h3 class="title text-{{ $item->title_align }}">{{ $item->title_it }}</h3>
        <div class="row justify-content-center">
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

                            <div class="col-lg-{{ $item->col }} col-sm-4 col-6 align-items-stretch">
                                <div class="py-1 wow animate__fadeInUp" data-wow-duration=".3s">
                                    @if(trim( $url_interno[\App::getLocale()], $url_esterno[\App::getLocale()])!="")
                                        <a class="card card-body rounded-none" target="{{ $type_href }}" href="{{ $url }}">
                                            <img class="img-fluid mx-auto" src="{{ $value->foto }}" title="" loading="lazy">
                                        </a>
                                    @else
                                        <div class="card card-body rounded-none border-0"><img class="img-fluid mx-auto" loading="lazy" src="{{ $value->foto }}" title=""></div>
                                    @endif
                                </div>
                            </div>

                @endforeach
            @endif

        </div>
    </div>
</section>
