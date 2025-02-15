<div class="vcamp-text-block-one mt-300 xl-mt-200 md-mt-120 mb-100">
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

                ?>


                        <div class="container">
                            <div class="row">
                                <div class="col-xxl-5 col-xl-6 col-lg-7 ms-auto">
                                    <div class="text-wrapper pt-0">
                                        <div class="title-style-two">
                                            <h3 class="title">{{ $title[\App::getLocale()] }}</h3>
                                        </div>
                                        <p class="meta-info-text text-lg">{!! $description[\App::getLocale()] !!}</p>
                                        @if(trim($button[\App::getLocale()])!="")
                                            <a target="{{ $type_href }}" class="theme-btn-one ripple-btn" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="left-img-meta">
                            <img src="{{ $value->foto }}" alt="">
                        </div>

            @endforeach
        @endif
</div> <!-- /.vcamp-text-block-one -->
