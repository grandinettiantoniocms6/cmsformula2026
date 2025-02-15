@if($array)
    @foreach($array as $value)
        <?php
        $title = json_decode($value->title, true);
        $description = json_decode($value->description, true);
        $url_interno = json_decode($value->url_interno, true);
        $url_esterno = json_decode($value->url, true);
        $button = json_decode($value->button, true);


        if(!key_exists(\App::getLocale(), $title)){
            $title[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $description)){
            $description[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $button)){
            $button[\App::getLocale()] = "";
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
        ?>
        <section class="page-section-1-ptb bg-overlay-black-40 popup-gallery o-hidden parallax" data-jarallax='{"speed": 0.6}' style="background-image: url({{ $value->foto }});">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="section-title mb-30">
                            <h6 class="text-white">{{ $title[\App::getLocale()] }}</h6>
                            <h2 class="text-white">{!! $description[\App::getLocale()] !!}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title mb-30">
                            @if(trim($button[\App::getLocale()])!="")
                                  <a target="{{ $type_href }}" class="button" href="{{ $url }}">
                                      <span>{{ $button[\App::getLocale()] }}</span>
                                  </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif
