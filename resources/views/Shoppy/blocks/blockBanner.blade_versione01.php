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


        <section class="shop-split split-section white-bg page-section-ptb">
            <div class="side-background">
                <div class="col-lg-6 img-side img-left">
                    <div class="img-holder img-cover" data-jarallax='{"speed": 0.6}' style="background-image: url({{ $value->foto }});">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-5">
                        <div class="shop-split-content">
                            <h1 class="mt-10">{{ $title[\App::getLocale()] }} </h1>
                            <p>{!! $description[\App::getLocale()] !!} </p>
                            @if(trim($button[\App::getLocale()])!="")
                                <a class="button black" target="{{ $type_href }}" href="{{ $url }}"> {{ $button[\App::getLocale()] }} </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>

@endforeach
@endif


