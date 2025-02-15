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

@if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
<section class="ps-0 pt-5 pb-5">
    <div class="{{ $item->fullwidth }}">

            <div class="row align-items-center mb-6">
                <div class="col-md-9 last-paragraph-no-margin">
                    <h3 class="text-dark-gray fw-600 ls-minus-1px mb-20px">{{ $titleBlocco[\App::getLocale()] }}</h3>
                    <p class="w-95 sm-w-100">{{ $descriptionBlocco[\App::getLocale()] }}</p>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <ul class="image-gallery-style-04 gallery-wrapper grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-4col md-grid-3col sm-grid-1col xs-grid-1col">
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

                            <li class="grid-item transition-inner-all" data-anime='{"opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                <div class="gallery-box">
                                    @if(trim($foto) != "")
                                    <a href="{{ $foto }}" data-group="lightbox-group-gallery-item-4" title="{{ $title[\App::getLocale()] }}">
                                        <div class="position-relative gallery-image bg-dark-gray" style="background:#e3003b">
                                            <img src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" />
                                            <div class="d-flex align-items-center justify-content-center position-absolute top-0px left-0px w-100 h-100 gallery-hover move-left-right">
                                                <div class="d-flex align-items-center justify-content-center w-70px h-70px rounded-circle border border-2 border-color-transparent-white-very-light">
                                                    <i class="feather icon-feather-search text-white icon-extra-medium"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    @endif
                                </div>

                                @if(trim($title[\App::getLocale()]) != "" || trim($description[\App::getLocale()]) != "")
                                    @if(trim($title[\App::getLocale()]) != "")
                                        <span style="font-size: 18px; font-weight: bold;">{{ $title[\App::getLocale()] }}</span><br>
                                    @endif

                                    @if(trim($description[\App::getLocale()]) != "")
                                        <span style="font-size: 14px;"> {!! $description[\App::getLocale()] !!}
                                    @endif
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

</section>



