@include("Webshop.blocks.blockReference.section_$item->style")







<!-- vecchio codice
-------------------------------------------------------------------------------------------------------------------------

<?php
    $website = \App\Models\WebsiteSetting::first();
?>
<section class="block-referenze style-{{ $item->style }}">
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

            <div class="referenze-filters">
                <button data-filter="*" class="btn btn-primary active">Tutti</button>
                @if($categories)
                    @foreach($categories as $cat)
                        <button data-filter=".{{ \Str::slug($cat, '-') }}" class="btn btn-primary">{{ $cat }}</button>
                    @endforeach
                @endif
            </div>

            <div class="referenze-grid row row-cols-1 row-cols-sm-2 row-cols-md-{{ $item->col }}">

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
                    <div class="grid-item {{ \Str::slug($category[\App::getLocale()], '-')  }}">
                        <div class="card mb-4">
                            @if(trim($foto) != "")
                                <a target="{{ $type_href }}" href="{{ $url }}">
                                    <img class="img-fluid" src="{{ $foto }}" alt="{{ $description[\App::getLocale()] }}" loading="lazy">
                                </a>
                            @endif
                            <div class="card-overlay" style="background-color:{{ $website->color_gen1 }}!important;">
                                @if(trim($button[\App::getLocale()])!="")
                                    <h4 class="title">{{ $title[\App::getLocale()] }}</h4>
                                    <a class="text" target="{{ $type_href }}" href="{{ $url }}">{{ $description[\App::getLocale()] }} | {{ $button[\App::getLocale()] }}</a>
                                @endif
                            </div>
                            <a class="glightbox" data-src="{{ $value->foto }}" href="{{ $value->foto }}"><i class="bi bi-search"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

    --------------------------------------------- -->
