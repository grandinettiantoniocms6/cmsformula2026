<?php $website = \App\Models\WebsiteSetting::first(); ?>

<section class="block-gallery wow animate__fadeInUp" data-wow-duration=".3s">
    <div class="{{ $item->fullwidth }}">
        <!--<h3 class="section-title">{{ $item->name }}</h3>-->
        <div class="gallery-grid row row-cols-2 row-cols-sm-{{ $item->col }}">
            @if($array)
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

                    if($title){
                        if(!key_exists(\App::getLocale(), $title)){
                            $title[\App::getLocale()] = "";
                        }
                    }else{
                        $title[\App::getLocale()] = "";
                    }

                    if($description){
                        if(!key_exists(\App::getLocale(), $description)){
                            $description[\App::getLocale()] = "";
                        }
                    }else{
                        $description[\App::getLocale()] = "";
                    }

                    // serve per le thumb -- se non voglio usarlo per lo zoom in caso di img vert metto {{ $value->foto }} su href di riga 58
                    if($value->foto){
                        $basename = basename($value->foto);
                        $temp = explode(".", $basename);

                        if(key_exists(1,$temp)){
                            $check = "thumb/blocks_gallerys/$temp[0]-large.webp";
                        }else{
                            $check = "thumb/blocks_gallerys/$temp[0]-large";
                        }

                        if(file_exists($check)){
                            $foto = url($check);
                        }else{
                            $foto = url($value->foto);
                        }
                    }

                    ?>

                    @include("Webshop.blocks.blockGallery.section_1")

                @endforeach
            @endif
        </div>
    </div>

    <div class="row-pagination mt-5">
        @if($item->is_pagination)
            {{ $array->links() }}
        @endif
    </div>
</section>
