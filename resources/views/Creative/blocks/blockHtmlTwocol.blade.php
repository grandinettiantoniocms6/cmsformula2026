<section class="page-section-ptb">
    <div class="container">
        <div class="row">
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

                    $url = "#";
                    if(trim($url_interno[\App::getLocale()]) != ""){
                        $url = "/{$url_interno[\App::getLocale()]}";
                    }else{
                        if(trim($url_esterno[\App::getLocale()]) != ""){
                            $url = $url_esterno[\App::getLocale()];
                        }
                    }

                    ?>

                    <div class="col-lg-6 pb-{{ $item->pb }}">
                        <img class="img-fluid mx-auto" src="{{ $value->foto }}" alt="">
                        <div class="round feature-border mb-30">
                            <div class="section-title">
                                <h2>{{ $title[\App::getLocale()] }}</h2>
                                <p>{!! $description[\App::getLocale()] !!}</p>
                                @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" class="button mt-20" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif
        </div>
    </div>
</section>
