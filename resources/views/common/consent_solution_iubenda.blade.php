@if(env('IUBENDA') == 1)
    @if($website->consent_solution_iubenda)
        {!! $website->consent_solution_iubenda !!}
    @endif
@endif

<!-- Banner Iubenda o Banner Cookieconsent2 con if su ENV -->
@if(env('IUBENDA') == 1)
    {!! $website->iubenda_cookie_banner !!}
@else
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
    <script>
        window.addEventListener('load', function(){
            window.cookieconsent.initialise({
                'palette': {
                    'popup': {
                        'background': '{{ $website->cookie_div_bg }}',
                        'text': '{{ $website->cookie_txt_color }}'
                    },
                    'button': {
                        'background': '{{ $website->cookie_btn_bg }}'
                    }
                },
                'theme': 'classic',
                'position': '{{ $website->cookie_position }}',
                'content': {
                    'message': '{{ $labelSite['cookiebar_message'] }}',
                    'dismiss': '{{ $labelSite['cookiebar_ok'] }}',
                    'allow': 'Accetta',
                    'link': '{{ $labelSite['cookiebar_leggi_informativa'] }}',
                    'href': '{{ url('cookie') }}'
                }
            })
        });
    </script>
@endif
<!-- end ENV -->
