<div class="partner-section-two pt-180 mb-200 lg-pt-50 lg-mb-100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-7 col-xl-8 col-lg-6 col-md-8 col-sm-10 m-auto">
                <div class="title-style-one text-{{ $item->title_align }}">
                    <h2 class="title" style="color: {{ $item->txtcolor }};">{{ $item->title_it }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-11 m-auto">
                <div class="partent-logos">
                    <div class="row g-0">

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

                                        <div class=" col-md-3 col-6">
                                            @if(trim( $url_interno[\App::getLocale()], $url_esterno[\App::getLocale()])!="")
                                                <div class="logo d-flex align-items-center justify-content-center">
                                                    <a target="{{ $type_href }}" href="{{ $url }}"><img src="{{ $value->foto }}" alt="" class="tran3s"></a>

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
        </div>
    </div>
</div>
