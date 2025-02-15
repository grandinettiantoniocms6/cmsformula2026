@if($item)
<?php
$description = json_decode($item->content, true);
?>
@if($item->is_with_section)
    <section class="white-bg page-section-ptb">
        <div class="container">
            @if(key_exists(\App::getLocale(), $description))
                  {!! $description[\App::getLocale()] !!}
            @endif
        </div>
    </section>
@else
    @if(key_exists(\App::getLocale(), $description))
         {!! $description[\App::getLocale()] !!}
    @endif
@endif

@endif

