@if($itemProduct->brand_id)
    <?php
    $brand = \App\Models\PluginProductsBrands::where("id", $itemProduct->brand_id)->where("is_active", 1)->first();
    ?>
    @if($brand)
        @if($brand->image)
            <?php
                // serve per le thumb
                $basename = basename($brand->image);
                $temp = explode(".", $basename);

                if(key_exists(1,$temp)){
                    $check = "thumb/plugin_brands/$temp[0]-large.webp";
                }else{
                    $check = "thumb/plugin_brands/$temp[0]-large";
                }

                if(file_exists($check)){
                    $foto = url($check);
                    if(env('LOCAL') == 0){
                        list($width, $height, $type, $attr) = getimagesize(public_path("$check"));
                    }

                }else{
                    $foto = url($brand->image);

                    if(env('LOCAL') == 0){
                        list($width, $height, $type, $attr) = getimagesize(public_path("$brand->image"));
                    }

                }
           ?>

            <a class="product-brand-image" href="{{ route('pluginProductsBrands.it', $brand->slug) }}" title="{{ $brand->name }}">
                <img class="img-fluid" src="{{ $foto }}" alt="{{ $brand->name }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
            </a>
        @else
            <a class="product-brand-badge" href="{{ route('pluginProductsBrands.it', $brand->slug) }}" title="{{ $brand->name }}">{{ $brand->name }}</a>
        @endif
    @endif
@endif
