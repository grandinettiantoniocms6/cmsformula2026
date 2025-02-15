<?php $website = \App\Models\WebsiteSetting::first(); ?>
<section class="block-staff">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            @if($array)
                @foreach($array as $value)
                <?php
                $name_surname = json_decode($value->name_surname, true);
                if($name_surname === null){
                    $name_surname = [];
                }

                $role = json_decode($value->role, true);
                if($role === null){
                    $role = [];
                }

                $phone = json_decode($value->phone, true);
                if($phone === null){
                    $phone = [];
                }

                $email = json_decode($value->email, true);
                if($email === null){
                    $email = [];
                }

                $col = $item->col;

                $social_1 = json_decode($value->url_1, true);
                if($social_1 === null){
                    $social_1 = [];
                }

                $social_2 = json_decode($value->url_2, true);
                if($social_2 === null){
                    $social_2 = [];
                }

                $social_3 = json_decode($value->url_3, true);
                if($social_3 === null){
                    $social_3 = [];
                }

                $social_4 = json_decode($value->url_4, true);
                if($social_4 === null){
                    $social_4 = [];
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
                $type_href_1 = $value->type_href_1;
                $type_href_2 = $value->type_href_2;
                $type_href_3 = $value->type_href_3;
                $type_href_4 = $value->type_href_4;

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

                if(!key_exists(\App::getLocale(), $name_surname)){
                    $name_surname[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $social_1)){
                    $social_1[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $url_interno)){
                    $url_interno[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $url_esterno)){
                    $url_esterno[\App::getLocale()] = "";
                }

                $url_1 = "#";

                if(key_exists(\App::getLocale(), $social_1)){
                    if(trim($social_1[\App::getLocale()]) != ""){
                        $url_1 = $social_1[\App::getLocale()];
                    }
                }

                if(!key_exists(\App::getLocale(), $social_2)){
                    $social_2[\App::getLocale()] = "";
                }

                $url_2 = "#";

                if(key_exists(\App::getLocale(), $social_2)){
                    if(trim($social_2[\App::getLocale()]) != ""){
                        $url_2 = $social_2[\App::getLocale()];
                    }
                }

                if(!key_exists(\App::getLocale(), $social_3)){
                    $social_3[\App::getLocale()] = "";
                }

                $url_3 = "#";

                if(key_exists(\App::getLocale(), $social_3)){
                    if(trim($social_3[\App::getLocale()]) != ""){
                        $url_3 = $social_3[\App::getLocale()];
                    }
                }

                if(!key_exists(\App::getLocale(), $social_4)){
                    $social_4[\App::getLocale()] = "";
                }

                $url_4 = "#";

                if(key_exists(\App::getLocale(), $social_4)){
                    if(trim($social_4[\App::getLocale()]) != ""){
                        $url_4 = $social_4[\App::getLocale()];
                    }
                }

                if(!key_exists(\App::getLocale(), $button)){
                    $button[\App::getLocale()] = "";
                }

                // serve per le thumb
                $photo = $value->foto;

                // serve per le thumb
                if($photo){
                    $basename = basename($photo);
                    $temp = explode(".", $basename);

                    $check = "thumb/blocks_staffs/$temp[0]-large.webp";
                    if(file_exists($check)){
                        $foto = url($check);
                    }else{
                        $foto = url($photo);
                    }
                }

                ?>
                    @include("Webshop.blocks.blockStaff.section_$item->style")

                @endforeach
            @endif
        </div>
    </div>
</section>
