@if($array)
    @foreach($array as $value)
            <?php

            $video = "";

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

        <style>
            #block-separator-{{ $value->id }} {
                --separator-block-bg: {{ $blockbg }};
                height: {{ $item->height }};
                margin-top: {{ $value->mt }}px;
                height: {{ $value->video_height }};
                margin-bottom: {{ $value->mb }}px;
            }
            #block-separator-{{ $value->id }} h{{ $value->h_title }} {
                color: {{ $value->color_title }};
            }
            #block-separator-{{ $value->id }} h{{ $value->h_subtitle }} {
                color: {{ $value->color_subtitle }};
            }
            #block-separator-{{ $value->id }} .section-title {
                text-align: {!! $value->align !!};
            }
            #block-separator-{{ $value->id }} .btn {
                background-color: {{ $value->color_button }};
                border-color: {{ $value->color_button }};
                color: {{ $value->color_txt_button }};
            }
        </style>

        <section id="block-separator-{{ $value->id }}" class="block-separator bg-overlay image-wrapper jarallax">
            <div class="container-fluid page-container">
                <div class="row mt-9">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-9 wow animate__fadeInLeft" data-wow-duration=".5s">
                        <video style="margin-left: 50px; max-width: 100%;" width="auto" height="{{ $value->video_height }}" autoplay muted loop playsinline>
                            <source src="{{ $value->video }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div style="position: absolute; bottom: 20px; left: 150px;">
                            @if(trim($button[\App::getLocale()])!="")
                                <a target="{{ $type_href }}" class="btn wow animate__fadeInLeft" data-wow-duration="1.5s" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                            @endif
                        </div>

                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3 d-flex justify-content-center">
                        <div class="section-title wow animate__fadeInRight" data-wow-duration=".3s" style="margin-left: 40px;">
                            <h{{ $value->h_title }}>{{ $title[\App::getLocale()] }}</h{{ $value->h_title }}>
                            <h{{ $value->h_subtitle }}>{{ $subtitle[\App::getLocale()] }}</h{{ $value->h_subtitle }}>

                            @if($description[\App::getLocale()])
                                <div class="description wow animate__fadeInDown" data-wow-duration=".3s">{!! $description[\App::getLocale()] !!}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(trim($value->foto) != "")
                <img src="{{ $foto }}" class="jarallax-img" loading="lazy" alt="{{ $title[\App::getLocale()] }}">
            @endif
        </section>
    @endforeach
@endif
