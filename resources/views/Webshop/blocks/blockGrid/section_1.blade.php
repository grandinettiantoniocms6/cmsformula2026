<?php
$website = \App\Models\WebsiteSetting::first();
$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<section class="block-grids style-{{ $item->style }} space-{{ $item->mt }}" id="block-grids-{{ $item->id }}">
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

                        $text_etichetta = json_decode($value->text_etichetta, true);
                        if($text_etichetta === null){
                            $text_etichetta = [];
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

                        if(!key_exists(\App::getLocale(), $text_etichetta)){
                            $text_etichetta[\App::getLocale()] = "";
                        }

                        // serve per le thumb

                        $photo = $value->foto;

                        if($photo){
                            $basename = basename($photo);
                            $temp = explode(".", $basename);

                            $check = "thumb/blocks_grids/$temp[0]-large.webp";
                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($photo);
                            }
                        }
                        ?>


                                <div class="col-lg-{{ $item->col }} col-md-6 col-sm-6 mb-3">
                                    <div class="card wow animate__fadeInUp img-hover-zoomfast" data-wow-duration=".3s" style="background-color: {{ $item->box_bgcolor }}!important; border-style: none; border-radius: 0;">
                                        <div class="product-label-group">
                                            <label style="margin-left: 15px; margin-top: 15px; z-index: 9999999; font-size: 12px; padding: 3px 5px; border-radius: 4px; color: {{ $value->txtcolor }}!important; background-color: {{ $value->bgcolor }}; position: absolute;">{!! $text_etichetta[\App::getLocale()] !!}</label>
                                        </div>
                                        @if(trim($value->foto) != "")
                                            @if($url != "#")
                                                <a target="{{ $type_href }}" href="{{ $url }}"><img class="img-fluid card-img-top" src="{{ $foto }}" title="" loading="lazy"></a>
                                            @else
                                                <img class="img-fluid card-img-top" src="{{ $foto }}" title="" loading="lazy">
                                            @endif
                                        @endif

                                        <div class="card-body mt-4">
                                            <h4 class="title" style="color: {{ $item->title_color }}!important;">{{ $title[\App::getLocale()] }}</h4>
                                            <div class="description">{!! $description[\App::getLocale()] !!} </div>

                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" href="{{ $url }}" class="btn btn-primary"><span>{{ $button[\App::getLocale()] }}</span></a>
                                            @endif

                                            @if(trim($value->file) != "" || $value->file)
                                                <a href="{{ $value->file }}" target="_blank" class="btn btn-primary">
                                                    <span><i class="far fa-file-pdf"></i> {{ @$labels['pdf-download'] }}</span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                    @endforeach
                @endif
            </div>
        </div>
    </section>

