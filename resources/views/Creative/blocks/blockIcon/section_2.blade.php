<div class="col-lg-{{ $item->col }} col-md-{{ $item->col }} col-sm-{{ $item->col }}" data-aos="fade-up" data-aos-delay="200">

    @if($value->icon)

            <div class="card-style-three mt-50" style="background-color: {{ $value->bgcolor }};">
                <div class="icon d-flex align-items-center justify-content-center">{!! $value->icon !!}</div>
                <h4 class="title">{{ $title[\App::getLocale()] }}</h4>
                <p>{!! $description[\App::getLocale()] !!}</p>
                @if(trim($button[\App::getLocale()])!="")
                    <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="background-color: {{ $value->bgcolor_button }}; color: {{ $value->color_text_button }}; border-color: {{ $value->bgcolor_button }}; ">{{ $button[\App::getLocale()] }}</a>
                @endif
            </div> <!-- /.card-style-three -->

    @else

        <div class="card-style-three mt-50">
            <div class="icon style-two d-flex align-items-center justify-content-center"><img src="{{ $value->foto }}" alt="" class="tran3s"></div>
            <h4 class="title">{{ $title[\App::getLocale()] }}</h4>
            <p>{!! $description[\App::getLocale()] !!}</p>
            @if(trim($button[\App::getLocale()])!="")
                <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="background-color: {{ $value->bgcolor_button }}; color: {{ $value->color_text_button }}; border-color: {{ $value->bgcolor_button }}; ">{{ $button[\App::getLocale()] }}</a>
            @endif
        </div> <!-- /.card-style-three -->


    @endif

</div>
