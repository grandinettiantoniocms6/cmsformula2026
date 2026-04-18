<?php
    $website = \App\Models\WebsiteSetting::first();
    $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<section class="section-gap section-gap-x">
    <div class="container">
        <div class="row">

            <div class="skill-area py-120">
                <div class="{{ $item->fullwidth }}">
                    <div class="skill-wrap">

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

                                        <div class="row g-4 align-items-center justify-content-center" style="padding-bottom: {{ $item->pb }}px;">
                                            @if($perc == 0)

                                                <!-- secondo item -->

                                                <div class="col-xl-6 col-lg-6 order-lg-1 order-2">
                                                    <div class="about-content-area">
                                                        <div class="sec-heading">
                                                            @if(trim($title[\App::getLocale()])!="")
                                                                <h2 class="sec-title title-anim" style="color:{{ $value->txtcolor }}; margin-top: 50px;">{{ $title[\App::getLocale()] }}</h2>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="about-bottom-area">
                                                        <div class="mission-vision-box wow fadeInLeft" style="background-color: {{ $value->bgcolor }};" data-wow-delay=".5s">
                                                            @if(trim($value->icon) != "")
                                                                <span class="site-title-tagline" style="color: {{ $value->txtcolor }};">
                                                                    {!! $value->icon !!}
                                                                </span>
                                                            @endif
                                                            @if(trim($value->foto2) != "")
                                                                <span style="color: {{ $value->txtcolor }}; margin-top: 50px;">
                                                                    <img src="{{ $value->foto2 }}" title="" loading="lazy">
                                                                </span>
                                                            @endif

                                                            @if(trim($description[\App::getLocale()])!="")
                                                                <p class="desc">{!! $description[\App::getLocale()] !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="about-btn-area wow fadeInUp" data-wow-delay=".6s">
                                                        @if(trim($button[\App::getLocale()])!="")
                                                            <a class="tj-primary-btn" href="{{ $url }}" target="{{ $type_href }}" style="background-color:{{ $website-> btn_background }}; color:{{ $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};">
                                                                <span class="btn-text"><span>{{ $button[\App::getLocale()] }}</span></span>
                                                                <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                                                            </a>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="col-xl-6 col-lg-6 order-lg-2 order-1">
                                                    <div class="about-img-area style-2 wow fadeInLeft" data-wow-delay=".3s">
                                                        @if(trim($foto) != "")
                                                            <div class="about-img overflow-hidden">
                                                                <img data-speed=".8" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- / secondo item -->


                                            @else

                                                <!-- primo item -->
                                                <div class="col-xl-6 col-lg-6 order-lg-1 order-2">
                                                    <div class="about-img-area style-2 wow fadeInLeft" data-wow-delay=".3s">
                                                        @if(trim($foto) != "")
                                                            <div class="about-img overflow-hidden">
                                                                <img data-speed=".8" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 order-lg-2 order-1">
                                                    <div class="about-content-area">
                                                        <div class="sec-heading">
                                                            @if(trim($title[\App::getLocale()])!="")
                                                                <h2 class="sec-title title-anim" style="color:{{ $value->txtcolor }}; margin-top: 50px;">{{ $title[\App::getLocale()] }}</h2>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="about-bottom-area">
                                                        <div class="mission-vision-box wow fadeInLeft" style="background-color: {{ $value->bgcolor }};" data-wow-delay=".5s">
                                                            @if(trim($value->icon) != "")
                                                                <span class="site-title-tagline" style="color: {{ $value->txtcolor }};">
                                                                    {!! $value->icon !!}
                                                                </span>
                                                            @endif
                                                            @if(trim($value->foto2) != "")
                                                                <span style="color: {{ $value->txtcolor }}; margin-top: 50px;">
                                                                    <img src="{{ $value->foto2 }}" title="" loading="lazy">
                                                                </span>
                                                            @endif

                                                            @if(trim($description[\App::getLocale()])!="")
                                                                <p class="desc">{!! $description[\App::getLocale()] !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="about-btn-area wow fadeInUp" data-wow-delay=".6s">
                                                        @if(trim($button[\App::getLocale()])!="")
                                                            <a class="tj-primary-btn" href="{{ $url }}" target="{{ $type_href }}" style="background-color:{{ $website-> btn_background }}; color:{{ $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};">
                                                                <span class="btn-text"><span>{{ $button[\App::getLocale()] }}</span></span>
                                                                <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                                                            </a>
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
                </div>
            </div>

        </div>
    </div>
</section>
