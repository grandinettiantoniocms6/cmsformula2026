        {{-- jQuery (REQUIRED) --}}
        @if (!isset ($jquery) || (isset($jquery) && $jquery == true))
        @basset('https://unpkg.com/jquery@3.6.1/dist/jquery.min.js')
        @endif

        {{-- jQuery UI and Smoothness theme --}}
        @bassetArchive('https://github.com/jquery/jquery-ui/archive/refs/tags/1.13.2.tar.gz', 'jquery-ui-1.13.2')
        @basset('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css')
        @basset('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js')

        {{-- elFinder JS (REQUIRED) --}}
        @bassetArchive('https://github.com/Studio-42/elFinder/archive/refs/tags/2.1.64.tar.gz', 'elfinder-2.1.64')
        @basset('https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.64/js/elfinder.min.js')

        {{-- elFinder translation (OPTIONAL) --}}
        @if($locale)
        @basset('https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.64/js/i18n/elfinder.'.$locale.'.min.js')
        @endif

        {{-- elFinder sounds --}}
        @basset(base_path('vendor/studio-42/elfinder/sounds/rm.wav'))