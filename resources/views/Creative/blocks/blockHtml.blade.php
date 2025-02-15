@if($item)
    <?php
        $mt = $item->mt;
        $description = json_decode($item->content, true);
        if($description === null){
            $description = [];
        }
    ?>
        @if($position != 'footer')
            <section class="page-section-ptb mt-{{ $item->mt }}">
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

