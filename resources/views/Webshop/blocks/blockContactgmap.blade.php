@if($array)
    @foreach($array as $value)
        <?php

        // per i successivi non essendo multilingua li scrivo così
        $bg_box = $value->bg_box;
        $margin_top = $value->margin_top;
        $margin_bottom = $value->margin_bottom;
        $color_txt = $value->color_txt;
        $height_gmap = $value->height_gmap;
        $url = $value->url;
        $address1 = $value->address1;
        $address2 = $value->address2;
        $address3 = $value->address3;
        $phone1 = $value->phone1;
        $phone2 = $value->phone2;
        $phone3 = $value->phone3;
        $fax = $value->fax;
        $whatsapp = $value->whatsapp;
        $facebook = $value->facebook;
        $instagram = $value->instagram;
        $linkedin = $value->linkedin;
        $whatsapp = $value->whatsapp;
        $orari = $value->orari;
        $come_raggiungerci = $value->come_raggiungerci;
        $email1 = $value->email1;
        $email2 = $value->email2;
        $email3 = $value->email3;
        $pec = $value->pec;

        // questi 4 input sono multilingua e vanno scritti così
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

        $description2 = json_decode($value->description2, true);
        if($description2 === null){
            $description2 = [];
        }

        // solo per i 4 campi multilingua devo fare gli if qui
        if(!key_exists(\App::getLocale(), $subtitle)){
            $subtitle[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $title)){
            $title[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $description)){
            $description[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $description2)){
            $description2[\App::getLocale()] = "";
        }

        // serve per le thumb /
        $photo = $value->foto;
        $foto = "";

        // serve per le thumb
        if($photo){
            $basename = basename($photo);
            $temp = explode(".", $basename);

            $check = "thumb/blocks_contactgmails/$temp[0]-large.webp";
            if(file_exists($check)){
                $foto = url($check);
            }else{
                $foto = url($photo);
            }
        }

        ?>

        <style>
            #block-contact-map-{{ $value->block_id }} {
                --gmap-block-bg: {{ $value->bg_box }};
                --gmap-block-title-color: {{ $value->color_txt }};
                --gmap-block-text-color: {{ $value->color_txt }};
                min-height: {{ $height_gmap }};
            }
        </style>

        @include("Webshop.blocks.blockContactgmap.section_$item->style")

    @endforeach
@endif
