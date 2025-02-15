
<!--

Per il momento non uso gli style 2 , 3 e 4 in quando su Crafto non riesco a far funzionare il ciclo if con le 10 immagini

-->



    <div class="row space-{{ $item->pb }} wow animate__fadeInUp" data-wow-duration=".3s">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>{{ $title[\App::getLocale()] }}</h2>
                <p>{!! $description[\App::getLocale()] !!}</p>
            </div>
            @if(trim($button[\App::getLocale()])!="")
                <a target="{{ $type_href }}" class="button button-border-white mt-20 button mt-30 mb-30" href="{{ $url }}">
                    <span>{{ $button[\App::getLocale()] }}</span>
                </a><p></p>
            @endif
        </div>
    </div>

    <div class="row justify-content-center space-{{ $item->pb }} wow animate__fadeInUp" data-wow-duration=".3s">
        <div class="col-lg-8">
            <div class="owl-carousel" id="slider-carosello" data-autoheight="true" data-nav-dots="true" data-items="1" data-md-items="1" data-sm-items="1" data-xs-items="1" data-xx-items="1" data-space="20">
                @if($value->foto)
                    <div class="item">
                        <img src="{{ $value->foto }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if($value->foto2)
                    <div class="item">
                        <img src="{{ $value->foto2 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto3)
                    <div class="item">
                        <img src="{{ $value->foto3 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto4)
                    <div class="item">
                        <img src="{{ $value->foto4 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto5)
                    <div class="item">
                        <img src="{{ $value->foto5 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto6)
                    <div class="item">
                        <img src="{{ $value->foto6 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto7)
                    <div class="item">
                        <img src="{{ $value->foto7 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto8)
                    <div class="item">
                        <img src="{{ $value->foto8 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto9)
                    <div class="item">
                        <img src="{{ $value->foto9 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif
                @if(@$value->foto10)
                    <div class="item">
                        <img src="{{ $value->foto10 }}" class="img-fluid full-width" alt="" loading="lazy">
                    </div>
                @endif

            </div>
        </div>
    </div>


