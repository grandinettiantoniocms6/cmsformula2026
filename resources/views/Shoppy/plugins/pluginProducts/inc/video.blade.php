@if($itemProduct->video)
    <?php
    $temp = explode("=", $itemProduct->video);
    ?>
    <iframe src="https://www.youtube.com/embed/{{ $temp[1] }}" width="95%" height="360" allowfullscreen></iframe>
@endif
