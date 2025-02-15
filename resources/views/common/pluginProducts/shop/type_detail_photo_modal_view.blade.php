<div class="col-md-6 ">
    <?php $i=0; ?>
    @if(count($images))
        @foreach($images as $image)
            <?php
            $class = "";
            if($i == 0){
                $class = "active";
            }
            if(is_numeric(strpos($image, "uploads"))){
                $url = url("$image");
            }else{
                $url = url("uploads/products/$image");
            }
            ?>
            <div class="product-thumb <?php echo $class; ?>>">
                <img src="{{ $url }}" alt="{{ $itemProduct->name }}" class="img-fluid">
            </div>

            <?php
              break;
            ?>
        @endforeach
    @endif
</div>
