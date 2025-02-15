<section class="block-icons style-{{ $item->style }}" id="block-icons-{{ $item->id }}">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            @if($array)
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

                        if(!key_exists(\App::getLocale(), $title)){
                            $title[\App::getLocale()] = "";
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

                        // serve per le thumb

                        $photo = $value->foto;

                        if($photo){
                            $basename = basename($photo);
                            $temp = explode(".", $basename);

                            $check = "thumb/blocks_icons/$temp[0]-large.webp";
                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($photo);
                            }
                        }
                        ?>

                        <style>
                            #block-icons-{{ $item->id }} .icon {
                                color: {{ $item->color_icon }};
                                background-color: {{ $value->bgcolor }};
                                border-color: {{ $value->color_icon }};
                            }
                            #block-icons-{{ $item->id }} .icon:hover {
                                background-color: {{ $item->bgcolor_hover }};
                                color: {{ $item->color_icon }};
                            }
                            #block-icons-{{ $item->id }} .btn {
                                color: {{ $value->color_text_button }};
                                background-color: {{ $value->bgcolor_button }};
                                border-color: {{ $value->bgcolor_button }};
                            }
                            #block-icons-{{ $item->id }} .btn:hover {
                                background-color: {{ $item->bgcolor_button_hover }}!important;
                                border-color: {{ $item->bgcolor_button_hover }}!important;
                            }
                            a:link { text-decoration: none!important; };
                        </style>

                        <div class="col-lg-{{ $item->col }} col-md-6 col-sm-6 mb-3">
                            <div class="card wow animate__fadeInUp" data-wow-duration=".3s" style="background-color: {{ $value->bgcolor }}!important;">
                                @if($value->icon)
                                    <div class="icon">
                                        @if($url != "#")
                                            <a target="{{ $type_href }}" href="{{ $url }}">{!! $value->icon !!}</a>
                                        @else
                                            {!! $value->icon !!}
                                        @endif
                                    </div>
                                @else
                                    @if(trim($value->foto) != "")
                                        @if($url != "#")
                                            <a target="{{ $type_href }}" href="{{ $url }}"><img src="{{ $foto }}" title="" loading="lazy"></a>
                                        @else
                                            <img src="{{ $foto }}" title="" loading="lazy">
                                        @endif
                                    @endif
                                @endif

                                <div class="card-body">
                                    @if($url != "#")
                                        <a target="{{ $type_href }}" href="{{ $url }}">
                                            <h5 style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</h5>
                                            <div class="description">{!! $description[\App::getLocale()] !!} </div>
                                        </a>
                                    @else
                                        <h5 style="color:{!! $value->color_title !!};">{{ $title[\App::getLocale()] }}</h5>
                                        <div class="description">{!! $description[\App::getLocale()] !!} </div>
                                    @endif

                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="color:{!! $value->color_text_button !!} ; background-color:{!! $value->bgcolor_button !!}; border-color: {!! $value->bgcolor_button !!};"><span>{{ $button[\App::getLocale()] }}</span></a>
                                    @endif
                                </div>
                            </div>
                        </div>

                @endforeach
            @endif
        </div>
    </div>
</section>
