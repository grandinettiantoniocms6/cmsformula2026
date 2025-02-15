<div id="demo02" class="grid-item">
    <div class="hover02 column card mb-4">
        @if(trim($foto) != "")
            <div class="hover02 column">
                <a href="{{ $value->foto }}">
                    <figure><img src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" class="img-fluid"></figure>
                </a>
            </div>
        @endif
        @if(trim($title[\App::getLocale()]) != "" || trim($description[\App::getLocale()]) != "")
        <div class="card-footer">
            @if(trim($title[\App::getLocale()]) != "")
                <h5 class="title">{{ $title[\App::getLocale()] }}</h5>
            @endif
            @if(trim($description[\App::getLocale()]) != "")
                <div class="subtitle">{!! $description[\App::getLocale()] !!}</div>
            @endif
        </div>
        @endif
    </div>
</div>



