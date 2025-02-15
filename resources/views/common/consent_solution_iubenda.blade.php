@if(env('IUBENDA') == 1)
    @if($website->consent_solution_iubenda)
        {!! $website->consent_solution_iubenda !!}
    @endif
@endif
