@if($array)
    @foreach($array as $value)
        <?php

        $title = json_decode($value->title, true);
        if($title === null){
            $title = [];
        }

        $subtitle = json_decode($value->subtitle, true);
        if($subtitle === null){
            $subtitle = [];
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

        if(!key_exists(\App::getLocale(), $title)){
            $title[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $subtitle)){
            $subtitle[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $button)){
            $button[\App::getLocale()] = "";
        }

        $type_href = $value->type_href;

        $url = "#";

        if(key_exists(\App::getLocale(), $url_interno)){
            if(trim($url_interno[\App::getLocale()]) != ""){
                $url = "/{$url_interno[\App::getLocale()]}";
            }else{
                if(key_exists(\App::getLocale(), $url_esterno)){
                    if(trim($url_esterno[\App::getLocale()]) != ""){
                        $url = $url_esterno[\App::getLocale()];
                    }
                }
            }
        }

        // serve per le thumb
        if($value->foto){
            $basename = basename($value->foto);
            $temp = explode(".", $basename);

            $check = "thumb/blocks_slideshows/$temp[0]-large.{$temp[1]}";
            if(file_exists($check)){
                $foto = url($check);
            }else{
                $foto = url($value->foto);
            }
        }

        ?>

        <section class="page-section-ptb bg-overlay-black-{{ $value->alpha }} mt-{{ $value->mt }} mb-{{ $value->mb }} popup-gallery o-hidden" style="background-image: url({{ $value->foto }}); background-color: {{ $value->bgcolor }}; height: {{ $item->height }}!important;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title mb-30" style="text-align: {!! $value->align !!}!important;">
                            <h{{ $value->h_title }} style="color: {{ $value->color_title }};">{{ $title[\App::getLocale()] }}</h{{ $value->h_title }}><br />
                            <h{{ $value->h_subtitle }} style="color: {{ $value->color_subtitle }};">{{ $subtitle[\App::getLocale()] }}</h{{ $value->h_subtitle }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title mb-30" style="text-align: {!! $value->align !!}!important;">
                            @if(trim($button[\App::getLocale()])!="")
                                  <a target="{{ $type_href }}" class="theme-btn-four" style="background-color: {{ $value->color_button }}!important; border: none" href="{{ $url }}">
                                      <span style="color: {{ $value->color_txt_button }}!important;">{{ $button[\App::getLocale()] }}</span>
                                  </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif
