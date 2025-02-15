<?php
    $website = \App\Models\WebsiteSetting::first();
    $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>
<section class="block-store" id="block-store-{{ $item->id }}">
    <div class="{{ $item->fullwidth }}">
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

            <div class="store-filters">
                <button data-filter="*" class="btn btn-primary active" style="background-color: {{ $website->color_gen3 }}; border-color: {{ $website->color_gen3 }}">{{ @$labels['all'] }}</button>
                @if($categories)
                    @foreach($categories as $cat)
                        <button data-filter=".{{ \Str::slug($cat, '-') }}" class="btn btn-primary">{{ $cat }}</button>
                    @endforeach
                @endif
            </div>

            <div class="store-grid row row-cols-1 row-cols-sm-2 row-cols-md-{{ $item->col }}">

            @foreach($array as $value)

                    <style>
                        #block-store-{{ $item->id }} #item-{{ $value->id }} {
                            --store-block-title-color: {{ $value->txt_color }};
                            --store-block-btn.active: {{ $website->color_gen2 }};
                            --store-block-btn: {{ $website->btn_background }};
                            --store-block-card-bg: {{ $value->bgcolor }};
                            --store-block-icon-color: {{ $value->icon_color_phone }};
                            --store-block-iconw-color: {{ $value->icon_color_whatsapp }};
                        }
                    </style>
                <?php

                $title = json_decode($value->title, true);
                if($title === null){
                    $title = [];
                }

                $name = json_decode($value->name, true);
                if($name === null){
                    $name = [];
                }

                $name_company = json_decode($value->name_company, true);
                if($name_company === null){
                    $name_company = [];
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

                if(!key_exists(\App::getLocale(), $url_interno)){
                    $url_interno[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $url_esterno)){
                    $url_esterno[\App::getLocale()] = "";
                }

                ?>
                    <div class="grid-item {{ \Str::slug($category[\App::getLocale()], '-')  }}">
                        <div class="card mb-3" id="item-{{ $value->id }}">
                            <div class="card-body">
                                <h3 class="title">{{ $title[\App::getLocale()] }}</h3>
                                @if($name_company)
                                <h4 class="title">{{ $name_company[\App::getLocale()] }}</h4>
                                @endif
                                @if($location)
                                <p class="title">{{ $location[\App::getLocale()] }}</p>
                                @endif
                                @if($value->phone)
                                    <div class="phone">
                                        <a href="tel:{{ $value->phone }}" target="{{ $type_href_phone }}">
                                            <i class="icon {{ $value->icon_phone }} {{ $item->size_icon }}"></i><span>{{ $value->phone }}</span>
                                        </a>
                                    </div>
                                @endif
                                @if($value->whatsapp)
                                    <div class="whatsapp">
                                        <a href="https://wa.me/{{ $value->whatsapp }}" target="{{ $type_href_whatsapp }}"><i class="icon {{ $value->icon_whatsapp }} {{ $item->size_icon }}"></i><span>{{ $value->whatsapp }}</span></a>
                                    </div>
                                @endif
                                @if(trim($button[\App::getLocale()])!="")
                                    <a class="btn btn-primary" target="{{ $type_href }}" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
            @endforeach
            </div>
        @endif
    </div>
</section>
