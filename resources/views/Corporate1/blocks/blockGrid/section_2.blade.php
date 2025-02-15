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
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-xl-6 col-lg-8 text-center position-relative page-title-double-large">
                    <div class="d-flex flex-column justify-content-center extra-very-small-screen">
                        <h1 class="text-dark-gray alt-font ls-minus-1px fw-700 mb-20px">{{ $titleBlocco[\App::getLocale()] }}</h1>
                        <h2 class="d-inline-block fw-400 ls-0px w-80 xs-w-100 mx-auto">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<section class="pt-0 ps-11 pe-11 xl-ps-2 xl-pe-2" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-12">
                <ul class="blog-grid blog-wrapper grid-loading grid grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
                <li class="grid-sizer"></li>


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
                                    <!-- start blog item  -->
                                    <li class="grid-item">
                                        <div class="card border-0 border-radius-4px box-shadow-extra-large box-shadow-extra-large-hover">
                                                <div class="blog-image">
                                                    @if($url != "#")
                                                       <a href="{{ $url }}" target="{{ $type_href }}" class="d-block">
                                                    @endif

                                                    @if(trim($value->foto) != "")
                                                        <img src="{{ $foto }}" alt="" />
                                                    @else
                                                        <img src="{{ url("img/no-image.jpg") }}" alt="" />
                                                    @endif
                                                    @if($url != "#")
                                                      </a>
                                                    @endif

                                                    <div class="blog-categories">
                                                        <span class="categories-btn text-uppercase alt-font fw-600 fs-24 lh-26" style="font-size: 16px!important; background-color: {!! $value->bgcolor !!}; color: {!! $value->txtcolor !!};">{{ $text_etichetta[\App::getLocale()] }}</span>
                                                    </div>

                                                    <!-- If PDF exist -->
                                                    @if(trim($value->file) != "" || $value->file)
                                                        <div class="blog-categories">
                                                            <a href="{{ $value->file }}" target="_blank" class="categories-btn bg-white text-dark-gray text-dark-gray-hover text-uppercase alt-font fw-700">
                                                                <span><i class="far fa-file-pdf"></i> {{ @$labels['pdf-download'] }}</span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>


                                            <div class="card-body p-12">
                                                <span class="card-title mb-15px fw-600 fs-20 lh-26 text-dark-gray text-dark-gray-hover">{{ $title[\App::getLocale()] }}</span>
                                                <p>{!! $description[\App::getLocale()] !!}</p>

                                                <div class="author d-flex justify-content-center align-items-center position-relative overflow-hidden fs-14 text-uppercase">
                                                    @if(trim($button[\App::getLocale()])!="")
                                                        <div class="me-auto">
                                                            <span class="blog-date fw-500 d-inline-block">{{ $button[\App::getLocale()] }}</span>
                                                            <div class="d-inline-block author-name">
                                                                @if($url != "#")
                                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="card-link alt-font fs-12 text-uppercase text-dark-gray text-dark-gray-hover fw-700">{{ $button[\App::getLocale()] }}
                                                                        <i class="feather icon-feather-arrow-right icon-very-small"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="me-auto">
                                                            <span class="blog-date fw-500 d-inline-block">&nbsp;</span>
                                                            <div class="d-inline-block author-name">

                                                            </div>
                                                        </div>

                                                    @endif
                                                </div>

                                            </div>

                                        </div>
                                    </li>
                                    <!-- end blog item -->


                        @endforeach
                    @endif
                </ul>
            </div>

        </div>
    </div>
</section>
