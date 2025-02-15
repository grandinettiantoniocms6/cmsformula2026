@if($array)
    @foreach($array as $value)
        <?php

        $title = json_decode($value->title, true);
        if($title === null){
            $title = [];
        }

        $color_title = $value->color_title;
        $sfondo = $value->sfondo;
        $height = $item->height;

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

        $url = "#";
        if(trim($url_interno[\App::getLocale()]) != ""){
            $url = "/{$url_interno[\App::getLocale()]}";
        }else{
            if(trim($url_esterno[\App::getLocale()]) != ""){
                $url = $url_esterno[\App::getLocale()];
            }
        }

            // serve per le thumb
            $photo = $value->sfondo;
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_heros/$temp[0]-large.webp";
                if(file_exists($check)){
                    $sfondo = url($check);
                }else{
                    $sfondo = url($photo);
                }
            }

        ?>

        @include("Creative.blocks.blockHero.section_$item->style")

    @endforeach
@endif

