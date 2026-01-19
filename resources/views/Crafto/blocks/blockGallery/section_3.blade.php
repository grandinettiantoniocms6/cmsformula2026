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

<section class="pt-{{ $item->pt }} pb-{{ $item->pb }}" style="background-color: {{ $item->bgcolor }};" data-anime='{"translateY": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">

        @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
            <div class="row align-items-center mb-1">
                <div class="col-12 position-relative page-title-double-large">
                    <div class="d-flex flex-column justify-content-center extra-very-small-screen">
                        <h1 class="alt-font ls-minus-1px fw-700 mb-20px" style="color: {{ $item->color_title }};text-align: {{ $item->text_align }}; ">{{ $titleBlocco[\App::getLocale()] }}</h1>
                        <h2 class="d-inline-block fw-400 ls-0px w-80 xs-w-100 mx-auto">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <ul class="col-12 filter-content">
                <ul class="portfolio-attractive portfolio-wrapper grid-loading grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-{{ $item->col }}col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center">
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

                                <li class="gallery-box grid-item selected transition-inner-all atropos" data-atropos data-atropos-perspective="1450">
                                    @if(trim($foto) != "")
                                        <div class="position-relative">
                                            <a href="{{ $foto }}" class="portfolio-link" data-group="lightbox-group-gallery"></a>
                                            <div class="atropos-scale">
                                                <div class="atropos-rotate">
                                                    <div class="atropos-inner" data-atropos-offset="3">
                                                        <div class="portfolio-box bg-gradient-top-very-light-gray">
                                                            <div class="portfolio-image">
                                                                <img src="{{ $foto }}" alt="" />
                                                            </div>
                                                            <div class="portfolio-hover justify-content-end align-items-center d-flex flex-column pt-40px pb-40px sm-pt-30px sm-pb-30px">

                                                                @if(trim($title[\App::getLocale()]) != "" || trim($description[\App::getLocale()]) != "")

                                                                    <span class="icon-box z-index-1 mb-auto ms-auto me-30px"><i class="bi bi-arrow-up-right icon-very-medium text-white" aria-hidden="true"></i></span>
                                                                    @if(trim($title[\App::getLocale()]) != "")
                                                                        <div class="text-white fs-19 move-top-bottom-self"><span>{{ $title[\App::getLocale()] }}</span></div>
                                                                    @endif
                                                                    @if(trim($description[\App::getLocale()]) != "")
                                                                        <div class="fs-15 lh-22 text-white opacity-6 move-bottom-top-self"><span>{!! $description[\App::getLocale()] !!}</span></div>
                                                                    @endif

                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
