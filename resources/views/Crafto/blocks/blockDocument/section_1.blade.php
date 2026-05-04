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

    <section class="position-relative overflow-hidden pt-5">
        <div class="separator-line-9px bg-base-color position-absolute top-0px right-0px" data-bottom-top="width: 15%" data-center-top="width: 50%;"></div>
        <div class="container">
            <div class="row justify-content-center mb-2">
                <div class="col-xl-12 col-lg-9 col-md-10 text-center" data-anime='{ "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <span class="ps-25px pe-25px mb-15px text-uppercase fs-12 lh-40 fw-700 border-radius-100px d-inline-flex" style="background-color: {{ $website->color_gen2 }}; background-color: {{ $item->bgcolor }}; color: {{ $item->color_title }}!important;" >{{ $titleBlocco[\App::getLocale()] }}</span>
                    <p>{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
            </div>
        </div>
    </section>

@endif

<section class="bg-solitude-white">
    <div class="container mt-50px">
        <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center">
            <!--h2 class="title">{ @$labels['title-document'] }}</h2>-->
            @if($array)
                @foreach($array as $value)

                        <?php

                        $description = json_decode($value->description, true);
                        if($description === null){
                            $description = [];
                        }

                        if(!key_exists(\App::getLocale(), $description)){
                            $description[\App::getLocale()] = "";
                        }

                        ?>

                    @if(trim($value->file) != "" || $value->file)
                            <?php $title = json_decode($value->title, true); ?>

                        <div class="col-lg-{{ $item->col }} col-md-6 col-sm-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ $value->file }}" target="_blank">
                                        <div class="row">
                                            <div class="col-12 col-lg-2">
                                                <img src="/uploads/icone/pdf.png" title="PDF icon">
                                            </div>
                                            <div class="col-12 col-lg-9">
                                                <span style="font-size: 18px; font-weight: bold;">{{ $title[\App::getLocale()] }}</span><br>
                                                {!! $description[\App::getLocale()] !!}
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>

                    @endif
                @endforeach

            @endif
        </div>
    </div>
</section>
