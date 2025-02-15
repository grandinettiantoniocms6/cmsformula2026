<section class="block-twocolumns">
    <div class="container">
        <div class="row space-{{ $item->pb }}">
            @if($array)
                @foreach($array as $value)
                    <?php

                    $title = json_decode($value->title, true);
                    if($title === null){
                        $title = [];
                    }

                    $pb = $item->pb;

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

                    $url = "#";
                    if(trim($url_interno[\App::getLocale()]) != ""){
                        $url = "/{$url_interno[\App::getLocale()]}";
                    }else{
                        if(trim($url_esterno[\App::getLocale()]) != ""){
                            $url = $url_esterno[\App::getLocale()];
                        }
                    }

                    // serve per le thumb
                    $photo = $value->foto;
                    $foto = null;
                    if($photo){
                        $basename = basename($photo);
                        $temp = explode(".", $basename);

                        $check = "thumb/blocks_htmltwocols/$temp[0]-large.webp";
                        if(file_exists($check)){
                            $foto = url($check);
                        }else{
                            $foto = url($photo);
                        }
                    }

                    ?>

                    <div class="col-lg-6 space-{{ $item->pb }}">
                        @if($foto)
                            <figure class="image">
                                <img class="img-fluid mx-auto" src="{{ $value->foto }}" loading="lazy">
                            </figure>
                        @endif
                        <div class="text mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="title">{{ $title[\App::getLocale()] }}</h2>
                                    <p class="description">{!! $description[\App::getLocale()] !!}</p>
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif
        </div>
    </div>
</section>
