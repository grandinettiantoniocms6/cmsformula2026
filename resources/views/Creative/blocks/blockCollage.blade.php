@if($array)
    @foreach($array as $value)
        <?php

        $title_dx = json_decode($value->title_dx, true);
        if($title_dx === null){
            $title_dx = [];
        }

        $title_sx = json_decode($value->title_sx, true);
        if($title_sx === null){
            $title_sx = [];
        }

        $color_title_dx = $value->color_title_dx;
        if($color_title_dx === null){
            $color_title_dx = [];
        }

        $color_title_sx = $value->color_title_sx;
        if($color_title_sx === null){
            $color_title_sx = [];
        }

        $description_dx = json_decode($value->description_dx, true);
        if($description_dx === null){
            $description_dx = [];
        }

        $description_sx = json_decode($value->description_sx, true);
        if($description_sx === null){
            $description_sx = [];
        }

        $url_dx_interno = json_decode($value->url_dx_interno, true);
        if($url_dx_interno === null){
            $url_dx_interno = [];
        }

        $url_dx_esterno = json_decode($value->url_dx, true);
        if($url_dx_esterno === null){
            $url_dx_esterno = [];
        }

        $button_dx = json_decode($value->button_dx, true);
        if($button_dx === null){
            $button_dx = [];
        }

        $type_dx_href = $value->type_dx_href;


        $url_sx_interno = json_decode($value->url_sx_interno, true);
        if($url_sx_interno === null){
            $url_sx_interno = [];
        }

        $url_sx_esterno = json_decode($value->url_sx, true);
        if($url_sx_esterno === null){
            $url_sx_esterno = [];
        }

        $button_sx = json_decode($value->button_sx, true);
        if($button_sx === null){
            $button_sx = [];
        }

        $type_sx_href = $value->type_sx_href;

        if(!key_exists(\App::getLocale(), $description_dx)){
            $description_dx[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $title_dx)){
            $title_dx[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $button_dx)){
            $button_dx[\App::getLocale()] = "";
        }

        $url_dx = "#";
        if(trim($url_dx_interno[\App::getLocale()]) != ""){
            $url_dx = "/{$url_dx_interno[\App::getLocale()]}";
        }else{
            if(trim($url_dx_esterno[\App::getLocale()]) != ""){
                $url_dx = $url_dx_esterno[\App::getLocale()];
            }
        }

        if(!key_exists(\App::getLocale(), $description_sx)){
            $description_sx[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $title_sx)){
            $title_sx[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $button_sx)){
            $button_sx[\App::getLocale()] = "";
        }

        $url_sx = "#";
        if(trim($url_sx_interno[\App::getLocale()]) != ""){
            $url_sx = "/{$url_sx_interno[\App::getLocale()]}";
        }else{
            if(trim($url_sx_esterno[\App::getLocale()]) != ""){
                $url_sx = $url_sx_esterno[\App::getLocale()];
            }
        }

        ?>


        <section id="about-us" class="service-07 page-section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-7">
                        @if($value->foto_sx)
                            <img class="img-fluid" src="{{ $value->foto_sx }}" alt="">
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-5 col align-self-center">
                        <div class="agency-02-about-content-right sm-mt-30 sm-mb-50">
                            <h3 class="position-relative" style="color: {{ $value->color_title_dx }};"> {{ $title_dx[\App::getLocale()] }} </h3>
                            <p class="mt-20 mb-30">{!! $description_dx[\App::getLocale()] !!} </p>
                            @if(trim($button_dx[\App::getLocale()])!="")
                                <a target="{{ $type_dx_href }}" class="button"  href="{{ $url_dx }}">
                                    <span>{{ $button_dx[\App::getLocale()] }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-6 col align-self-center">
                        <div class="agency-02-about-content-left sm-mb-50">
                            <h3 style="color: {{ $value->color_title_sx }};"> {{ $title_sx[\App::getLocale()] }}</h3>
                            <p class="mt-20 mb-30">{!! $description_sx[\App::getLocale()] !!} </p>
                            @if(trim($button_sx[\App::getLocale()])!="")
                                <a target="{{ $type_sx_href }}" class="button" href="{{ $url_sx }}">
                                    <span>{{ $button_sx[\App::getLocale()] }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-6">
                        @if($value->foto_dx)
                            <img class="img-fluid full-width" src="{{ $value->foto_dx }}" alt="">
                        @endif
                    </div>
                </div>

            </div>
        </section>
    @endforeach
@endif
