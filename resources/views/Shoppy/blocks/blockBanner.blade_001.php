<section class="featured-product white-bg page-section-ptb">
    <div class="container">
        <div class="row">

            @if($array)
                @foreach($array as $value)
                    <?php
                    $title = json_decode($value->title, true);
                    $description = json_decode($value->description, true);
                    $url_interno = json_decode($value->url_interno, true);
                    $url_esterno = json_decode($value->url, true);
                    $button = json_decode($value->button, true);

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

                    <div class="col-lg-6 sm-mt-40">
                        <div class="offer-banner-1 text-center">
                            <div class="banner-image bg-overlay-black-50">
                                <div class="line-effect">
                                    <img class="img-fluid" src="{{ $value->foto }}" alt="">
                                    <div class="overlay"></div>
                                </div>
                            </div>
                            <div class="banner-content">
                                <h1 class="uppercase text-white">{{ $title[\App::getLocale()] }}</h1>
                                <strong class="text-white">{!! $description[\App::getLocale()] !!}</strong>
                                @if(trim($button[\App::getLocale()])!="")
                                    <a class="button" target="{{ $type_href }}" href="{{ $url }}"> {{ $button[\App::getLocale()] }} <i class="fa fa-angle-right"></i></a>
                                @endif

                            </div>
                        </div>
                    </div>


                @endforeach
            @endif

        </div>
    </div>
</section>

