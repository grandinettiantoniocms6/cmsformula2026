<?php
$shop_extra = \App\Models\ShopExtra::where("is_active", 1)->where("type_id", 1)->get();
?>

@if($shop_extra)


    @foreach($shop_extra as $extra)
        <?php
        $categories_ids = [];
        if($extra->categories){
            $categories_ids = explode(";", $extra->categories);
        }

        $non_ammesso = 0;
        if(count($categories_ids)){
            if($categories_products){
                foreach($categories_products as $category_product){
                    if(in_array($category_product->plugin_product_category_id, $categories_ids)){
                        $non_ammesso = 1;
                    }
                }
            }
        }

        ?>
        @if($non_ammesso == 0)
        <h5>{{ $extra->name }} <span class="badge-primary badge">{{ number_format($extra->price, 2,",", ".") }} &euro;</span> </h5>
        <div class="form-group">
            <label>{{ $extra->description }}</label>
            <input type="text" class="form-control" name="extra[{{ $extra->id }}]" maxlength="16">
        </div>
        @endif
    @endforeach
@endif
