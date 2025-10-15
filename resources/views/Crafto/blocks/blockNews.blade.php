<?php
$ids = [];
if($array){
    foreach ($array as $temp){
        $ids[] = $temp->id;
    }
}
$news = \App\Models\BlockNews::whereIn("id", $ids)->paginate();
?>
@include("Crafto.blocks.blockNews.block")
