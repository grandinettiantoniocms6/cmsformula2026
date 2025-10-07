<?php
$website = \App\Models\WebsiteSetting::first();
$fullwidth = null;
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>

<!-- SE ENTRA IN QUESTO IF VUOL DIRE CHE STO VEDENDO IL DETTAGLIO -->
@if($blockNews)
    @include("Crafto.blocks.blockNews.detail")
@else
    @include("Crafto.blocks.blockNews.list")
@endif
