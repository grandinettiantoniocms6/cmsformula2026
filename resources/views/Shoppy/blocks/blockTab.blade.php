<section class="page-section-ptb elements-tabs">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @if($array)
                                @foreach($array as $value)
                                    <?php
                                    $title = json_decode($value->title, true);
                                    $description = json_decode($value->description, true);
                                    $url_interno = json_decode($value->url_interno, true);
                                    $url_esterno = json_decode($value->url, true);
                                    $button = json_decode($value->button, true);

                                    if(!key_exists(\App::getLocale(), $title)){
                                        $title[\App::getLocale()] = "";
                                    }

                                    if(!key_exists(\App::getLocale(), $description)){
                                        $description[\App::getLocale()] = "";
                                    }

                                    $url = "#";
                                    if(trim($url_interno[\App::getLocale()]) != ""){
                                        $url = "/{$url_interno[\App::getLocale()]}";
                                    }else{
                                        if(trim($url_esterno[\App::getLocale()]) != ""){
                                            $url = $url_esterno[\App::getLocale()];
                                        }
                                    }

                                    $active = "";
                                    if($value->is_active == 1){
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
                                @endforeach
                            @endif
                        </ul>

                    <div class="tab-content" id="myTabContent">
                        @if($array)
                            @foreach($array as $value)
                                <?php
                                $title = json_decode($value->title, true);
                                $description = json_decode($value->description, true);
                                $url_interno = json_decode($value->url_interno, true);
                                $url_esterno = json_decode($value->url, true);
                                $button = json_decode($value->button, true);

                                $url = "#";
                                if(trim($url_interno[\App::getLocale()]) != ""){
                                    $url = "/{$url_interno[\App::getLocale()]}";
                                }else{
                                    if(trim($url_esterno[\App::getLocale()]) != ""){
                                        $url = $url_esterno[\App::getLocale()];
                                    }
                                }
                                $active = "";
                                if($value->is_active == 1){
                                    $active = "active";
                                }
                                $show = "";
                                if($value->is_default == 1){
                                    $show = "show";
                                }

                                ?>
                                 <div class="tab-pane fade {{ $active }} {{ $show }}" id="tab-{{ $value->id }}" role="tabpanel">
                                     {!! $description[\App::getLocale()] !!}
                                 </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
