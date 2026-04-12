<style>
    #block-lastwork-{{ $value->block_id }} {
        background-color: {{ $value->bg_color }};
    }
    #block-lastwork-{{ $value->block_id }} .section-subtitle {
        color: {{ $value->color_subtitle }};
    }
    #block-lastwork-{{ $value->block_id }} .section-title {
        color: {{ $value->color_title }};
    }
</style>

<section class="block-lastwork wow animate__fadeInUp" data-wow-duration=".3s" id="block-lastwork-{{ $value->block_id }}">

    <div class="container">
        <div class="lastwork-textblock text-left">
            <h6 class="section-subtitle">{{ $subtitle[\App::getLocale()] }}</h6>
            <h2 class="section-title">{{ $title[\App::getLocale()] }}</h2>
            <div class="description">{!! $description[\App::getLocale()] !!}</div>
            @if(trim($button[\App::getLocale()])!="")
                <a target="{{ $type_href }}" href="{{ $url }}" class="btn btn-primary">{{ $button[\App::getLocale()] }}</a>
            @endif
        </div>
    </div>

    <div id="lastwork-block-{{ $item->id }}" class="owl-carousel owl-theme owl-block-lastwork"
         data-toggle='owlcarousel'
         data-margin='[0,0,0,0,0,0,0]'
         data-autowidth='[false,false,false,false,false,false,false]'
         data-autoplay='[false,0]'
         data-responsive='[1,1,2,3,3,3,3]'
         data-dots='[false,false,false,false,false,false,false]'
         data-nav='[false,false,false,false,false,false,false]'
    >
        <div class="grid-item">
            <div class="card">
                @if(trim($foto1) != "")
                    <a class="d-block" target="{{ $type_href_1 }}" href="{{ $url_1 }}"><img class="img-fluid" src="{{ $foto1 }}" alt="{{ $workname_1[\App::getLocale()] }}" loading="lazy"></a>
                @endif
                <div class="card-overlay bg-primary">
                    @if(trim($button_1[\App::getLocale()])!="")
                        <h4 class="title">{{ $workname_1[\App::getLocale()] }}</h4>
                        <a class="text" target="{{ $type_href_1 }}" href="{{ $url_1 }}">{{ $worktype_1[\App::getLocale()] }} | {{ $button_1[\App::getLocale()] }}</a>
                    @endif
                </div>
                <a class="glightbox-p" href="{{ $foto1 }}"><i class="bi bi-arrows-move"></i></a>
            </div>
        </div>

        <div class="grid-item">
            <div class="card">
                @if(trim($foto2) != "")
                    <a class="d-block" target="{{ $type_href_2 }}" href="{{ $url_2 }}"><img class="img-fluid" src="{{ $foto2 }}" alt="{{ $workname_2[\App::getLocale()] }}" loading="lazy"></a>
                @endif
                <div class="card-overlay bg-primary">
                    @if(trim($button_2[\App::getLocale()])!="")
                        <h4 class="title">{{ $workname_2[\App::getLocale()] }}</h4>
                        <a class="text" target="{{ $type_href_2 }}" href="{{ $url_2 }}">{{ $worktype_2[\App::getLocale()] }} | {{ $button_2[\App::getLocale()] }}</a>
                    @endif
                </div>
                <a class="glightbox-p" href="{{ $foto2 }}"><i class="bi bi-arrows-move"></i></a>
            </div>
        </div>

        <div class="grid-item">
            <div class="card">
                @if(trim($foto3) != "")
                    <a class="d-block" target="{{ $type_href_3 }}" href="{{ $url_3 }}"><img class="img-fluid" src="{{ $foto3 }}" alt="{{ $workname_3[\App::getLocale()] }}" loading="lazy"></a>
                @endif
                <div class="card-overlay bg-primary">
                    @if(trim($button_3[\App::getLocale()])!="")
                        <h4 class="title">{{ $workname_3[\App::getLocale()] }}</h4>
                        <a class="text" target="{{ $type_href_3 }}" href="{{ $url_3 }}">{{ $worktype_3[\App::getLocale()] }} | {{ $button_3[\App::getLocale()] }}</a>
                    @endif
                </div>
                <a class="glightbox-p" href="{{ $foto3 }}"><i class="bi bi-arrows-move"></i></a>
            </div>
        </div>

        <div class="grid-item">
            <div class="card">
                @if(trim($foto4) != "")
                    <a class="d-block" target="{{ $type_href_4 }}" href="{{ $url_4 }}"><img class="img-fluid" src="{{ $foto4 }}" alt="{{ $workname_4[\App::getLocale()] }}" loading="lazy"></a>
                @endif
                <div class="card-overlay bg-primary">
                    @if(trim($button_4[\App::getLocale()])!="")
                        <h4 class="title">{{ $workname_4[\App::getLocale()] }}</h4>
                        <a class="text" target="{{ $type_href_4 }}" href="{{ $url_4 }}">{{ $worktype_4[\App::getLocale()] }} | {{ $button_4[\App::getLocale()] }}</a>
                    @endif
                </div>
                <a class="glightbox-p" href="{{ $foto4 }}"><i class="bi bi-arrows-move"></i></a>
            </div>
        </div>

        <div class="grid-item">
            <div class="card">
                @if(trim($foto5) != "")
                    <a class="d-block" target="{{ $type_href_5 }}" href="{{ $url_5 }}"><img class="img-fluid" src="{{ $foto5 }}" alt="{{ $workname_5[\App::getLocale()] }}" loading="lazy"></a>
                @endif
                <div class="card-overlay bg-primary">
                    @if(trim($button_5[\App::getLocale()])!="")
                        <h4 class="title">{{ $workname_5[\App::getLocale()] }}</h4>
                        <a class="text" target="{{ $type_href_5 }}" href="{{ $url_5 }}">{{ $worktype_5[\App::getLocale()] }} | {{ $button_5[\App::getLocale()] }}</a>
                    @endif
                </div>
                <a class="glightbox-p" href="{{ $foto5 }}"><i class="bi bi-arrows-move"></i></a>
            </div>
        </div>

        <div class="grid-item">
            <div class="card">
                @if(trim($foto6) != "")
                    <a class="d-block" target="{{ $type_href_6 }}" href="{{ $url_6 }}"><img class="img-fluid" src="{{ $foto6 }}" alt="{{ $workname_6[\App::getLocale()] }}" loading="lazy"></a>
                @endif
                <div class="card-overlay bg-primary">
                    @if(trim($button_6[\App::getLocale()])!="")
                        <h4 class="title">{{ $workname_5[\App::getLocale()] }}</h4>
                        <a class="text" target="{{ $type_href_6 }}" href="{{ $url_6 }}">{{ $worktype_6[\App::getLocale()] }} | {{ $button_6[\App::getLocale()] }}</a>
                    @endif
                </div>
                <a class="glightbox-p" href="{{ $foto6 }}"><i class="bi bi-arrows-move"></i></a>
            </div>
        </div>
    </div>
</section>
