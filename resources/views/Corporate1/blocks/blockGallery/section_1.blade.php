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

<div class="gallery-area py-100">
    <div class="{{ $item->fullwidth }}">

        @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center wow fadeInDown" data-wow-delay=".25s">
                        <h2 class="site-title">{{ $titleBlocco[\App::getLocale()] }}</h2>
                        <h4><span>{{ $descriptionBlocco[\App::getLocale()] }}</span></h4>
                        <div class="heading-divider"></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row popup-gallery">

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


                                <div class="col-md-{{ $item->col }} col-sm-6">
                                    <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                                        @if(trim($foto) != "")
                                            <div class="gallery-img">
                                                <img src="{{ $foto }}" alt="">
                                            </div>
                                            <div class="gallery-content">
                                                <a class="popup-img gallery-link" href="{{ $foto }}"><i class="fal fa-plus"></i></a>
                                            </div>
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

                                </div>

                        @endforeach
                    @endif


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
