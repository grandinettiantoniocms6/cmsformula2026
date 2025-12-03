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

?>

<section style="margin-top: {{ $item->mt }}px;" data-anime='{"translateY": [50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }' >
    <div class="container-fluid col-lg-12 mx-auto">

                @if($titleBlocco[\App::getLocale()] != "" )
                    <p style="color:{{ $item->color_title }};"><b>{{ $titleBlocco[\App::getLocale()] }}</b></p>
                @endif

                    <ul>

                        @if($array)

                            @foreach($array as $value)
                                    <?php

                                    $title = json_decode($value->title, true);
                                    if($title === null){
                                        $title = [];
                                    }

                                    if($title){
                                        if(!key_exists(\App::getLocale(), $title)){
                                            $title[\App::getLocale()] = "";
                                        }
                                    }else{
                                        $title[\App::getLocale()] = "";
                                    }

                                    $label = json_decode($value->label, true);
                                    if($label === null){
                                        $label = [];
                                    }

                                    if($label){
                                        if(!key_exists(\App::getLocale(), $label)){
                                            $label[\App::getLocale()] = "";
                                        }
                                    }else{
                                        $label[\App::getLocale()] = "";
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

                                    if(!key_exists(\App::getLocale(), $label)){
                                        $label[\App::getLocale()] = "";
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




                                    ?>


                                <li>
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a href="{{ $url }}" target="{{ $type_href }}" >{{ $button[\App::getLocale()] }}</a>
                                    @endif

                                    @if(trim($label[\App::getLocale()]) != "")
                                        <div class="fw-600 lh-22 text-uppercase border-radius-30px ps-10px pe-10px fs-10 ms-10px d-inline-block align-middle" style="background-color:{{ $item->bgcolor_label }}; color:{{ $item->color_label }};">
                                            <b>{{ $label[\App::getLocale()] }}</b>
                                        </div>
                                    @endif

                                </li>

                            @endforeach
                        @endif

                </ul>
    </div>
</section>
