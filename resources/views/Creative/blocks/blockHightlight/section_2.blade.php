<div class="vcamp-text-block-one pt-180 md-pt-130">
    <div class="container">
        <div class="pb-75 md-pb-50">
            <div class="row">
                <div class="col-12 m-auto">
                    <div class="text-wrapper text-center ps-0">
                        <div class="title-style-one">
                            <h3 class="title">{{ $item->name }} </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="portfolio-gallery-eight border-top pt-130 pb-150 lg-pt-80 lg-pb-80">
    <div class="{{ $item->fullwidth }}">
        <div class="slider-wrapper position-relative">
            <ul class="gallery-slider-arrow1 style-none d-flex justify-content-between">
                <li class="prev_btn1 ripple-btn slick-arrow" style=""><i class="bi bi-arrow-left"></i></li>
                <li class="next_btn1 ripple-btn slick-arrow" style=""><i class="bi bi-arrow-right"></i></li>
            </ul>

            <div class="portfolio-slider-two hvr-overlay-right galley-item-wrapper gap15">
                @if($array)
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
                        ?>

                            <div class="item">
                                <div class="gallery-item">
                                    <div class="img-holder">
                                        <img src="{{ $value->foto }}" alt="Images Carousel" class="img-meta w-100 tran5s">
                                        <div class="caption d-flex justify-content-end align-items-center flex-column">
                                            <div class="icon-group d-flex align-items-center justify-content-center">
                                                <a href="{{ $url }}" target="{{ $type_href }}" title="Go!" class="arrow tran3s me-2"><i class="bi bi-arrow-up-right"></i></a>
                                                <a class="fancybox tran3s ms-2" data-fancybox="" title="Zoom" href="{{ $value->foto }}" tabindex="0"><i class="bi bi-plus"></i></a>
                                            </div> <!-- /.icon-group -->
                                            <h6>
                                                @if(trim($button[\App::getLocale()])!="")
                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="pj-title">{{ $button[\App::getLocale()] }}</a>
                                                @else
                                                    <a href="{{ $url }}" target="{{ $type_href }}" class="pj-title">{{ $title[\App::getLocale()] }}</a>
                                                @endif
                                            </h6>
                                            <span class="tag">{{ $abstract[\App::getLocale()] }}</span>
                                        </div> <!-- /.caption -->
                                    </div>
                                </div> <!-- /.gallery-item -->
                            </div> <!-- /.item -->


                    @endforeach
            @endif
            </div>
        </div>
    </div>
</div>




