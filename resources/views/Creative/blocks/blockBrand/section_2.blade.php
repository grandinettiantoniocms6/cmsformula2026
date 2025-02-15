<div class="partner-slider-one border-top pt-60 mt-30 mb-70 lg-mt-10">
    <div class="container">
        <div class="row">
            <div class="col-xxl-7 col-xl-8 col-lg-6 col-md-8 col-sm-10 m-auto">
                <div class="title-style-one text-{{ $item->title_align }}">
                    <h4 class="title" style="color: {{ $item->txtcolor }};">{{ $item->title_it }}</h4><br/><br/>
                </div>
            </div>
        </div>
        <!--<h3 class="text-{{ $item->title_align }}" style="color: {{ $item->txtcolor }};">{{ $item->title_it }}<br/><br/></h3>-->

        <div class="partnerSliderOne">

                @if($array)
                    @foreach($array as $value)
                        <?php

                        $url_interno = json_decode($value->url_interno, true);
                        if($url_interno === null){
                            $url_interno = [];
                        }

                        $url_esterno = json_decode($value->url, true);
                        if($url_esterno === null){
                            $url_esterno = [];
                        }

                        $type_href = $value->type_href;

                        $url = "#";
                        if(key_exists(\App::getLocale(), $url_interno)){
                            if(trim($url_interno[\App::getLocale()]) != ""){
                                $url = "/{$url_interno[\App::getLocale()]}";
                            }
                        }
                        if(key_exists(\App::getLocale(), $url_esterno)){
                            if(trim($url_esterno[\App::getLocale()]) != ""){
                                $url = $url_esterno[\App::getLocale()];
                            }
                        }


                        ?>

                        <div class="item">
                            @if(trim( $url_interno[\App::getLocale()], $url_esterno[\App::getLocale()])!="")
                                <div class="img-meta d-flex align-items-center justify-content-center">
                                    <a target="{{ $type_href }}" href="{{ $url }}"><img src="{{ $value->foto }}" alt=""></a>

                                    @else
                                        <img src="{{ $value->foto }}" title="">
                                    @endif
                                </div>

                        </div>


                    @endforeach
                @endif

        </div>
    </div>
</div>
