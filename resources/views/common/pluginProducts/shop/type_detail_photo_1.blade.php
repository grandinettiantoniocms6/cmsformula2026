<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$shopSetting = \App\Models\ShopSettings::first();
?>
<div class="col-md-6">
    <div class="product-gallery pg-vertical sticky-sidebar"
         data-sticky-options="{'minWidth': 767}">
        <div class="product-single-carousel owl-carousel owl-carousel-shop owl-theme owl-nav-inner row cols-1">
            @if(count($images))
                @foreach($images as $image)
                    <?php
                    if(is_numeric(strpos($image, "uploads"))){
                        $url = url("$image");
                    }else{
                        $url = url("uploads/products/$image");
                    }
                    ?>
                    <figure class="product-image">
                        <img src="{{ $url }}"
                             data-zoom-image="{{ $url }}"
                             alt="{{ $itemProduct->name }}">
                    </figure>
                @endforeach
            @endif
        </div>
        <div class="product-thumbs-wrap">
            <div class="product-thumbs">
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
                            <img src="{{ $url }}" alt="{{ $itemProduct->name }}"
                                 width="110" height="120" class="img-fluid">
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="thumb-up disabled"><i class="fas fa-chevron-left"></i></button>
            <button class="thumb-down disabled"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="product-label-group">
            @if($itemProduct->is_evidenza == 1 && trim(@$labels['shop-in-evidenza']) != "") <label class="product-label label-new" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-in-evidenza'] }}</label> @endif
            @if(trim($itemProduct->custom_1) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_1 }}">{{ $itemProduct->custom_1 }}</label> @endif
            @if(trim($itemProduct->custom_2) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_2 }}">{{ $itemProduct->custom_2 }}</label> @endif
        </div>
    </div>
</div>
