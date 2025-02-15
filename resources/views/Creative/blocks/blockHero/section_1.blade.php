<div class="hero-banner-five mt-225 md-mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 ms-auto">
                <h1 class="hero-heading">{{ $title[\App::getLocale()] }}</h1>
                <p class="hero-sub-heading text-lg">{!! $description[\App::getLocale()] !!}</p>
                @if(trim($button[\App::getLocale()])!="")
                    <a target="{{ $type_href }}" class="theme-btn-two" href="{{ $url }}">
                        <span>{{ $button[\App::getLocale()] }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="illustration-container">
        <img src="{{ $sfondo }}" alt="">
    </div> <!-- /img fluttuante -->
</div> <!-- /.hero-banner-five -->
