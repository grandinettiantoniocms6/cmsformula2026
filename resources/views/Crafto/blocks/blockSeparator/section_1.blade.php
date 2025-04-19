@if($array)
    @foreach($array as $value)
            <?php
            $title = json_decode($value->title, true);
            if($title === null){
                $title = [];
            }

            $subtitle = json_decode($value->subtitle, true);
            if($subtitle === null){
                $subtitle = [];
            }

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

            if(!key_exists(\App::getLocale(), $title)){
                $title[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $subtitle)){
                $subtitle[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $description)){
                $description[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $button)){
                $button[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $url_interno)){
                $url_interno[\App::getLocale()] = "";
            }

            if(!key_exists(\App::getLocale(), $url_esterno)){
                $url_esterno[\App::getLocale()] = "";
            }

            $type_href = $value->type_href;

            $url = "#";

            if(key_exists(\App::getLocale(), $url_interno)){
                if(trim($url_interno[\App::getLocale()]) != ""){
                    $url = "/{$url_interno[\App::getLocale()]}";
                }else{
                    if(key_exists(\App::getLocale(), $url_esterno)){
                        if(trim($url_esterno[\App::getLocale()]) != ""){
                            $url = $url_esterno[\App::getLocale()];
                        }
                    }
                }
            }

            // serve per le thumb se non lo uso la foto la richiamo così: src="{{ $value->foto }}"
            $photo = $value->foto;

            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_separators/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto = url($check);
                }else{
                    $foto = url($photo);
                }
            }

            // Sfondo

            switch ($value->alpha) {
                case 0:
                    $alpha_bg = '00';
                    break;
                case 100:
                    $alpha_bg = '';
                    break;
                default:
                    $alpha_bg = $value->alpha;
            }

            $blockbg = $value->bgcolor.$alpha_bg;

            ?>

            <!-- Velina o layer trasparente sopra img o colore sfondo -->
            <style>
                .banner::after { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: linear-gradient(120deg, #131313, #1f1f1f); opacity: 0.{{ $value->alpha }}; }
                .banner { position: relative; min-height: 60vh; background-size: cover; display: flex; }
                .banner::before { z-index: -1; }
                .banner > * { z-index: 2; }
            </style>
            <!-- Velina o layer trasparente sopra img o colore sfondo -->


            <!-- start section -->
            @if(trim($value->foto) != "")
                <section class="banner position-relative" data-parallax-background-ratio="0.5" style="background-image: url('{{ $foto }}'); margin-top: {{ $item->mt }}px!important; margin-bottom: {{ $item->mb }}px!important;">
            @else
                <section id="{{ $item->id }}" style="background-color: {!! $value->bgcolor !!}; margin-top: {{ $item->mt }}px!important; margin-bottom: {{ $item->mb }}px!important; height: {{ $item->height }}!important; ">
            @endif

                <div class="{{ $item->fullwidth }}" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <div class="row justify-content-center align-items-center min-h-500px row">

                        <div class="col-12 col-xl-8 col-lg-10 position-relative text-center">

                            @if(trim($value->foto2) != "")
                                <img src="{{ $value->foto2 }}" class="img-fluid" loading="lazy" alt="{{ $title[\App::getLocale()] }}">
                            @endif

                            <span class="fw-500 text-uppercase mt-15px d-inline-block ls-1px" style="color: {{ $value->color_subtitle }};">{{ $subtitle[\App::getLocale()] }}</span>
                            <h1 class="mx-auto alt-font fw-500 mt-15px ls-minus-2px" style="color: {{ $value->color_title }};">{{ $title[\App::getLocale()] }}</h1>

                            @if($description[\App::getLocale()])
                                <div class="description wow animate__fadeInUp" data-wow-duration=".9s">{!! $description[\App::getLocale()] !!}</div>
                            @endif

                            @if(trim($button[\App::getLocale()])!="")
                                <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-medium btn-gradient-pink-orange">{{ $button[\App::getLocale()] }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            <!-- end section -->

    @endforeach
@endif
