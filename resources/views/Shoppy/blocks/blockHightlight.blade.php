<section class="page-section-ptb">
    <div class="container">

        <div class="row mt-70">
            <div class="col-lg-12 col-md-12">
                <div class="owl-carousel" data-nav-dots="true" data-items="3" data-md-items="3" data-sm-items="3" data-xs-items="2" data-xx-items="1" data-space="20">
                        @if($array)
                            @foreach($array as $value)
                                <?php
                                $title = json_decode($value->title, true);
                                $abstract = json_decode($value->abstract, true);
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

                                if(!key_exists(\App::getLocale(), $abstract)){
                                    $abstract[\App::getLocale()] = "";
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

                                <div class="col-lg-12 col-md-12">
                                    <div class="blog-entry mb-50">
                                        <div class="entry-image clearfix">
                                            <img class="img-fluid" src="{{ $value->foto }}" alt="">
                                        </div>
                                        <div class="blog-detail">
                                            <div class="team-info">
                                                <h5>{{ $title[\App::getLocale()] }}</h5>
                                                <p>{{ $abstract[\App::getLocale()] }}</p>
                                                <p>{!! $description[\App::getLocale()] !!}</p>
                                            </div>
                                            <div class="social-icons color clearfix">
                                                @if(trim($button[\App::getLocale()])!="")
                                                    <a target="{{ $type_href }}" class="button button-xl button-radius button-outline-white margin-top-20 button-font-2" href="{{ $url }}">
                                                        {{ $button[\App::getLocale()] }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @endif

                    </div><!-- end owl-carousel -->
                </div><!-- end container -->
            </div><!-- end bg-black-* -->

    </div>
</section>

