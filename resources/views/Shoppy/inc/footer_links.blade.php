@if($website->title_footer_1)
        <a href="#" data-toggle="modal" data-target="#footer_1">{{ $website->title_footer_1 }}</a> -
@endif
@if($website->title_footer_2)
        <a href="#" data-toggle="modal" data-target="#footer_2">{{ $website->title_footer_2 }}</a> -
@endif
@if($website->title_footer_3)
        <a href="#" data-toggle="modal" data-target="#footer_3">{{ $website->title_footer_3 }}</a> -
@endif
@if($website->title_footer_4)
        <a href="#" data-toggle="modal" data-target="#footer_4">{{ $website->title_footer_4 }}</a>
@endif

@if($website->photo_credits)
        <a href="{{ $website->link_credits }}" target="_blank"><img class="img-fluid mx-auto" src="{{ url($website->photo_credits) }}"></a>
@endif
