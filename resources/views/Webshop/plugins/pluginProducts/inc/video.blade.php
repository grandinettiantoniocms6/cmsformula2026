@if($itemProduct->video)
    <?php
    $temp = explode("=", $itemProduct->video);
    ?>
    <iframe class="_iub_cs_activate" src="https://www.youtube.com/embed/{{ $temp[1] }}" width="95%" height="360" allowfullscreen></iframe>
@endif
