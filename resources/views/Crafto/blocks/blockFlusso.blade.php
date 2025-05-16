<section class="big-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10" data-anime='{ "el": "childs", "translateY": [15, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>

                @if($array)
                <?php $i = 1; ?>
                @foreach($array as $value)
                    <?php
                    $number = json_decode($value->number, true);
                    if($number === null){
                        $number = [];
                    }
                    $bg_number = json_decode($value->bg_number, true);
                    if($bg_number === null){
                        $bg_number = [];
                    }

                    $title = json_decode($value->title, true);
                    if($title === null){
                        $title = [];
                    }

                    $bg_title = json_decode($value->bg_title, true);
                    if($bg_title === null){
                        $bg_title = [];
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

                    if(key_exists(\App::getLocale(), $url_interno)){
                        if(trim($url_interno[\App::getLocale()]) != ""){
                            $url = "/{$url_interno[\App::getLocale()]}";
                        }else{
                            if(key_exists(\App::getLocale(), $url_esterno)){
                                if(trim($url_esterno[\App::getLocale()]) != ""){
                                    $url = $url_esterno[\App::getLocale()];
                                }
                            }
                        }
                    }

                    ?>



                            <div class="row border-bottom border-2 pb-50px mb-50px sm-pb-35px sm-mb-35px align-items-center">
                                <div class="col-md-1 text-center text-md-end md-mb-15px">
                                    <div class="fs-16 fw-600" style="color: {{ $value->bg_number }}">{{ $number[\App::getLocale()] }}</div>
                                </div>
                                <div class="col-md-7 offset-lg-1 icon-with-text-style-01 md-mb-25px">
                                    <div class="feature-box feature-box-left-icon-middle last-paragraph-no-margin">
                                        <div class="feature-box-content">
                                            <span class="d-inline-block mb-5px fs-20 ls-minus-05px" style="color: {{ $value->bg_title }}">{{ $title[\App::getLocale()] }} </span>
                                            <p class="w-90 md-w-100">{!! $description[\App::getLocale()] !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 text-center text-md-end">
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a href="{{ $url }}" target="{{ $type_href }}" class="btn btn-dark-gray btn-box-shadow btn-medium btn-switch-text btn-rounded">
                                        <span>
                                            <span class="btn-double-text" data-text="{{ $button[\App::getLocale()] }}">{{ $button[\App::getLocale()] }}</span>
                                        </span>
                                        </a>
                                    @endif
                                </div>
                            </div>


                @endforeach
            @endif
            </div>
        </div>
    </div>
</section>

