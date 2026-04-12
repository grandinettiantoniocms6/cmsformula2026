<section class="block-scrollbar" id="block-scrollbar-{{ $item->id }}">
    <div class="container">
        @if($array)
            <div id="scrollbar-block-{{ $item->id }}" class="scrollbar-block">
                @foreach($array as $value)
                    <?php
                    $title = json_decode($value->title, true);
                    if($title === null){
                        $title = [];
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

                    $type_href = $value->type_href;

                    $url = "#";
                    if(trim($url_interno[\App::getLocale()]) != ""){
                        $url = "/{$url_interno[\App::getLocale()]}";
                    }else{
                        if(trim($url_esterno[\App::getLocale()]) != ""){
                            $url = $url_esterno[\App::getLocale()];
                        }
                    }

                    if(!key_exists(\App::getLocale(), $description)){
                        $description[\App::getLocale()] = "";
                    }

                    if(!key_exists(\App::getLocale(), $title)){
                        $title[\App::getLocale()] = "";
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

                    // serve per le thumb

                    $photo = $value->foto;

                    if($photo){
                        $basename = basename($photo);
                        $temp = explode(".", $basename);

                        $check = "thumb/blocks_scrollbars/$temp[0]-large.webp";
                        if(file_exists($check)){
                            $foto = url($check);
                        }else{
                            $foto = url($photo);
                        }
                    } ?>
                    <div class="item">
                        @if($value->icon)
                            <div class="icon" style="--icons-block-icon-bg: {!! $value->icon_color !!}; --icons-block-icon-color: {!! $value->icon_bgcolor !!};">
                                @if($url != "#")
                                    <a target="{{ $type_href }}" href="{{ $url }}">{!! $value->icon !!}</a>
                                @else
                                    {!! $value->icon !!}
                                @endif
                            </div>
                        @else
                            @if(trim($value->foto) != "")
                                @if($url != "#")
                                    <a target="{{ $type_href }}" href="{{ $url }}"><img src="{{ $value->foto }}" title="" loading="lazy"></a>
                                @else
                                    <img src="{{ $value->foto }}" title="" loading="lazy" class="mx-auto">
                                @endif
                            @endif
                        @endif

                        <div class="item-body">
                            @if(trim($title[\App::getLocale()])!="")
                                <h4 class="title">{{ $title[\App::getLocale()] }}</h4>
                            @endif
                            @if(trim($description[\App::getLocale()])!="")
                                <div class="description">{!! $description[\App::getLocale()] !!}</div>
                            @endif
                            @if(trim($button[\App::getLocale()])!="")
                                <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}" target="_blank">{{ $button[\App::getLocale()] }}</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>


@push('custom_scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    @if($array)
        <style>
            #block-scrollbar-{{ $item->id }} {
                margin-top: {{ $item->margin_top }}px;
                background-color: {{ $item->bgcolor }};
            }
            #block-scrollbar-{{ $item->id }} .title {
                color: {!! $item->color_title !!};
            }
            #block-scrollbar-{{ $item->id }} .item {
                text-align: center;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
        <script>
            var slider = tns({
                container: '#scrollbar-block-{{ $item->id }}',
                gutter: {{ $item->padding_item }},
                axis: 'vertical',
                edgePadding: 0,
                slideBy: 1,
                nav: false,
                controls: false,
                loop: true,
                mouseDrag: true,
                speed: {{ $item->speed }},
                autoplay: true,
                autoplayHoverPause: true,
                autoplayTimeout: 2000,
                responsive: {
                    0: {
                        items: {{ $item->smartphone }},
                        autoHeight: false,
                        autoWidth: false,
                        mouseDrag: false
                    },
                    768: {
                        items: {{ $item->smartphone }},
                        autoHeight: false,
                        autoWidth: false,
                    },
                    992: {
                        gutter: {{ $item->tablet }},
                        autoHeight: false,
                        autoWidth: false
                    },
                    1200: {
                        items: {{ $item->notebook }}
                    },
                    1400: {
                        items: {{ $item->pc }}
                    }
                },
                autoplayButtonOutput: false
            });

            slider.events.on('dragStart', function() {
                slider.pause();
            });
            slider.events.on('dragMove', function() {
                slider.pause();
            });
            slider.events.on('dragEnd', function() {
                slider.pause();
            });
        </script>
    @endif
@endpush
