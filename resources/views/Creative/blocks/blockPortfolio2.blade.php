<?php
    // serve se volessi pilotare i colori bg pulsanti in impostazioni sito
    $website = \App\Models\WebsiteSetting::first();
?>
<section class="page-section-ptb">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h4 class="mb-30">{{ $item->name }}</h4>
                @if($array)

                    <div class="isotope columns-{{ $item->col }} {{ $item->style2 }}">
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
                            ?>

                                <!-- CICLA -->
                                <div class="grid-item">
                                    <div class="portfolio-item">
                                        @if(trim($value->foto) != "")
                                            <a class="d-block" target="{{ $type_href }}" href="{{ $url }}">
                                                <img src="{{ $value->foto }}" alt="">
                                            </a>
                                        @endif
                                        <div class="portfolio-overlay" style="background-color: {{ $website->color_gen1 }};">
                                            @if(trim($button[\App::getLocale()])!="")
                                                <h4 style="color: {{ $website->color_gen2 }};">
                                                    {{ $title[\App::getLocale()] }}
                                                </h4>
                                                <span class="text-white">
                                                    <a target="{{ $type_href }}" href="{{ $url }}">{{ $description[\App::getLocale()] }} | {{ $button[\App::getLocale()] }}</a>
                                                </span>
                                            @endif
                                        </div>
                                        <a class="popup portfolio-img" href="{{ $value->foto }}"><i class="fa fa-arrows-alt"></i></a>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
