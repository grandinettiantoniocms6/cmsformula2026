<?php
$website = \App\Models\WebsiteSetting::first();
?>
<section class="page-section-ptb">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                    @if($array)
                        <!-- filtri -->
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
                        //asort le mette in ordine ABC
                        rsort($categories);
                        ?>

                            <div class="isotope-filters">
                                <button data-filter="" style="background-color: {{ $website->btn_hover_background }}; color: {{ $website->btn_txt_color }}; border-color: {{ $website-> btn_hover_background }};" class="active">Tutte</button>
                                @if($categories)
                                    @foreach($categories as $cat)
                                        <button data-filter=".{{ \Str::slug($cat, '-') }}" style="background-color: {{ $website->btn_background }}!important; color: {{ $website->btn_txt_color }}!important; border-color: {{ $website-> btn_colorborder }}!important;">{{ $cat }}</button>
                                    @endforeach
                                @endif
                            </div>
                            <div class="isotope full-screen columns-{{ $item->col }}">

                                @foreach($array as $value)
                                    <?php
                                    $title = json_decode($value->title, true);
                                    if($title === null){
                                        $title = [];
                                    }

                                    $name = json_decode($value->name, true);
                                    if($name === null){
                                        $name = [];
                                    }

                                    $location = json_decode($value->location, true);
                                    if($location === null){
                                        $location = [];
                                    }

                                    $category = json_decode($value->category, true);
                                    if($category === null){
                                        $category = [];
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

                                    if(!key_exists(\App::getLocale(), $title)){
                                        $title[\App::getLocale()] = "";
                                    }

                                    if(!key_exists(\App::getLocale(), $name)){
                                        $name[\App::getLocale()] = "";
                                    }

                                    if(!key_exists(\App::getLocale(), $location)){
                                        $location[\App::getLocale()] = "";
                                    }

                                    $type_href_phone = $value->type_href_phone;
                                    $type_href_whatsapp = $value->type_href_whatsapp;
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

                                    if(!key_exists(\App::getLocale(), $category)){
                                            $category[\App::getLocale()] = "";
                                    }

                                    if(!key_exists(\App::getLocale(), $button)){
                                        $button[\App::getLocale()] = "";
                                    }

                                    ?>


                                <!-- CICLA -->
                                    <div class="grid-item {{ \Str::slug($category[\App::getLocale()], '-')  }}">
                                        <div class="team team-hover" style="background-color:{{ $value->bgcolor }}!important; height: 350px;">

                                            <div class="team-description">
                                                <div>
                                                    <h5 style="color: {{ $value->txt_color }}";>{{ $title[\App::getLocale()] }}</h5>
                                                    <span>{{ $name[\App::getLocale()] }}</span>
                                                    <p>{{ $location[\App::getLocale()] }}</p>
                                                    @if($value->phone)
                                                        <p><h5><a href="tel:{{ $value->phone }}" target="{{ $type_href_phone }}">{{ $value->phone }} <br><br>

                                                                <i class="{{ $value->icon_phone }} {{ $item->size_icon }}" style="color: {{ $value->icon_color_phone }}!important;"></i>
                                                               </a></h5> </p>
                                                    @endif
                                                    @if($value->whatsapp)
                                                        <p><h5><a href="https://wa.me/{{ $value->whatsapp }}" target="{{ $type_href_whatsapp }}">
                                                                <i class="{{ $value->icon_whatsapp }} {{ $item->size_icon }}" style="color: {{ $value->icon_color_whatsapp }}!important;"></i>
                                                            </a></h5> </p>
                                                    @endif
                                                    @if(trim($button[\App::getLocale()])!="")
                                                        <h5><a class="button button-border" style="background-color: {{ $website->btn_hover_background }}; color: {{ $website->btn_txt_color }}; border-color: {{ $website-> btn_hover_background }};" target="{{ $type_href }}" href="{{ $url }}"> {{ $button[\App::getLocale()] }}</a></h5>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- / CICLA -->

                                @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
