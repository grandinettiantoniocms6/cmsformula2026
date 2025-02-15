<?php
    $website = \App\Models\WebsiteSetting::first();
?>
<div class="portfolio-gallery-four pt-150 lg-pt-100 lg-pb-80">
    <div class="{{ $item->fullwidth }}">

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
                            asort($categories);
                        ?>

                        <ul class="style-none text-center isotop-menu-wrapper control-nav-five pb-75 lg-pb-40">
                            <li class="is-checked" data-filter="*">TUTTI</li>
                            @if($categories)
                                @foreach($categories as $cat)
                                    <li data-filter=".{{ \Str::slug($cat, '-') }}">{{ $cat }}</li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="wrapper">
                            <div id="isotop-gallery-wrapper" class="grid-{{ $item->col }}column">
                                <div class="grid-sizer"></div>

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
                                        ?>


                                                <!-- CICLA -->
                                                <div class="isotop-item {{ \Str::slug($category[\App::getLocale()], '-')  }}">
                                                    <div class="gallery-item mb-40 lg-mb-30">
                                                        <div class="img-holder">
                                                            @if(trim($value->foto) != "")
                                                                <img src="{{ $value->foto }}" alt="" class="img-meta w-100 tran6s">
                                                            @endif
                                                                <!--a class="fancybox tran3s overlay-icon zoom-icon" data-fancybox="" title="Click for large view" href="{{ $value->foto }}" tabindex="0"><i class="bi bi-plus"></i></a-->
                                                                <a class="tran3s overlay-icon zoom-icon" href="{{ $url }}" target="{{ $type_href }}"><i class="bi bi-arrow-up-right"></i></a>
                                                                <div class="caption tran3s d-flex justify-content-end flex-column">
                                                                    <h6><a href="{{ $url }}" target="{{ $type_href }}" class="pj-title">{{ $title[\App::getLocale()] }}</a></h6>
                                                                    <span class="tag">{{ $description[\App::getLocale()] }}</span>
                                                                </div> <!-- /.caption -->
                                                        </div>
                                                    </div> <!-- /.gallery-item -->
                                                </div> <!-- /.isotop-item -->
                                                <!-- / CICLA -->



                                    @endforeach
                            </div>
                @endif


        </div>
</div>
