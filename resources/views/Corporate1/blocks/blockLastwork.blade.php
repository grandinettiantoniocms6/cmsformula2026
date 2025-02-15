@if($array)
    <?php
    $website = \App\Models\WebsiteSetting::first();
    ?>
    @foreach($array as $value)
     <?php

         $color_subtitle = $value->color_subtitle;
         $color_title = $value->color_title;
         $bg_color = $value->bg_color;

         $subtitle = json_decode($value->subtitle, true);
         if($subtitle === null){
             $subtitle = [];
         }

         $title = json_decode($value->title, true);
         if($title === null){
             $title = [];
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

         $url = $value->url;

         if(!key_exists(\App::getLocale(), $subtitle)){
             $subtitle[\App::getLocale()] = "";
         }

         if(!key_exists(\App::getLocale(), $title)){
             $title[\App::getLocale()] = "";
         }

         if(!key_exists(\App::getLocale(), $description)){
             $description[\App::getLocale()] = "";
         }

         $workname_1 = json_decode($value->workname_1, true);
         if($workname_1 === null){
             $workname_1 = [];
         }

         $workname_2 = json_decode($value->workname_2, true);
         if($workname_2 === null){
            $workname_2 = [];
         }

         $workname_3 = json_decode($value->workname_3, true);
         if($workname_3 === null){
             $workname_3 = [];
         }

         $workname_4 = json_decode($value->workname_4, true);
         if($workname_4 === null){
             $workname_4 = [];
         }

         $workname_5 = json_decode($value->workname_5, true);
         if($workname_5 === null){
             $workname_5 = [];
         }

         $workname_6 = json_decode($value->workname_6, true);
         if($workname_6 === null){
             $workname_6 = [];
         }

         $worktype_1 = json_decode($value->worktype_1, true);
         if($worktype_1 === null){
             $worktype_1 = [];
         }

         $worktype_2 = json_decode($value->worktype_2, true);
         if($worktype_2 === null){
             $worktype_2 = [];
         }

         $worktype_3 = json_decode($value->worktype_3, true);
         if($worktype_3 === null){
             $worktype_3 = [];
         }

         $worktype_4 = json_decode($value->worktype_4, true);
         if($worktype_4 === null){
             $worktype_4 = [];
         }

         $worktype_5 = json_decode($value->worktype_5, true);
         if($worktype_5 === null){
             $worktype_5 = [];
         }

         $worktype_6 = json_decode($value->worktype_6, true);
         if($worktype_6 === null){
             $worktype_6 = [];
         }

         $url_interno_1 = json_decode($value->url_interno_1, true);
         if($url_interno_1 === null){
             $url_interno_1 = [];
         }

         $url_interno_2 = json_decode($value->url_interno_2, true);
         if($url_interno_2 === null){
             $url_interno_2 = [];
         }

         $url_interno_3 = json_decode($value->url_interno_3, true);
         if($url_interno_3 === null){
             $url_interno_3 = [];
         }

         $url_interno_4 = json_decode($value->url_interno_4, true);
         if($url_interno_4 === null){
             $url_interno_4 = [];
         }

         $url_interno_5 = json_decode($value->url_interno_5, true);
         if($url_interno_5 === null){
             $url_interno_5 = [];
         }

         $url_interno_6 = json_decode($value->url_interno_6, true);
         if($url_interno_6 === null){
             $url_interno_6 = [];
         }

         $url_esterno_1 = json_decode($value->url_1, true);
         if($url_esterno_1 === null){
             $url_esterno_1 = [];
         }

         $url_esterno_2 = json_decode($value->url_2, true);
         if($url_esterno_2 === null){
             $url_esterno_2 = [];
         }

         $url_esterno_3 = json_decode($value->url_3, true);
         if($url_esterno_3 === null){
             $url_esterno_3 = [];
         }

         $url_esterno_4 = json_decode($value->url_4, true);
         if($url_esterno_4 === null){
             $url_esterno_4 = [];
         }

         $url_esterno_5 = json_decode($value->url_5, true);
         if($url_esterno_5 === null){
             $url_esterno_5 = [];
         }

         $url_esterno_6 = json_decode($value->url_6, true);
         if($url_esterno_6 === null){
             $url_esterno_6 = [];
         }

         $button_1 = json_decode($value->button_1, true);
         if($button_1 === null){
             $button_1 = [];
         }

         $button_2 = json_decode($value->button_2, true);
         if($button_2 === null){
             $button_2 = [];
         }

         $button_3 = json_decode($value->button_3, true);
         if($button_3 === null){
             $button_3 = [];
         }

         $button_4 = json_decode($value->button_4, true);
         if($button_4 === null){
             $button_4 = [];
         }

         $button_5 = json_decode($value->button_5, true);
         if($button_5 === null){
             $button_5 = [];
         }

         $button_6 = json_decode($value->button_6, true);
         if($button_6 === null){
             $button_6 = [];
         }

         $type_href_1 = $value->type_href_1;
         $type_href_2 = $value->type_href_2;
         $type_href_3 = $value->type_href_3;
         $type_href_4 = $value->type_href_4;
         $type_href_5 = $value->type_href_5;
         $type_href_6 = $value->type_href_6;


        $url_1 = "#";
         if(trim($url_interno_1[\App::getLocale()]) != ""){
             $url_1 = "/{$url_interno_1[\App::getLocale()]}";
         }else{
             if(trim($url_esterno_1[\App::getLocale()]) != ""){
                 $url_1 = $url_esterno_1[\App::getLocale()];
             }
         }

        $url_1 = $value->url_1;

         $url_2 = "#";
         if(trim($url_interno_2[\App::getLocale()]) != ""){
             $url_2 = "/{$url_interno_2[\App::getLocale()]}";
         }else{
             if(trim($url_esterno_2[\App::getLocale()]) != ""){
                 $url_2 = $url_esterno_2[\App::getLocale()];
             }
         }

         $url_2 = $value->url_2;

         $url_3 = "#";
         if(trim($url_interno_1[\App::getLocale()]) != ""){
             $url_3 = "/{$url_interno_3[\App::getLocale()]}";
         }else{
             if(trim($url_esterno_3[\App::getLocale()]) != ""){
                 $url_3 = $url_esterno_3[\App::getLocale()];
             }
         }

         $url_3 = $value->url_3;

         $url_4 = "#";
         if(trim($url_interno_4[\App::getLocale()]) != ""){
             $url_4 = "/{$url_interno_4[\App::getLocale()]}";
         }else{
             if(trim($url_esterno_4[\App::getLocale()]) != ""){
                 $url_4 = $url_esterno_4[\App::getLocale()];
             }
         }

         $url_4 = $value->url_4;

         $url_5 = "#";
         if(trim($url_interno_5[\App::getLocale()]) != ""){
             $url_5 = "/{$url_interno_5[\App::getLocale()]}";
         }else{
             if(trim($url_esterno_5[\App::getLocale()]) != ""){
                 $url_5 = $url_esterno_5[\App::getLocale()];
             }
         }

         $url_5 = $value->url_5;

         $url_6 = "#";
         if(trim($url_interno_6[\App::getLocale()]) != ""){
             $url_6 = "/{$url_interno_6[\App::getLocale()]}";
         }else{
             if(trim($url_esterno_6[\App::getLocale()]) != ""){
                 $url_6 = $url_esterno_6[\App::getLocale()];
             }
         }

         $url_6 = $value->url_6;

         ?>

         <?php

             // serve per le thumb
             $foto1 = "";
             $photo = $value->foto_1;
             if($photo){
                 $basename = basename($photo);
                 $temp = explode(".", $basename);

                 $check = "thumb/blocks_lastworks/$temp[0]-large.webp";
                 if(file_exists($check)){
                     $foto1 = url($check);
                 }else{
                     $foto1 = url($photo);
                 }
             }
            // fine thumb

            // serve per le thumb
            $foto2 = "";
            $photo = $value->foto_2;
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_lastworks/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto2 = url($check);
                }else{
                    $foto2 = url($photo);
                }
            }
            // fine thumb

            // serve per le thumb
            $foto3 = "";
            $photo = $value->foto_3;
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_lastworks/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto3 = url($check);
                }else{
                    $foto3 = url($photo);
                }
            }
            // fine thumb

            // serve per le thumb
            $foto4 = "";
            $photo = $value->foto_4;
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_lastworks/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto4 = url($check);
                }else{
                    $foto4 = url($photo);
                }
            }
            // fine thumb

            // serve per le thumb
            $foto5 = "";
            $photo = $value->foto_5;
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_lastworks/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto5 = url($check);
                }else{
                    $foto5 = url($photo);
                }
            }
            // fine thumb

            // serve per le thumb
            $foto6 = "";
            $photo = $value->foto_6;
            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_lastworks/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto6 = url($check);
                }else{
                    $foto6 = url($photo);
                }
            }
            // fine thumb


         ?>

        @include("Crafto.blocks.blockLastwork.section_$item->style")

    @endforeach
@endif




