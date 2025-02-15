@if($website->title_footer_1)
    <a href="#footer_1" data-fancybox="#footer_1" >{{ $website->title_footer_1 }}</a> -
@endif
@if($website->title_footer_2)
    <a href="#footer_2" data-fancybox="#footer_2" >{{ $website->title_footer_2 }}</a> -
@endif
@if($website->title_footer_3)
    <a href="#footer_3" data-fancybox="#footer_3" >{{ $website->title_footer_3 }}</a> -
@endif
@if($website->title_footer_4)
    <a href="#footer_4" data-fancybox="#footer_4" >{{ $website->title_footer_4 }}</a>
@endif

@if($website->photo_credits)
        <a href="{{ $website->link_credits }}" target="_blank"><img class="img-fluid mx-auto" src="{{ url($website->photo_credits) }}"></a>
@endif
