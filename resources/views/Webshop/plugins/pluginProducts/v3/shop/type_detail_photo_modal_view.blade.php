<div class="col-md-5">
    <div class="gallery-wrap">
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
                $checkImage = "thumb/plugin_products/$temp[0]-list.webp";
            } else {
                $checkImage = "thumb/plugin_products/$temp[0]-list";
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
            <div class="product-thumb <?php echo $class; ?>>">
                <img src="{{ $url }}" alt="{{ $itemProduct->name }}" class="img-fluid">
            </div>
            <?php break; ?>
        @endforeach
    @endif
    </div>
</div>
