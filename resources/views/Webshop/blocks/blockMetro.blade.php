        @if($array)
            <?php
            $i = 1;
            ?>
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

                $perc = $i%2;

                // serve per le thumb
                $photo = $value->foto;

                // serve per le thumb
                    if($photo){
                        $basename = basename($photo);
                        $temp = explode(".", $basename);

                        $check = "thumb/blocks_metros/$temp[0]-large.webp";
                        if(file_exists($check)){
                            $foto = url($check);
                        }else{
                            $foto = url($photo);
                        }
                    }

                ?>

                @if($perc == 0)

                    <section>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-auto col-lg-6">
                                    <h2 class="mt-10">{{ $title[\App::getLocale()] }}</h2>
                                    <p>{!! $description[\App::getLocale()] !!}</p>
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="button mt-20" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                    @endif
                                </div>
                                <div class="col-md-auto col-lg-6 img-right">
                                    <img class="img-fluid" src="{{ $foto }}" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </section>

                    @else

                    <!-- blocco sopra-->
                    <section class="page-section pb-4">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-auto col-lg-6 img-left">
                                    <img class="img-fluid" src="{{ $foto }}" loading="lazy">
                                </div>
                                <div class="col-md-auto col-lg-6">
                                    <h2 class="mt-10">{{ $title[\App::getLocale()] }}</h2>
                                    <p>{!! $description[\App::getLocale()] !!}</p>
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="button mt-20" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                    @endif
                                </div>
                            </div>
                    </section>
                @endif
                <?php $i++;?>
            @endforeach
        @endif
