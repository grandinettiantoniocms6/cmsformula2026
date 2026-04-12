<div class="col-lg-{{ $item->col }} col-md-6">
    <!-- se uso class="card-img" le immagini restano boxate -->
    <a class="card" target="{{ $type_href }}" href="{{ $url }}">
        <img src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
        <div class="card-img-overlay">
            @if(trim($title[\App::getLocale()])!="")
                <h5 class="title">{{ $title[\App::getLocale()] }}</h5>
            @endif
            <div class="description">{!! $description[\App::getLocale()] !!}</div>
            @if(trim($button[\App::getLocale()])!="")
                <span target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                     {{ $button[\App::getLocale()] }}
                </span>
            @endif
        </div>
    </a>

</div>
