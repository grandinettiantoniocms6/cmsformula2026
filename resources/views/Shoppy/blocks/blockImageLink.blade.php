<section class="white-bg page-section-ptb">
    <div class="container">
        @if($array)
            <?php
                $i = 1;
            ?>
            @foreach($array as $value)
                <?php
                $title = json_decode($value->title, true);
                $description = json_decode($value->description, true);
                $url_interno = json_decode($value->url_interno, true);
                $url_esterno = json_decode($value->url, true);
                $button = json_decode($value->button, true);
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
                $perc = $i%2;
                ?>
                <div class="row mt-2">
                    @if($perc == 0)
                        <div class="col-lg-6">
                            <div class="section-title">
                                <h3 class="font-weight margin-bottom-20">{{ $title[\App::getLocale()] }}</h3>
                                <p>{!! $description[\App::getLocale()] !!}</p>
                                @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" class="button button-lg" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 sm-mt-50 mb-30">
                            <img class="img-fluid mx-auto" src="{{ $value->foto }}" alt="">
                        </div>
                    @else
                        <div class="col-lg-6 sm-mt-50 mb-30">
                            <img class="img-fluid mx-auto" src="{{ $value->foto }}" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="section-title">
                                <h3 class="font-weight margin-bottom-20">{{ $title[\App::getLocale()] }}</h3>
                                <p>{!! $description[\App::getLocale()] !!}</p>
                                @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" class="button button-lg" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                                @endif
                            </div>
                        </div>
                    @endif


                </div>
                <?php $i++;?>
            @endforeach
       @endif
    </div><!-- end container -->
</section>
