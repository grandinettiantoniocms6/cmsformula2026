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
            <div class="col">
                <ul class="image-gallery-style-03 gallery-wrapper grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-{{ $item->col }}col md-grid-1col sm-grid-1col xs-grid-1col gutter-extra-large">
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


                                        <!-- start gallery item -->
                                        <li class="grid-item transition-inner-all">
                                            @if(trim($foto) != "")
                                                <div class="gallery-box overflow-hidden">
                                                    <a href="{{ $foto }}" data-group="lightbox-group-gallery-item-3" title="">
                                                        <div class="position-relative gallery-image bg-base-color">
                                                            <img src="{{ $foto }}" alt="" />
                                                            <div class="d-flex align-items-center justify-content-center position-absolute top-0px left-0px w-100 h-100 gallery-hover move-bottom-top">
                                                                <i class="feather icon-feather-search icon-very-medium text-white"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif

                                        </li>

                                        <!-- end gallery item -->


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



