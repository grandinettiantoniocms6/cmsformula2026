<section class="page-section-ptb elements-tabs">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @if($array)
                                <?php $i = 0; ?>
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

                                    /*$url_interno = json_decode($value->url_interno, true);
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
                                        }*/


                                    if(!key_exists(\App::getLocale(), $title)){
                                        $title[\App::getLocale()] = "";
                                    }

                                    if(!key_exists(\App::getLocale(), $description)){
                                        $description[\App::getLocale()] = "";
                                    }

                                   /* $url = "#";
                                    if(trim($url_interno[\App::getLocale()]) != ""){
                                        $url = "/{$url_interno[\App::getLocale()]}";
                                    }else{
                                        if(trim($url_esterno[\App::getLocale()]) != ""){
                                            $url = $url_esterno[\App::getLocale()];
                                        }
                                    }*/

                                    $active = "";
                                    if($i == 0){
                                        $active = "active";
                                    }
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $active }}"
                                            id="li-tab-{{ $value->id }}"
                                            data-toggle="tab"
                                            role="tab"
                                            aria-controls="{{ $value->id }}"
                                            href="#tab-{{ $value->id }}">{{ $title[\App::getLocale()] }}

                                        </a>

                                    </li>
                                   <?php $i++; ?>
                                @endforeach
                            @endif
                        </ul>

                    <div class="tab-content" id="myTabContent">
                        @if($array)
                            <?php $i = 0; ?>
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

                                /*$url_interno = json_decode($value->url_interno, true);
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
                                    }*/


                                /*$url = "#";


                                if(trim($url_interno[\App::getLocale()]) != ""){
                                    $url = "/{$url_interno[\App::getLocale()]}";
                                }else{
                                    if(trim($url_esterno[\App::getLocale()]) != ""){
                                        $url = $url_esterno[\App::getLocale()];
                                    }
                                }*/
                                $active = "";
                                $show = "";
                                if($i == 0){
                                    $active = "active";
                                    $show = "show";
                                }
                                ?>
                                 <div class="tab-pane fade {{ $active }} {{ $show }}" id="tab-{{ $value->id }}" role="tabpanel">
                                     {!! $description[\App::getLocale()] !!}
                                 </div>
                                    <?php $i++; ?>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
