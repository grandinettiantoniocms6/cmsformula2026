        @if($array)
            <?php
            $i = 1;
            ?>
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
                $perc = $i%2;

                ?>
                <div class="vcamp-text-block-one mt-150 xl-mt-80 md-mt-80">
                    <div class="container">

                        <div class="row pb-{{ $item->pb }}">
                            @if($perc == 0)
                                <!-- second row lato front -->
                                <div class="col-xxl-5 col-xl-6 col-lg-7 ms-auto order-2 order-lg-1">
                                    <div class="text-wrapper pt-0">
                                        <div class="title-style-two">
                                            <h3 class="title mt-40">{{ $title[\App::getLocale()] }}</h3>
                                        </div>
                                        <p class="meta-info-text text-lg">{!! $description[\App::getLocale()] !!}</p>
                                        @if(trim($button[\App::getLocale()])!="")
                                            <br/><a target="{{ $type_href }}" class="theme-btn-four" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-5 mb-15 img-dx order-1 order-lg-2">
                                    <img src="{{ $value->foto }}" alt="">
                                </div>

                            @else

                                <!-- first row lato front -->
                                <div class="left-img-meta">
                                    <img src="{{ $value->foto }}" alt="">
                                </div>
                                <div class="col-xxl-5 col-xl-6 col-lg-7 ms-auto">
                                    <div class="text-wrapper pt-0">
                                        <div class="title-style-two">
                                            <h3 class="title mt-40">{{ $title[\App::getLocale()] }}</h3>
                                        </div>
                                        <p class="meta-info-text text-lg">{!! $description[\App::getLocale()] !!}</p>
                                        @if(trim($button[\App::getLocale()])!="")
                                            <br/><a target="{{ $type_href }}" class="theme-btn-four" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <?php $i++;?>
            @endforeach

        @endif
