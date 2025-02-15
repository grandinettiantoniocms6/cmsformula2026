<style>

    /* a:hover {
        background-color: {{ $item->bgcolor_button_hover }} !important;
    } */

    .feature-icon i, .feature-icon span {

        color: {{ $item->color_icon }}!important;
        border-color: {{ $item->color_icon }}!important;
    }

    .feature-text.round:hover .feature-text.round:hover {
        background-color: {{ $item->bgcolor_button_hover }}  !important;
        color: {{ $value->bgcolor }} !important;
        border-color: {{ $value->bgcolor }} !important;
    }

    .marketing-service .feature-text:hover {
        background-color: {{ $item->bgcolor_hover }} !important;

    }

    /*.feature-icon i:hover, .feature-icon span:hover {
        background-color: {{ $item->bgcolor_button_hover }} !important;
        color: {{ $value->bgcolor }}!important;
        border-color: {{ $value->bgcolor }}!important;
    }*/

</style>

<div class="col-lg-{{ $item->col }} col-md-{{ $item->col }} col-sm-{{ $item->col }} aos-init aos-animate" data-aos="fade-up">

    @if($value->icon)

        <div class="card-style-four mb-130 lg-mb-70" style="background-color: {{ $value->bgcolor }};">
            <div class="icon d-flex align-items-end">{!! $value->icon !!}</div>
            <h4 class="title">{{ $title[\App::getLocale()] }}</h4>
            <p>{!! $description[\App::getLocale()] !!}</p>
            @if(trim($button[\App::getLocale()])!="")
                <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="background-color: {{ $value->bgcolor_button }}; color: {{ $value->color_text_button }}; border-color: {{ $value->bgcolor_button }}; ">{{ $button[\App::getLocale()] }}</a>
            @endif
        </div> <!-- /.card-style-three -->

    @else

        <div class="card-style-four mb-130 lg-mb-70">
            <div class="icon d-flex align-items-end"><img src="{{ $value->foto }}" alt="" class="tran3s"></div>
            <h4 class="title">{{ $title[\App::getLocale()] }}</h4>
            <p>{!! $description[\App::getLocale()] !!}</p>
            @if(trim($button[\App::getLocale()])!="")
                <a target="{{ $type_href }}" href="{{ $url }}" class="btn" style="background-color: {{ $value->bgcolor_button }}; color: {{ $value->color_text_button }}; border-color: {{ $value->bgcolor_button }}; ">{{ $button[\App::getLocale()] }}</a>
            @endif
        </div> <!-- /.card-style-three -->


    @endif

</div>

