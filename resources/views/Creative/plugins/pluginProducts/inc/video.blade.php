@if($itemProduct->video)
    <?php
    $temp = explode("=", $itemProduct->video);
    ?>
    @if(key_exists(1, $temp))
        @if(env('IUBENDA') == 1)
            <iframe class="_iub_cs_activate" data-suppressedsrc="https://www.youtube.com/embed/{{ $temp[1] }}" width="95%" height="360" allowfullscreen></iframe>
        @else
            <iframe src="https://www.youtube.com/embed/{{ $temp[1] }}" width="95%" height="360" allowfullscreen></iframe>
        @endif
    @endif
@endif
