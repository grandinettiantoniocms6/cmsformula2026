<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$shopSetting = \App\Models\ShopSettings::first();
?>

<div class="col-md-5 pe-lg-4">
    <div class="gallery-wrap">
        <div class="owl-carousel owl-theme" id="image-carousel">
            @if(count($images))
                @foreach($images as $image)
                    <?php
                    $basename = basename($image);
                    $temp = explode(".", $basename);

                    if(is_numeric(strpos($image, "uploads"))){
                        $url = url("$image");
                    } else {
                        $url = url("uploads/products/$image");
                    }

                    if (key_exists(1, $temp)) {
                        $checkImage = "thumb/plugin_products/$temp[0]-large.webp";
                    } else {
                        $checkImage = "thumb/plugin_products/$temp[0]-large";
                    }

                    if(is_numeric(strpos($image, "uploads/special_images"))){
                        if (key_exists(1, $temp)) {
                            $checkImage = "thumb/special_images/{$itemProduct->id}/$temp[0]-large.webp";
                        }
                    }

                    if (file_exists($checkImage)) {
                        $url = url($checkImage);
                    }
                    ?>
                    <div class="product-image">
                        <img class="img-fluid card zoom-image" src="{{ $url }}" data-zoom-image="{{ $url }}" alt="{{ $itemProduct->name }}" @if(!$loop->first) loading="lazy" @endif>
                        <a class="btn btn-light font-xl glightbox" data-effect="fade" href="{{ $url }}" title="{{ $itemProduct->name }}"><i class="bi bi-search"></i></a>
                    </div>
                @endforeach
            @else
                <?php
                    $url = url("plugins/pluginProducts/no-image.jpg");
                ?>
                <img class="img-fluid card zoom-image" src="{{ $url }}" data-zoom-image="{{ $url }}" alt="{{ $itemProduct->name }}">
            @endif
        </div>
        <div class="owl-carousel owl-theme my-2" id="thumb-carousel">
            <?php $i=0; ?>
            @if(count($images))
                @foreach($images as $image)
                    <?php
                    $class = "";
                    if($i == 0){
                        $class = "active";
                    }

                    $basename = basename($image);
                    $temp = explode(".", $basename);

                    if(is_numeric(strpos($image, "uploads"))){
                        $url = url("$image");
                    }else{
                        $url = url("uploads/products/$image");
                    }

                    if (key_exists(1, $temp)) {
                        $checkImage = "thumb/plugin_products/$temp[0]-gallery.webp";
                    } else {
                        $checkImage = "thumb/plugin_products/$temp[0]-gallery";
                    }

                    if(is_numeric(strpos($image, "uploads/special_images"))){
                        if (key_exists(1, $temp)) {
                            $checkImage = "thumb/special_images/{$itemProduct->id}/$temp[0]-large.webp";
                        }
                    }

                    if (file_exists($checkImage)) {
                        $url = url($checkImage);
                    }

                    ?>
                    <div class="product-thumb <?php echo $class; ?>>"><img src="{{ $url }}" alt="{{ $itemProduct->name }}" width="100" height="100" class="card img-fluid"></div>
                @endforeach
            @endif
        </div>

        <div class="product-label-group">
            @if($itemProduct->is_evidenza == 1 && trim(@$labels['shop-in-evidenza']) != "") <label class="product-label label-new">{{ @$labels['shop-in-evidenza'] }}</label> @endif
            @if(trim($itemProduct->custom_1) != "") <label class="product-label product-label-custom-color-1">{{ $itemProduct->custom_1 }}</label> @endif
            @if(trim($itemProduct->custom_2) != "") <label class="product-label product-label-custom-color-2">{{ $itemProduct->custom_2 }}</label> @endif
        </div>
    </div>
</div>
