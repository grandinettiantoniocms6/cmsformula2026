<?php $website = \App\Models\WebsiteSetting::first(); ?>

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

                                    <div class="col-lg-6">
                                        <p class="skill-content wow fadeInUp" data-wow-delay=".25s">
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

                                            @if(trim($title[\App::getLocale()])!="")
                                                <h2 class="site-title" style="color:{{ $value->txtcolor }}; margin-top: 50px;">{{ $title[\App::getLocale()] }}</h2>
                                            @endif

                                            @if(trim($description[\App::getLocale()])!="")
                                                <p class="skill-text">{!! $description[\App::getLocale()] !!}</p>
                                            @endif

                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" id="btn-imagelink-1" class="theme-btn mt-5" style="background-color:{{ $website-> btn_background }}; color:{{ $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};" href="{{ $url }}">
                                                    {{ $button[\App::getLocale()] }}<i class="fas fa-arrow-right"></i></a>
                                            @endif

                                    </div>

                                    <div class="col-lg-6">
                                        <div class="skill-img wow fadeInLeft" data-wow-delay=".25s">
                                            @if(trim($foto) != "")
                                                <img src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy" >
                                            @endif
                                        </div>
                                    </div>
                                    <!-- / secondo item -->


                                @else

                                    <!-- primo item -->
                                    <div class="col-lg-6 popup-gallery">
                                        <div class="skill-img wow fadeInLeft" data-wow-delay=".25s">
                                            @if(trim($foto) != "")

                                                <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                                                    <div class="gallery-img">
                                                        <img src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy" >
                                                    </div>
                                                    <div class="gallery-content">
                                                        <a class="popup-img gallery-link" href="{{ $foto }}"><i
                                                                class="fal fa-plus"></i></a>
                                                    </div>
                                                </div>



                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <p class="skill-content wow fadeInUp" data-wow-delay=".25s">
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

                                            @if(trim($title[\App::getLocale()])!="")
                                                <h2 class="site-title" style="color:{{ $value->txtcolor }}; margin-top: 50px;">{{ $title[\App::getLocale()] }}</h2>
                                            @endif

                                            @if(trim($description[\App::getLocale()])!="")
                                                <p class="skill-text">{!! $description[\App::getLocale()] !!}</p>
                                            @endif

                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" id="btn-imagelink-1" class="theme-btn mt-5" style="background-color:{{ $website-> btn_background }}; color:{{ $website-> btn_txt_color }}; border-color:{{ $website-> btn_colorborder }};" href="{{ $url }}">
                                                    {{ $button[\App::getLocale()] }}<i class="fas fa-arrow-right"></i></a>
                                            @endif

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
