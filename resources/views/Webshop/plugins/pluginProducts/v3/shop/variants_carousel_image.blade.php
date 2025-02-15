<?php
$name = $variant->name_variant;
$check = \App\Models\PluginProductsImages::where("product_id", $variant->id)->orderBy("order", "asc")->first();
$cover = null;
if($check){
    $cover = url("uploads/products/$check->image");
}
$cat_prod_name = "";
$cat_prod_slug = "no-categoria";
$cat_prod = $variant->category();
if($cat_prod){
    $cat_prod_name = $cat_prod->name;
    $cat_prod_slug = $cat_prod->slug;
}
?>
<a class="d-block" title="{{ $name }}" href="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$variant->slug]) }}">
    <div class="card">
        @if($cover)
            <img class="img-fluid mx-auto img-variant" src="{{ $cover }}" alt="{{ $name }}" width="280" height="315">
        @else
            <img class="img-fluid mx-auto img-variant" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $name }}" width="280" height="315">
        @endif
        <span class="p-2 bg-light small font-weight-bold text-uppercase">{{ $name }}</span>
    </div>
</a>
