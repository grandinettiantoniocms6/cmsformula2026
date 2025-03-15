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

<section class="pt-5 pb-5">
    <div class="{{ $item->fullwidth }}">

        @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
            <div class="row align-items-center mb-6">
                <div class="col-md-9 last-paragraph-no-margin">
                    <h3 class="text-dark-gray fw-600 ls-minus-1px mb-20px">{{ $titleBlocco[\App::getLocale()] }}</h3>
                    <p class="w-95 sm-w-100">{{ $descriptionBlocco[\App::getLocale()] }}</p>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <ul class="image-gallery-style-02 gallery-wrapper grid grid-{{ $item->col }}col xxl-grid-{{ $item->col }}col xl-grid-{{ $item->col }}col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-large">
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


                                <li class="grid-item transition-inner-all atropos gallery-box transition-inner-all jg-entry jg-entry-visible" data-atropos data-atropos-perspective="1150" data-anime='{"scale": [0.9, 1], "translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                        <div class="atropos-scale">
                                            <div class="atropos-rotate">
                                                <div class="atropos-inner" data-atropos-offset="3">
                                                    <div class="gallery-box">
                                                        @if(trim($foto) != "")
                                                        <a href="{{ $foto }}" data-group="lightbox-group-gallery-item-6" title="{{ $title[\App::getLocale()] }}">
                                                            <div class="position-relative gallery-image bg-slate-blue">
                                                                <img src="{{ $foto }}" alt="" />

                                                                <div class="d-flex align-items-center justify-content-center position-absolute top-0px left-0px w-100 h-100 gallery-hover move-bottom-top">
                                                                    <i class="bi bi-camera icon-medium text-white"></i>

                                                                </div>

                                                            </div>
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @if(trim($title[\App::getLocale()]) != "" || trim($description[\App::getLocale()]) != "")
                                            @if(trim($title[\App::getLocale()]) != "")
                                                <span style="font-size: 14px;">{{ $title[\App::getLocale()] }}</span><br>
                                            @endif

                                            @if(trim($description[\App::getLocale()]) != "")
                                                    <p> {!! $description[\App::getLocale()] !!}</p>
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
