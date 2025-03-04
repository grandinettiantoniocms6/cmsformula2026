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
        <div class="pa-bg" style="background-color: {{ $item->bgcolor }}; margin-top: 0px"></div>
        <div class="{{ $item->fullwidth }}">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-arrow-alt-circle-down"></i> {{ $titleBlocco[\App::getLocale()] }}</span>
                        <h2 class="site-title text-white">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                    </div>
                </div>
            </div>

            @endif

            <div class="row popup-gallery">
                <div class="portfolio-slider owl-carousel">

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

                                    $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                    if(file_exists($check)){
                                        $foto = url($check);
                                    }else{
                                        $foto = url($photo);
                                    }
                                }

                                ?>

                                <!-- ciclo -->

                            <div class="portfolio-item">
                                <div class="portfolio-img">
                                    @if(trim($value->foto) != "")
                                        <img class="img-fluid" src="{{ $foto }}" alt="">
                                        <a class="popup-img portfolio-link" href="{{ $foto }}"> <i
                                                class="far fa-plus"></i></a>
                                    @endif
                                </div>

                                <div class="portfolio-content">
                                    <div class="portfolio-info">
                                        @if($url != "#")
                                            <h4><a href="{{ $url }}" target="{{ $type_href }}">{{ $title[\App::getLocale()] }}</a></h4>
                                    </div>

                                    <a href="{{ $url }}" target="{{ $type_href }}" class="portfolio-arrow"><i
                                            class="fas fa-arrow-right"></i></a>
                                    @endif
                                </div>
                            </div>

                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>


