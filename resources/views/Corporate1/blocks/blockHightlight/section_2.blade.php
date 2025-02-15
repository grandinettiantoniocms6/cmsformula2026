<div class="card wow animate__fadeInUp" data-wow-duration=".3s">
    <div class="row">
        <div class="col-lg-4">
            <img class="card-img" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" loading="lazy">
        </div>
        <div class="col-lg-8">
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
    </div>
</div>



