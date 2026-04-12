<?php
$website = \App\Models\WebsiteSetting::first();
$fullwidth = null;
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>

<!-- SE ENTRA IN QUESTO IF VUOL DIRE CHE STO VEDENDO IL DETTAGLIO -->
@if($blockNews)
    @include("Corporate2.blocks.blockNews.detail")
@else
    @include("Corporate2.blocks.blockNews.list")
@endif
