<div class="col-lg-{{ $item->col }} col-md-{{ $item->col }} col-sm-{{ $item->col }}" data-aos="fade-up">

    @if($value->icon)

    <div class="card-style-eight" style="background-color: {{ $value->bgcolor }};">
        <div class="icon d-flex align-items-end">{!! $value->icon !!}</div>
        <h4>{{ $title[\App::getLocale()] }}</h4>
        <p>{!! $description[\App::getLocale()] !!}</p>
            @if(trim($button[\App::getLocale()])!="")
                <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="background-color: {{ $value->bgcolor_button }}; color: {{ $value->color_text_button }}; border-color: {{ $value->bgcolor_button }};">{{ $button[\App::getLocale()] }}</a>
            @endif

    </div>

    @else

    <div class="card-style-eight" style="background-color: {{ $value->bgcolor }};">

        <div class="icon d-flex align-items-end" style="margin-top: 30px;"><img src="{{ $value->foto }}" title=""></div>

        <h4>{{ $title[\App::getLocale()] }}</h4>
        <p>{!! $description[\App::getLocale()] !!}</p>
        @if(trim($button[\App::getLocale()])!="")
            <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="background-color: {{ $value->bgcolor_button }}; color: {{ $value->color_text_button }}; border-color: {{ $value->bgcolor_button }}; ">{{ $button[\App::getLocale()] }}</a>
        @endif
        </div>


    @endif

</div>


