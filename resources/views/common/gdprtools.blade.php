@if(env('GDPRTOOLS') == 1)

    @if($website->cookieyes)
        {!! $website->cookieyes !!}
    @endif

    @if($website->cookiebot)
        {!! $website->cookiebot !!}
    @endif

    @if($website->usercentrics)
        {!! $website->usercentrics !!}
    @endif

@endif
