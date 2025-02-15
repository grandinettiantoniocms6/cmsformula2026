@if($array)
    @foreach($array as $value)
        <?php

        $title = json_decode($value->title, true);
        if($title === null){
            $title = [];
        }

        $alpha = $value->alpha;

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

        if(!key_exists(\App::getLocale(), $title)){
            $title[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $description)){
            $description[\App::getLocale()] = "";
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

        $type_href = $value->type_href;

        $url = "#";

        if(key_exists(\App::getLocale(), $url_interno)){
            if(trim($url_interno[\App::getLocale()]) != ""){
                $url = "/{$url_interno[\App::getLocale()]}";
            }else{
                if(key_exists(\App::getLocale(), $url_esterno)){
                    if(trim($url_esterno[\App::getLocale()]) != ""){
                        $url = $url_esterno[\App::getLocale()];
                    }
                }
            }
        }

        // serve per le thumb
        $photo = $value->foto;

        if($photo){
            $basename = basename($photo);
            $temp = explode(".", $basename);

            $check = "thumb/blocks_parallaxs/$temp[0]-large.webp";
            if(file_exists($check)){
                $foto = url($check);
            }else{
                $foto = url($photo);
            }
        }

        ?>

        <section class="image-wrapper bg-overlay bg-overlay-black-{{ $value->alpha }} jarallax block-parallax py-6">
            <img class="jarallax-img" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
            <div class="container">
                <h2 class="title">{{ $title[\App::getLocale()] }}</h2>
                <div class="description">{!! $description[\App::getLocale()] !!}</div>
                @if(trim($button[\App::getLocale()])!="")
                    <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                        <span>{{ $button[\App::getLocale()] }}</span>
                    </a>
                @endif
            </div>
        </section>
    @endforeach
@endif
