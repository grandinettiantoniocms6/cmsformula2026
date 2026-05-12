<?php
$website = \App\Models\WebsiteSetting::first();
$titleBlocco = json_decode($item->title, true);
if($titleBlocco){
    if(!key_exists(\App::getLocale(), $titleBlocco)){
        $titleBlocco[\App::getLocale()] = "";
    }
}else{
    $titleBlocco[\App::getLocale()] = "";
}

$descriptionBlocco = json_decode($item->description, true);
if($descriptionBlocco){
    if(!key_exists(\App::getLocale(), $descriptionBlocco)){
        $descriptionBlocco[\App::getLocale()] = "";
    }
}else{
    $descriptionBlocco[\App::getLocale()] = "";
}
?>

<section class="pt-{{ $item->pt }} pb-{{ $item->pb }}" style="background-color: {{ $item->bgcolor }};" data-anime='{"translateX": [50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">

        @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
            <div class="row align-items-center mb-1">
                <div class="col-md-12 last-paragraph-no-margin">
                    <h3 class="fw-600 ls-minus-1px mb-20px" style="color: {{ $item->color_title }}; text-align: {{ $item->text_align }};">{{ $titleBlocco[\App::getLocale()] }}</h3>
                    <p class="w-95 sm-w-100">{!! $descriptionBlocco[\App::getLocale()] !!}</p>
                </div>
            </div>
        @endif

        <div class="row">
            <ul class="col-12 filter-content">
                <ul class="portfolio-modern portfolio-wrapper grid-loading grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-{{ $item->col }}col md-grid-2col sm-grid-2col xs-grid-1col gutter-large">
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


                                            <!-- start portfolio item -->
                                            <li class="gallery-box grid-item web branding transition-inner-all">
                                                @if(trim($foto) != "")
                                                    <a href="{{ $value->foto }}" data-group="lightbox-group-gallery">
                                                        <div class="portfolio-box">
                                                            <div class="portfolio-image border-radius-6px">
                                                                <img src="{{ $foto }}" alt="" />
                                                            </div>
                                                            <div class="portfolio-hover box-shadow-extra-large">
                                                                @if(trim($title[\App::getLocale()]) != "" || trim($description[\App::getLocale()]) != "")
                                                                <div class="bg-white d-flex align-items-center align-self-end text-start border-radius-4px ps-30px pe-30px pt-20px pb-20px lg-p-20px w-100">
                                                                    <div class="me-auto">
                                                                        @if(trim($title[\App::getLocale()]) != "")
                                                                            <div class="alt-font fw-600 text-dark-gray text-uppercase lh-initial">{{ $title[\App::getLocale()] }}</div>
                                                                        @endif

                                                                        @if(trim($description[\App::getLocale()]) != "")
                                                                                <div class="fs-12 text-medium-gray text-uppercase lh-24">{!! $description[\App::getLocale()] !!}</div>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            </li>




                                @endforeach
                            @endif
                        </ul>

            </div>

            <div class="w-100 d-flex mt-4 justify-content-center md-mt-30px">
                <ul class="pagination pagination-style-01 fs-13 fw-500 mb-0">
                    @if($item->is_pagination)
                        {{ $array->links() }}
                    @endif
                </ul>
            </div>

            </div>

        </div>
    </div>
</section>
