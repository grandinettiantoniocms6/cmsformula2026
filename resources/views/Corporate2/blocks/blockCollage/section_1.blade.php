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

            if(!key_exists(\App::getLocale(), $url_sx_interno)){
                $url_sx_interno[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $url_dx_interno)){
                $url_dx_interno[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $url_sx_esterno)){
                $url_sx_esterno[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $url_dx_esterno)){
                $url_dx_esterno[\App::getLocale()] = "";
            }

            $url_sx = "#";
            if(trim($url_sx_interno[\App::getLocale()]) != ""){
                $url_sx = "/{$url_sx_interno[\App::getLocale()]}";
            }else{
                if(trim($url_sx_esterno[\App::getLocale()]) != ""){
                    $url_sx = $url_sx_esterno[\App::getLocale()];
                }
            }

            // serve per le thumb
            $photo = $value->foto_sx;

            // serve per le thumb
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_collages/$temp[0]-largesx.webp";
                if(file_exists($check)){
                    $foto1 = url($check);
                }else{
                    $foto1 = url($photo);
                }
            }

            // serve per le thumb
            $photo = $value->foto_dx;
            // serve per le thumb
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_collages/$temp[0]-largedx.webp";
                if(file_exists($check)){
                    $foto2 = url($check);
                }else{
                    $foto2 = url($photo);
                }
            }
            ?>

            <?php if( trim($value->color_title_sx) != "" || trim($value->color_title_sx) != "" ){ ?>
        <style>
            #block-collage-{{ $value->id }} {
                --collage-block-title-sx-color: {{ $value->color_title_sx }};
                --collage-block-title-dx-color: {{ $value->color_title_dx }};
            }
        </style>
        <?php } ?>

        <section class="block-collage" id="block-collage-{{ $value->id }}">
            <div class="{{ $item->fullwidth }} space-{{ $item->mt }}">
                <div class="row row-title-dx space-{{ $item->pb }}">
                    <div class="col-lg-7 col-md-7 wow animate__fadeInDown" data-wow-duration=".3s">
                        @if($value->foto_sx)
                            <img class="img-fluid" src="{{ $foto1 }}" alt="{{ $title_dx[\App::getLocale()] }}" loading="lazy">
                        @endif
                    </div>
                    <div class="col-lg-5 col-md-5 col align-self-center wow animate__fadeInUp" data-wow-duration=".3s">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="title">{{ $title_dx[\App::getLocale()] }} </h3>
                                <p class="description">{!! $description_dx[\App::getLocale()] !!}</p>
                                @if(trim($button_dx[\App::getLocale()])!="")
                                    <a target="{{ $type_dx_href }}" class="btn btn-primary" href="{{ $url_dx }}">
                                        <span>{{ $button_dx[\App::getLocale()] }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-title-sx space-{{ $item->pb }}">
                    <div class="col-lg-5 col-md-5 col align-self-center order-2 order-md-1 wow animate__fadeInDown" data-wow-duration=".3s">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="title">{{ $title_sx[\App::getLocale()] }}</h3>
                                <p class="description">{!! $description_sx[\App::getLocale()] !!} </p>
                                @if(trim($button_sx[\App::getLocale()])!="")
                                    <a target="{{ $type_sx_href }}" class="btn btn-primary" href="{{ $url_sx }}">
                                        <span>{{ $button_sx[\App::getLocale()] }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg- col-md-7 order-1 order-md-2 wow animate__fadeInUp" data-wow-duration=".3s">
                        @if($value->foto_dx)
                            <img class="img-fluid full-width" src="{{ $foto2 }}" alt="{{ $title_sx[\App::getLocale()] }}" loading="lazy">
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif
