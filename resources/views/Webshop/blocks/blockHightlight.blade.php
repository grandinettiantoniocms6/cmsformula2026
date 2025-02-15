<section class="block-highlight style-{{ $item->style }}">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
        @if($array)
            <div id="evidenza-block-{{ $item->id }}" class="owl-carousel owl-theme owl-block-carousel"
                 data-toggle='owlcarousel'
                 data-margin='[0,0,0,15,15,15,15]'
                 data-autowidth='[false,false,false,false,false,false,false]'
                 data-autoplay='[true,3000]'
                 data-responsive='[1,1,1,2,2,2,2]'
                 data-dots='[true,true,true,true,true,true,true]'
                 data-nav='[false,false,false,false,false,false,false]'
                 data-loop='true'
            >
                @foreach($array as $value)
                    <?php
                    $title = json_decode($value->title, true);
                    if($title === null){
                        $title = [];
                    }

                    $abstract = json_decode($value->abstract, true);
                    if($abstract === null){
                        $abstract = [];
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

                    if(!key_exists(\App::getLocale(), $url_interno)){
                        $url = "";
                    }else{
                        if(trim($url_interno[\App::getLocale()]) != ""){
                            $url = "/{$url_interno[\App::getLocale()]}";
                        }else{
                            if(trim($url_esterno[\App::getLocale()]) != ""){
                                $url = $url_esterno[\App::getLocale()];
                            }
                        }
                    }

                    if(!key_exists(\App::getLocale(), $abstract)){
                        $abstract[\App::getLocale()] = "";
                    }

                    if(!key_exists(\App::getLocale(), $title)){
                        $title[\App::getLocale()] = "";
                    }

                    if(!key_exists(\App::getLocale(), $button)){
                        $button[\App::getLocale()] = "";
                    }

                    if(!key_exists(\App::getLocale(), $description)){
                        $description[\App::getLocale()] = "";
                    }

                        // serve per le thumb
                        $photo = $value->foto;

                        // serve per le thumb
                        if($photo){
                            $basename = basename($photo);
                            $temp = explode(".", $basename);

                            $check = "thumb/blocks_hightlights/$temp[0]-large.webp";
                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($photo);
                            }
                        }

                        ?>

                    @include("Webshop.blocks.blockHightlight.section_$item->style")

                @endforeach
            </div>
        @endif
        </div>
    </div>
</section>
