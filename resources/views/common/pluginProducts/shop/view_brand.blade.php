@if($itemProduct->brand_id)
    <?php
    $brand = \App\Models\PluginProductsBrands::where("id", $itemProduct->brand_id)->where("is_active", 1)->first();
    ?>
    @if($brand)
        @if($brand->image)
            <div class="mb-3"><a title="{{ $brand->name }}" href="{{ route('pluginProductsBrands.it', $brand->slug) }}"><img class="img-fluid mx-auto" src="{{ url($brand->image) }}" alt="{{ $brand->name }}"></a></div>
        @else
            <div class="mb-2"><a class="badge badge-primary" href="{{ route('pluginProductsBrands.it', $brand->slug) }}" title="{{ $brand->name }}"><h5 class="my-0">{{ $brand->name }}</h5></a></div>
        @endif
    @endif
@endif
