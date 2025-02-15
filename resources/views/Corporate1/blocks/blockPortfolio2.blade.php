<?php $website = \App\Models\WebsiteSetting::first(); ?>
<section class="block-portfolio">
    <div class="{{ $item->fullwidth }}">
        <h4 class="section-title">{{ $item->name }}</h4>

        @if($array)
            <div class="grid row row-cols-1 row-cols-sm-2 row-cols-md-{{ $item->col }} {{ $item->style2 }}">
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

                    $check = "thumb/blocks_portfolio2s/$temp[0]-large.webp";
                    if(file_exists($check)){
                        $foto = url($check);
                    }else{
                        $foto = url($photo);
                    }
                }

                ?>
                    <div class="grid-item">
                        <div class="card mb-4">
                            @if(trim($foto) != "")
                                <a target="{{ $type_href }}" href="{{ $url }}">
                                    <img class="img-fluid" src="{{ $foto }}" loading="lazy" alt="{{ $description[\App::getLocale()] }}" loading="lazy">
                                </a>
                            @endif
                            <div class="card-overlay" style="background-color: {{ $website->color_gen1 }};">
                                @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" href="{{ $url }}"><h4 class="title">{{ $title[\App::getLocale()] }}</h4></a><br>
                                    <p>{{ $description[\App::getLocale()] }}</p>
                                    <a class="btn btn-primary" target="{{ $type_href }}" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
