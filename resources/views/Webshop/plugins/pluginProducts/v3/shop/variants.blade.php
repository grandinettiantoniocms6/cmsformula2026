<?php
    $variants = \App\Models\PluginProducts::where("is_variant", 1)
        ->where("id", "!=", $itemProduct->id)
        ->where("group_id", "=", $itemProduct->group_id)
        ->get();
?>
@if(count($variants) > 0)
    <hr>
    <div class="form-group my-0">
        <label class="small text-uppercase">Varianti ({{ count($variants) }})</label>
        <div class="row row-small">
            @foreach ($variants as $variant)
                <div class="col-3">
                    @include("$thema.plugins.pluginProducts.v3.shop.variants_carousel_image")
                </div>
            @endforeach
        </div>
    </div>
@endif
