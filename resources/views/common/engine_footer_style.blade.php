<style>
    #footer{
        @if($website->photo_footer)
            background-image: url('{{ url($website->photo_footer) }}') !important;
        @else
            @if($website->footer_background)
                background: {{ $website->footer_background }} !important;
            @endif
        @endif

        @if($website->footer_color)
             color: {{ $website->footer_color }} !important;
        @endif
    }
    #footer a {
        @if($website->footer_color)
             color: {{ $website->footer_color }} !important;
        @endif
    }
   @if($website->footer_color_hover)
        #footer a:hover {
            color: {{ $website->footer_color_hover }} !important;
        }
    @endif
</style>

