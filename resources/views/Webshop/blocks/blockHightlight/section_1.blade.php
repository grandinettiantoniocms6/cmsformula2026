<div class="card wow animate__fadeInUp" data-wow-duration=".3s">
    <img class="card-img-top" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
    <div class="card-body">
        <h5 class="title">{{ $title[\App::getLocale()] }}</h5>
        <div class="abstract">{{ $abstract[\App::getLocale()] }}</div>
        <div class="description">{!! $description[\App::getLocale()] !!}</div>
    </div>
    @if(trim($button[\App::getLocale()])!="")
        <div class="card-footer">
            <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                {{ $button[\App::getLocale()] }}
            </a>
        </div>
    @endif
</div>
