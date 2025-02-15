<style>
    body {
        @if($website->site_background)
            background: {{ $website->site_background }} !important;
        @endif


        @if($website->site_color)
             color: {{ $website->site_color }} !important;
        @endif
    }

    #body a {
        @if($website->site_color)
             color: {{ $website->site_color }} !important;
        @endif
    }

   @if($website->site_color_hover)
        #body a:hover {
            color: {{ $website->site_color_hover }} !important;
        }
    @endif
</style>
