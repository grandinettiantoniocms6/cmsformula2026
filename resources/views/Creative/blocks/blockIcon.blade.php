<div class="vcamp-feature-section-three mt-200 lg-mt-120">
    <div class="{{ $item->fullwidth }}">
                <div class="row">

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

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $description)){
                                $description[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $button)){
                                $button[\App::getLocale()] = "";
                            }

                            ?>

                            @include("Creative.blocks.blockIcon.section_$item->style")

                        @endforeach
                    @endif

                </div>
    </div>
</div>
