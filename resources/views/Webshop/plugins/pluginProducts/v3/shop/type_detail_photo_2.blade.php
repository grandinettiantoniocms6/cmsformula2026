<div class="col-md-5 pe-lg-4">
    <div class="gallery-wrap">
        <div class="row row-cols-2 gx-2">
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
                    <div class="col">
                        <div class="product-image active mb-1">
                            <img class="card img-fluid zoom-image" src="{{ $url }}" data-zoom-image="{{ $url }}" alt="{{ $itemProduct->name }}" width="800" height="900">
                            <a class="btn btn-blank font-xl glightbox" data-effect="fade" href="{{ $url }}" title="{{ $itemProduct->name }}"><i class="bi bi-search"></i></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
