@if($website->title_footer_1)
    <div id="footer_1" style="display:none; width: 50%;" data-height="360">
        {!! $website->text_footer_1 !!}
    </div>
@endif

@if($website->title_footer_2)
    <div id="footer_2" style="display:none; max-width: 70%;" data-height="360">
        {!! $website->text_footer_2 !!}
    </div>
@endif

@if($website->title_footer_3)
    <div id="footer_3" style="display:none; max-width: 80%;" data-height="360">
        {!! $website->text_footer_3 !!}
    </div>
@endif

@if($website->title_footer_4)
    <div id="footer_4" style="display:none; max-width: 70%;" data-height="360">
        {!! $website->text_footer_4 !!}
    </div>
@endif
