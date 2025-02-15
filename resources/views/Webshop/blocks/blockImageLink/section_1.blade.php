<section class="block-imagelink">
    <div id="fullwidth-style1" class="{{ $item->fullwidth }}">
        @if($array)
            <?php $i = 1;?>
            @foreach($array as $value)
                <?php

                    $pb = $item->pb;
                    $icon = $value->icon;
                    $foto2 = $value->foto2;
                    $bgcolor = $value->bgcolor;
                    $txtcolor = $value->txtcolor;

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

                    $url = "#";
                    if(trim($url_interno[\App::getLocale()]) != ""){
                        $url = "/{$url_interno[\App::getLocale()]}";
                    }else{
                        if(trim($url_esterno[\App::getLocale()]) != ""){
                            $url = $url_esterno[\App::getLocale()];
                        }
                    }
                    $perc = $i%2;

                    // serve per le thumbs
                    $photo = $value->foto;

                    // serve per le thumb
                    if($photo){
                        $basename = basename($photo);
                        $temp = explode(".", $basename);

                        $check = "thumb/blocks_images_links/$temp[0]-large.webp";
                        if(file_exists($check)){
                            $foto = url($check);
                        }else{
                            $foto = url($photo);
                        }
                    }

                    ?>

                <div class="row space-{{ $item->pb }}">
                @if($perc == 0)

                    <!-- secondo item -->
                    <div class="col-lg-7 order-2 order-lg-1 wow animate__fadeInUp" data-wow-duration=".3s" style="background-color: {{ $value->bgcolor }};">
                        <div class="card-body">
                            @if(trim($value->icon) != "")
                                <div class="icon" style="color: {{ $value->txtcolor }}; margin-top: 50px;">
                                    {!! $value->icon !!}
                                </div>
                            @endif
                            @if(trim($value->foto2) != "")
                                <div class="icon" style="color: {{ $value->txtcolor }}; margin-top: 50px;">
                                    <img src="{{ $value->foto2 }}" loading="lazy">
                                </div>
                            @endif

                            @if(trim($title[\App::getLocale()])!="")
                                <h3 class="title" style="color: {{ $value->txtcolor }}; margin-top: 50px;">{{ $title[\App::getLocale()] }}</h3>
                            @endif

                            @if(trim($description[\App::getLocale()])!="")
                                <div class="description">{!! $description[\App::getLocale()] !!}</div>
                            @endif
                            @if(trim($button[\App::getLocale()])!="")
                                <a target="{{ $type_href }}" id="btn-imagelink-1" class="btn btn-primary" style="background-color:{{ $website-> btn_background }}; color:{{ $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-5 img-dx order-1 order-lg-2 wow animate__fadeInDown" data-wow-duration=".3s">
                        @if(trim($foto) != "")
                            <img class="img-fluid mx-auto" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                          @endif
                    </div>
                @else
                    <!-- primo item -->
                    <div class="col-lg-5 img-sx wow animate__fadeInUp" data-wow-duration=".3s">
                        @if(trim($foto) != "")
                            <img class="img-fluid mx-auto" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
                        @endif
                    </div>
                    <div class="col-lg-7 wow animate__fadeInDown" data-wow-duration=".3s" style="background-color: {{ $value->bgcolor }};">
                            <div class="card-body">
                                @if(trim($value->icon) != "")
                                    <div class="icon" style="color: {{ $value->txtcolor }}; ">
                                        {!! $value->icon !!}
                                    </div>
                                @endif
                                @if(trim($value->foto2) != "")
                                    <div class="icon" style="color: {{ $value->txtcolor }}; margin-top: 50px;">
                                        <img src="{{ $value->foto2 }}" title="" loading="lazy">
                                    </div>
                                @endif

                                @if(trim($title[\App::getLocale()])!="")
                                    <h3 class="title" style="color: {{ $value->txtcolor }}; margin-top: 50px;">{{ $title[\App::getLocale()] }}</h3>
                                @endif

                                @if(trim($description[\App::getLocale()])!="")
                                    <div class="description">{!! $description[\App::getLocale()] !!}</div>
                                @endif
                                @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" id="btn-imagelink-1" class="btn btn-primary" style="background-color:{{ $website-> btn_background }}; color:{{ $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row space-{{ $item->pb }}"></div>
                <?php $i++;?>
            @endforeach
        @endif
    </div>
</section>

