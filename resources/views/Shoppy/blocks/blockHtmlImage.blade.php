<!-- da correggere!!!! -->
<section class="page-section-ptb">
    <div class="container">

            @if($array)
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
                    ?>
                        <div class="row">
                                <div class="col-lg-6">
                                    <div class="section-title">
                                        <h2>{{ $title[\App::getLocale()] }}</h2>
                                        <p>{!! $description[\App::getLocale()] !!}</p>
                                    </div>
                                    @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" class="button button-border-white mt-20" href="{{ $url }}">
                                        <span>{{ $button[\App::getLocale()] }}</span>
                                    </a>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <div class="owl-carousel" data-autoheight="true" data-nav-dots="true" data-items="1" data-md-items="1" data-sm-items="1" data-xs-items="1" data-xx-items="1" data-space="20">
                                        @if($value->foto)
                                            <div class="item">
                                                  <img src="{{ $value->foto }}" class="img-fluid full-width" alt="">
                                            </div>
                                        @endif
                                        @if($value->foto2)
                                            <div class="item">
                                                  <img src="{{ $value->foto2 }}" class="img-fluid full-width" alt="">
                                            </div>
                                         @endif
                                    </div>
                                </div>
                        </div><!-- end row -->
                @endforeach
            @endif
    </div>
</section>
<!-- end About section -->

