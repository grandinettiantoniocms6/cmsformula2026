<section class="page-section-ptb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h4 class="mb-30">Gallery </h4>
                @if($array)

                    <div class="isotope columns-3 popup-gallery">
                    @foreach($array as $value)
                        <?php
                        $title = json_decode($value->title, true);
                        $category = json_decode($value->category, true);
                        $description = json_decode($value->description, true);
                        $url_interno = json_decode($value->url_interno, true);
                        $url_esterno = json_decode($value->url, true);
                        $button = json_decode($value->button, true);
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
                        ?>

                        <!-- CICLA -->
                            <div class="grid-item">
                                <div class="portfolio-item">
                                    @if(trim($value->foto) != "")
                                        <img src="{{ $value->foto }}" alt="">
                                    @endif
                                    <div class="portfolio-overlay">
                                        @if(trim($button[\App::getLocale()])!="")
                                            <h4 class="text-white">
                                                {{ $title[\App::getLocale()] }}
                                            </h4>
                                            <span class="text-white">
                                                    <a target="{{ $type_href }}" href="{{ $url }}"> {{ $description[\App::getLocale()] }} | {{ $button[\App::getLocale()] }} </a>
                                                </span>
                                        @endif
                                    </div>
                                    <a class="popup portfolio-img" href="{{ $value->foto }}"><i class="fa fa-arrows-alt"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
