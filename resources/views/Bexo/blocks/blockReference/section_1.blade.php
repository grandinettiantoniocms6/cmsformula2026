<?php
$website = \App\Models\WebsiteSetting::first();

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
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-xl-12 col-lg-8 text-center position-relative page-title-double-large">
                    <div class="d-flex flex-column justify-content-center extra-very-small-screen">
                        <h1 class="text-dark-gray alt-font ls-minus-1px fw-700 mb-20px">{{ $titleBlocco[\App::getLocale()] }}</h1>
                        <h2 class="d-inline-block fw-400 ls-0px w-80 xs-w-100 mx-auto">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


<section class="pt-0 block-referenze style-{{ $item->style }}">
    <div class="container">
        <div class="row">

            @if($array)
                    <?php
                    $categories = [];
                    foreach($array as $value){

                        $category = json_decode($value->category, true);
                        if($category === null){
                            $category = [];
                        }

                        $categories[] = $category[\App::getLocale()];
                    }

                    $categories = array_unique($categories);
                    asort($categories);
                    ?>

                    <div class="col-12 text-center">
                        <!-- filter navigation -->
                        <ul class="portfolio-filter nav nav-tabs justify-content-center border-0 fw-500 alt-font pb-5">
                            <li class="nav active"><a data-filter="*" href="#">Tutti</a></li>
                            @if($categories)
                                @foreach($categories as $cat)
                                    <li class="nav"><a data-filter=".{{ \Str::slug($cat, '-') }}" href="{{ $cat }}">{{ $cat }}</a></li>

                                @endforeach
                            @endif

                        </ul>
                        <!-- end filter navigation -->
                    </div>
                </div>
    </div>

        <div class="{{ $item->fullwidth }}">
            <div class="col-12 filter-content">
                <ul class="portfolio-classic portfolio-wrapper grid-loading grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-{{ $item->col }}col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center">
                    <li class="grid-sizer"></li>
                    @foreach($array as $value)
                            <?php

                            $title = json_decode($value->title, true);
                            if($title === null){
                                $title = [];
                            }

                            $category = json_decode($value->category, true);
                            if($category === null){
                                $category = [];
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

                            if(!key_exists(\App::getLocale(), $category)){
                                $category[\App::getLocale()] = "";
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

                                $check = "thumb/blocks_references/$temp[0]-large.webp";
                                if(file_exists($check)){
                                    $foto = url($check);
                                }else{
                                    $foto = url($photo);
                                }
                            }

                            ?>


                        <!-- start portfolio item -->
                        <li class="grid-item selected {{ \Str::slug($category[\App::getLocale()], '-')  }} transition-inner-all" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            @if(trim($button[\App::getLocale()])!="")
                            <a href="{{ $url }}" target="{{ $type_href }}">
                                <div class="portfolio-box">
                                    <div class="portfolio-image bg-gradient-pink-orange">
                                        @if(trim($foto) != "")
                                            <img class="img-fluid" src="{{ $foto }}" alt="{{ $description[\App::getLocale()] }}" loading="lazy" />
                                        @endif
                                        @if(trim($button[\App::getLocale()])!="")
                                        <div class="portfolio-hover d-flex justify-content-center flex-column p-35px">
                                            <div class="alt-font fs-18 text-uppercase text-white fw-600"><span>{{ $title[\App::getLocale()] }}</span></div>
                                            <div class="d-block alt-font fs-14 lh-initial text-uppercase text-white opacity-7">
                                                <span>{{ $description[\App::getLocale()] }}<br><br>{{ $button[\App::getLocale()] }}</span>
                                                @endif
                                                <!-- For Clicktozoom
                                                    <a class="glightbox" data-src="{{ $value->foto }}" href="{{ $value->foto }}"><i class="bi bi-search"></i></a> -->
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- end portfolio item -->

                    @endforeach
                </div>
        @endif
        </div>
    </div>
</section>

