<?php
$website = \App\Models\WebsiteSetting::first();

/* Aggiunto titolo blocco multilingua - da riga 6 a 22 */

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

<!-- start Title section -->
@if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
<section>
    <div class="{{ $item->fullwidth }}">

        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-xl-6 col-lg-8 text-center position-relative page-title-double-large">
                <div class="d-flex flex-column justify-content-center extra-very-small-screen">
                    <h1 class="text-dark-gray alt-font ls-minus-1px fw-700 mb-20px">{{ $titleBlocco[\App::getLocale()] }}</h1>
                    <h2 class="d-inline-block fw-400 ls-0px w-80 xs-w-100 mx-auto">{{ $descriptionBlocco[\App::getLocale()] }}</h2>
                </div>
            </div>
        </div>

    </div>
</section>
@endif

<!-- start section start -->
<section class="pt-5 pb-5">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-12 filter-content">
                <ul class="portfolio-simple portfolio-wrapper grid-loading grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-large text-center">
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
                                            <li class="grid-item transition-inner-all" data-anime='{"scale": [0.9, 1], "translateY": [50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                                <div class="portfolio-box">
                                                    <div class="portfolio-image bg-medium-gray border-radius-4px">
                                                        @if(trim($foto) != "")
                                                        <img src="{{ $foto }}" alt="" />
                                                            <div class="portfolio-hover d-flex justify-content-center flex-column p-35px">
                                                            <div class="portfolio-icon d-flex flex-row justify-content-center align-items-center">
                                                                <a href="{{ $foto }}" data-group="portfolio-items" title="{!! $description[\App::getLocale()] !!}" class="d-flex flex-column justify-content-center text-dark-gray text-dark-gray-hover rounded-circle bg-white w-55px h-55px rounded-circle box-shadow-large move-bottom-top">
                                                                    <i class="feather icon-feather-search fw-600" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if(trim($title[\App::getLocale()]) != "" || trim($description[\App::getLocale()]) != "")
                                                    <div class="portfolio-caption pt-30px pb-30px sm-pt-20px sm-pb-20px">
                                                        @if(trim($title[\App::getLocale()]) != "")
                                                            <span style="font-size: 18px; font-weight: bold;">{{ $title[\App::getLocale()] }}</span>
                                                        @endif
                                                        @if(trim($description[\App::getLocale()]) != "")
                                                        <span class="d-inline-block align-middle w-10px separator-line-1px bg-light-gray ms-10px me-10px"></span>
                                                        <div class="d-inline-block">{!! $description[\App::getLocale()] !!}</div>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            </li>
                                            <!-- end portfolio item -->

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
</section>
<!-- end section -->



