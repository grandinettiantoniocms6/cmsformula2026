<?php
    $service_intro = $item->service_intro;
?>

<div class="pricing-section-one mt-150 lg-mt-120">
    <div class="container">
        <div class="row">
            <div class="col-xxl-9 col-xl-10 col-lg-8 col-md-10 m-auto">
                <div class="title-style-one text-center">
                    <h2 class="title" style="font-size: 45px!important;">{!! $service_intro !!}</h2>
                </div> <!-- /.title-style-six -->
            </div>
        </div>

            @if($array)
                <div class="pricing-table-area-one">
                    <div class="row justify-content-center">
                            @foreach($array as $value)
                                <?php

                                $bg_color = $value->bg_color;
                                $color_license_title = $value->color_license_title;
                                $color_license_subtitle = $value->color_license_subtitle;
                                $price_1 = $value->price_1;
                                $price_2 = $value->price_2;
                                $color_price_1 = $value->color_price_1;
                                $color_price_2 = $value->color_price_2;

                                // Array che cicla i campi reapetable
                                $list_valori = [];
                                $listing = json_decode($value->listing, true);
                                if(key_exists(\App::getLocale(), $listing)){
                                    $list_valori = json_decode($listing[\App::getLocale()], true);
                                }
                                // item presenti nell'ingranaggio
                                $color_border = $item->color_border;
                                $col = $item->col;

                                $title = json_decode($value->title, true);
                                if($title === null){
                                    $title = [];
                                }

                                $license_title = json_decode($value->license_title, true);
                                if($license_title === null){
                                    $license_title = [];
                                }

                                $license_subtitle = json_decode($value->license_subtitle, true);
                                if($license_subtitle === null){
                                    $license_subtitle = [];
                                }

                                $service_title = json_decode($value->service_title, true);
                                if($service_title === null){
                                    $service_title = [];
                                }

                                $service_subtitle = json_decode($value->service_subtitle, true);
                                if($service_subtitle === null){
                                    $service_subtitle = [];
                                }

                                $license_note = json_decode($value->license_note, true);
                                if($license_note === null){
                                    $license_note = [];
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

                                if(!key_exists(\App::getLocale(), $button)){
                                    $button[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $title)){
                                    $title[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $license_title)){
                                    $license_title[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $license_subtitle)){
                                    $license_subtitle[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $license_note)){
                                    $license_note[\App::getLocale()] = "";
                                }

                                if(!key_exists(\App::getLocale(), $description)){
                                    $description[\App::getLocale()] = "";
                                }

                                ?>


                                    <div class="col-lg-{{ $item->col }}">
                                        <div class="pr-table-wrapper" style="border: 1px solid {{ $color_border }}!important;">
                                            @if(trim($value->foto) != "")
                                                <img src="{{ $value->foto }}" alt="" style="margin: -42px 50px 10px 0;">
                                            @endif
                                            <!--span style="margin: 0px 0 24px 0 ; background-color: #f314e7; padding: 3px; font-size: 11px; color: #ffffff; display: inline-block; letter-spacing: 1px;text-transform: uppercase;">Il più venduto</span-->
                                            <div class="pack-name" style="color: {{ $color_license_title }};">
                                                <p>{{ $title[\App::getLocale()] }}</p>
                                            </div>


                                            <div class="pack-details" style="color: {{ $color_license_subtitle }};">{{ $license_subtitle[\App::getLocale()] }}</div>
                                            <div class="top-banner d-md-flex" style="background-color: {{ $bg_color }}!important;">
                                                <div class="price" style="padding: 2px 20px 0 0!important; font-size: 14px!important;">
                                                    <span style="font-size: 16px; color: {{ $color_price_1 }};"><del>€ {{ $price_1 }}</del></span><br>
                                                    <span style="font-size: 28px; color: {{ $color_price_2 }};">€ {{ $price_2 }}</span>
                                                </div>
                                                <div>
                                                    <span>{!! $service_title[\App::getLocale()] !!}</span>
                                                    <em>{!! $service_subtitle[\App::getLocale()] !!}</em>
                                                </div>
                                            </div> <!-- /.top-banner -->
                                            <!-- Cicla i valori repeatable -->
                                            @if($list_valori)
                                                <ul class="pr-feature">
                                                    @foreach($list_valori as $valore)
                                                        <li>{{ $valore['name'] }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            <!-- /. Cicla i valori repeatable -->

                                            {!! $description[\App::getLocale()] !!}
                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" href="{{ $url }}" class="trial-button">{{ $button[\App::getLocale()] }}</a>
                                            @endif
                                            <div class="trial-text">{!! $license_note[\App::getLocale()] !!}</div>
                                        </div> <!-- /.pr-table-wrapper -->
                                    </div>
                            @endforeach
                    </div>
                </div>

            @endif

        </div>
</div>






