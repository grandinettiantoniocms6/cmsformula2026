<?php $website = \App\Models\WebsiteSetting::first(); ?>

<section class="pt-0 mt-50px block-referenze">
    <div class="{{ $item->fullwidth }}">
        <div class="col-12 filter-content">
            <ul class="portfolio-modern portfolio-wrapper grid-loading grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-{{ $item->col }}col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <li class="grid-sizer"></li>
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
                        if(trim($url_interno[\App::getLocale()]) != ""){
                            $url = "/{$url_interno[\App::getLocale()]}";
                        }else{
                            if(trim($url_esterno[\App::getLocale()]) != ""){
                                $url = $url_esterno[\App::getLocale()];
                            }
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



                        <li class="grid-item transition-inner-all">
                            @if(trim($button[\App::getLocale()])!="")
                                <a href="{{ $url }}" target="{{ $type_href }}" >
                                    <div class="portfolio-box">
                                        @if(trim($foto) != "")
                                            <div class="portfolio-image border-radius-4px">
                                                <img src="{{ $foto }}" alt="{{ $description[\App::getLocale()] }}" loading="lazy" />
                                            </div>
                                        @endif
                                        <div class="portfolio-hover box-shadow-extra-large">
                                            <div class="bg-white d-flex align-items-center align-self-end text-start border-radius-4px ps-30px pe-30px pt-20px pb-20px lg-p-20px w-100">
                                                <div class="me-auto">
                                                    <div class="fs-12 text-medium-gray text-uppercase lh-24">{{ $title[\App::getLocale()] }}</div>
                                                    <div class="alt-font fw-600 text-dark-gray text-uppercase lh-initial">{{ $description[\App::getLocale()] }}</div>
                                                </div>
                                                <div class="ms-auto"><i class="feather icon-feather-plus icon-extra-medium text-dark-gray lh-36"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </li>


                @endforeach
        </div>
        @endif
    </div>
</section>
