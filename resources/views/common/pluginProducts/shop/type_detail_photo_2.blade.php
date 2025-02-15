<div class="col-md-6">
    <div class="product-gallery row cols-sm-2">
        @if(count($images))
            @foreach($images as $image)
                <?php
                if(is_numeric(strpos($image, "uploads"))){
                    $url = url("$image");
                }else{
                    $url = url("uploads/products/$image");
                }
                ?>
                <figure class="product-image mb-4">
                    <img src="{{ $url }}"
                         data-zoom-image="{{ $url }}"
                         alt="{{ $itemProduct->name }}" width="800" height="900">
                    <a href="{{ $url }}" class="product-image-full"><i class="fas fa-search-plus">+</i></a>
                </figure>
            @endforeach
        @endif
    </div>
</div>
