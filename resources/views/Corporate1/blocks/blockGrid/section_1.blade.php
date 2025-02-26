<?php
    $website = \App\Models\WebsiteSetting::first();
    $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

    $titleBlocco = json_decode($item->title, true);
    if($titleBlocco){
        if(!key_exists(\App::getLocale(), $titleBlocco)){
            $titleBlocco[\App::getLocale()] = "";
        }
    }else{
        $titleBlocco[\App::getLocale()] = "";
    }

    $descriptionBlocco = json_decode($item->description, true);
    if($descriptionBlocco){
        if(!key_exists(\App::getLocale(), $descriptionBlocco)){
            $descriptionBlocco[\App::getLocale()] = "";
        }
    }else{
        $descriptionBlocco[\App::getLocale()] = "";
    }

?>

@if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")

<div class="portfolio-area py-120">
    <div class="{{ $item->fullwidth }}">

        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="site-heading text-center">
                    <h2 class="site-title">{{ $titleBlocco[\App::getLocale()] }}</h2>
                    <span>{!! $descriptionBlocco[\App::getLocale()] !!}</span>
                    <div class="heading-divider"></div>
                </div>
            </div>
        </div>


@endif

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

                                <!-- start portfolio item -->
                                <div class="col-lg-{{ $item->col }} col-md-6 col-sm-12 mb-3">
                                    <div class="portfolio-item">
                                        @if($url != "#")
                                            <a href="{{ $url }}" target="{{ $type_href }}" class="pricing-item wow fadeInUp" data-wow-delay=".25s" style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInUp;">
                                                <div class="pricing-header" style="font-size: 16px!important; margin-bottom: 8px; background-color: {!! $value->bgcolor !!}; color: {!! $value->txtcolor !!};">
                                                    {{ $text_etichetta[\App::getLocale()] }}
                                                </div>
                                                <div>
                                                    @if(trim($value->foto) != "")
                                                        <img src="{{ $foto }}" alt="" />
                                                    @else
                                                        <img src="{{ url("img/no-image.jpg") }}" alt="" />
                                                    @endif

                                                </div>
                                            </a>
                                        @endif

                                        <div class="portfolio-content">
                                            <div class="portfolio-info">
                                                <h4 style="color: {{ $item->title_color }}!important;"><a href="{{ $url }}" target="{{ $type_href }}" >{{ $title[\App::getLocale()] }}</a></h4>
                                                <p><br>{!! $description[\App::getLocale()] !!}<br> </p>

                                                @if(trim($button[\App::getLocale()])!="")
                                                    <a target="{{ $type_href }}" href="{{ $url }}" class="btn btn-very-small " style="background-color:{{ $website-> btn_background }}; color:{{  $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};"><span>{{ $button[\App::getLocale()] }}</span></a>
                                                @endif

                                            </div>



                                            <!-- If PDF exist -->
                                            @if(trim($value->file) != "" || $value->file)
                                                <a href="{{ $value->file }}" target="_blank" class="btn btn-base-color btn-very-small">
                                                    <span><i class="far fa-file-pdf"></i> {{ @$labels['pdf-download'] }}</span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <!-- end portfolio item -->

                            @endforeach
                       @endif

            </div>

    </div>
</div>

