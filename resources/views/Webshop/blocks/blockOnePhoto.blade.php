@if($array)

    @push('custom_scripts')
        <link rel="stylesheet" href="{{ asset('packages/jquery-typewriter/dist/css/cursor.css') }}"/>
        <script src="{{ asset('packages/jquery-typewriter/dist/js/jquery.typewriter.js') }}"></script>
    @endpush

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

        // serve per le thumb
        $photo = $value->foto;

        if($photo){
            $basename = basename($photo);
            $temp = explode(".", $basename);

            $check = "thumb/blocks_one_photos/$temp[0]-large.webp";
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

        $blockbg = $value->bg_color.$alpha_bg;

        ?>

        <style>
            #block-one-photo-{{ $value->id }} {
                --onephoto-block-bg: {{ $blockbg }};
            }
            #block-one-photo-{{ $value->id }} {
                @if($item->height) --onephoto-block-height: {{ $item->height }}; @endif
                @if($item->height_mobile)
                    @media screen and (max-width: 767px) {
                        --onephoto-block-height: {{ $item->height_mobile }};
                    }
                @endif
            }
            #block-one-photo-{{ $value->id }} .section-title {
                text-align: {!! $value->text_align !!};
            }
            #block-one-photo-{{ $value->id }} .btn {
                background-color: {{ $value->color_button }};
                border-color: {{ $value->color_button }};
                color: {{ $value->color_txt_button }};
            }
        </style>

        <section id="block-one-photo-{{ $value->id }}" class="block-one-photo bg-overlay image-wrapper jarallax" style="background-color: {{ $value->bg_color }};">
            <div class="caption alignment-{{ $value->text_align }}">
                <div class="caption-inner" style="margin-top: {{ $item->mt }};">
                    <h1 id="onephoto_font_size_title" class="title" style="font-size: {{ $value->font_size_title }}px;">{{ $title[\App::getLocale()] }}</h1>

                    @if(trim($subtitle[\App::getLocale()])!="")
                        <h3 id="onephoto_font_size_subtitle" class="subtitle" style="font-size: {{ $value->font_size_subtitle }}px;">{{ $subtitle[\App::getLocale()] }}</h3>
                    @endif

                    @if(trim($description[\App::getLocale()])!="")
                       <div class="description">{{ strip_tags($description[\App::getLocale()] ) }}</div>
                    @endif

                    @if(trim($button[\App::getLocale()])!="")
                        <a target="{{ $type_href }}" class="btn mt-3" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                    @endif
                </div>
            </div>
            @if(trim($value->foto) != "")
                <img src="{{ $foto }}" class="jarallax-img" loading="lazy" alt="{{ $title[\App::getLocale()] }}">
            @endif
        </section>

        @push('custom_scripts')
            <script>
                $(document).ready(() => {
                    $('#block-one-photo-{{ $value->id }} .title') // titolo deve stare per forza
                        .typeWrite({
                            speed: {{ $item->speed }},
                            // questi sono $value in quanto stanno nelle righe
                            repeat: false,
                            cursor: '{{ $value->cursor_title }}',
                            color: '{{ $value->color_title }}',
                            interval: 1000,
                        })
                        @if(trim($subtitle[\App::getLocale()])!="") // se c'è sottotitolo
                        .then((res) => {
                            console.log(res)
                            $('#block-one-photo-{{ $value->id }} .subtitle').typeWrite({
                                speed: {{ $item->speed }},
                                // questi sono $value in quanto stanno nelle righe
                                repeat: false,
                                cursor: false,
                                color: '{{ $value->color_subtitle }}',
                                interval: 1000,
                            })
                            @if(trim($description[\App::getLocale()])!="")  // se c'è descrizione
                            .then((res) => {
                                console.log(res)
                                $('#block-one-photo-{{ $value->id }} .description').typeWrite({
                                    speed: {{ $item->speed }},
                                    // questi sono $value in quanto stanno nelle righe
                                    repeat: false,
                                    cursor: false,
                                    color: '{{ $value->color_description }}',
                                    interval: 1000,
                                })
                                @if(trim($button[\App::getLocale()])!="") // se c'è pulsante
                                    .then((res) => {
                                        console.log(res)
                                        $('#block-one-photo-{{ $value->id }} .btn').css('visibility', 'visible');
                                    })
                                @endif
                            })
                            @else // se NON c'è descrizione
                                @if(trim($button[\App::getLocale()])!="") // se c'è pulsante
                                .then((res) => {
                                    console.log(res)
                                    $('#block-one-photo-{{ $value->id }} .btn').css('visibility', 'visible');
                                })
                                @endif
                            @endif
                        })
                        @else // se NON c'è sottotitolo
                            @if(trim($description[\App::getLocale()])!="") // se c'è descrizione
                                .then((res) => {
                                    console.log(res)
                                    $('#block-one-photo-{{ $value->id }} .description').typeWrite({
                                        speed: {{ $item->speed }},
                                        // questi sono $value in quanto stanno nelle righe
                                        //if($value->repeat_title == 0) repeat: false else  repeat: true endif,
                                        repeat: false,
                                        cursor: true,
                                        color: '{{ $value->color_description }}',
                                        interval: 1000,
                                    })
                                    @if(trim($button[\App::getLocale()])!="") // se c'è pulsante
                                        .then((res) => {
                                            console.log(res)
                                            $('#block-one-photo-{{ $value->id }} .btn').css('visibility', 'visible');
                                        })
                                    @endif
                                })
                            @else // se NON c'è descrizione
                                @if(trim($button[\App::getLocale()])!="") // se c'è pulsante
                                    .then((res) => {
                                        console.log(res)
                                        $('#block-one-photo-{{ $value->id }} .btn').css('visibility', 'visible');
                                    })
                                @endif
                            @endif
                        @endif
                });
            </script>
        @endpush

    @endforeach
@endif
