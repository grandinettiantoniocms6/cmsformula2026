<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$options = null;
$attribute_item = null;
$option_selected = null;

$variants_ids = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)
    ->where("is_variant", 1)
    ->where("is_active", 1)
    ->get()->pluck("id")
    ->toArray();


if($itemProduct->is_variant == 0){
    $figli_ids = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)->where("is_active", 1)->where("is_variant", 1)->get()->pluck("id")->toArray();
}else{
    $figli_ids = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)->where("is_active", 1)->get()->pluck("id")->toArray();
}

if(count($figli_ids)){
    $attribute_ids = \App\Models\ShopAttributesProducts::whereIn("product_id", $figli_ids)->groupBy("attribute_id")->get()->pluck("attribute_id")->toArray();
    $attribute_item = \App\Models\ShopAttributes::whereIn("id", $attribute_ids)->orderBy("lft", "asc")->first();
}

if($attribute_item){
    $options = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.value, shop_attributes_options.background_color, shop_attributes_products.id")
        ->join("shop_attributes_options", "shop_attributes_options.id", "shop_attributes_products.option_id")
        ->where("attribute_id", $attribute_item->id)
        ->whereIn("product_id", $figli_ids)
        ->groupBy("value")
        ->orderBy("shop_attributes_options.ordine", "asc")
        ->get();
}

if($itemProduct->is_variant == 1){
    $variant_attribute_ids = \App\Models\ShopAttributesProducts::where("product_id", $itemProduct->id)
        ->groupBy("attribute_id")->get()
        ->pluck("attribute_id")
        ->toArray();

    $variant_attribute_item = \App\Models\ShopAttributes::whereIn("id", $variant_attribute_ids)->orderBy("lft", "asc")->first();

    $variant_option = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.*, shop_attributes_products.id")
        ->join("shop_attributes_options", "shop_attributes_options.id", "shop_attributes_products.option_id")
        ->where("attribute_id", $attribute_item->id)
        ->where("product_id", $itemProduct->id)
        ->groupBy("value")
        ->first();

    if($variant_option){
        $option_selected = $variant_option->value;
        $optionProduct = \App\Models\ShopAttributesProducts::where("id", $variant_option->id)->first();
    }
}
?>

@if($attribute_item && count($options))
    <?php
    if($attribute_item->type_layout == 0){
        $type_layout = "checkbox-size";
    }else{
        $type_layout = "checkbox-color";
    }
    ?>

    {{ $attribute_item->name }}:
    <div class="product-form product-variations">
        <div class="my-4">
            @foreach($options as $option)
                <?php
                $checked = "";
                if($option_selected == $option->value){
                    $checked = "checked";
                }
                ?>
                <label class="{{ $type_layout }}">
                    <input <?php echo $checked; ?> type="radio" name="first_attribute" value="{{ $option->id }}" onclick="click_radio({{ $option->id }});">
                    <span class="btn" @if($option->background_color) style="background: {{ $option->background_color }}" @endif>{{ $option->value }}</span>
                </label>
            @endforeach
        </div>
    </div>


    <div id="second_attribute_box">
        @if($itemProduct->is_variant == 1)
            <?php
            $option_selected_2 = null;
            //prendi tutti quei prodotti che hanno come option il 7 e attribute_id = 1
            $ids = \App\Models\ShopAttributesProducts::where("attribute_id", $optionProduct->attribute_id)
                ->where("option_id", $optionProduct->option_id)
                ->whereIn("product_id", $variants_ids)
                ->get()->pluck("product_id")
                ->toArray();

            if(count($ids)){
                //questi prodotti hanno anche un attribute_id != 1 ?
                $attribute_ids = \App\Models\ShopAttributesProducts::whereIn("product_id", $ids)
                    ->where("attribute_id", "!=", $optionProduct->attribute_id)
                    ->groupBy("attribute_id")
                    ->get()
                    ->pluck("attribute_id")
                    ->toArray();

                $attribute_item = \App\Models\ShopAttributes::whereIn("id", $attribute_ids)->orderBy("lft", "asc")->first();
                if($attribute_item){
                    $options = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.*, shop_attributes_products.product_id")
                        ->join("shop_attributes_options", "shop_attributes_options.id", "shop_attributes_products.option_id")
                        ->where("attribute_id", $attribute_item->id)
                        ->whereIn("product_id", $ids)
                        ->groupBy("value")
                        ->orderBy("shop_attributes_options.ordine", "asc")
                        ->get();

                    $variant_option = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.*")
                        ->join("shop_attributes_options", "shop_attributes_options.id", "shop_attributes_products.option_id")
                        ->where("attribute_id", $attribute_item->id)
                        ->where("product_id", $itemProduct->id)
                        ->groupBy("value")
                        ->first();
                    if($variant_option){
                        $option_selected_2 = $variant_option->id;
                    }
                }
            }
            ?>

            @if($options && $attribute_item)
                    <?php
                    if($attribute_item->type_layout == 0){
                        $type_layout = "checkbox-size";
                    }else{
                        $type_layout = "checkbox-color";
                    }
                    ?>

                    {{ $attribute_item->name }}:
                <div class="product-form product-variations">
                    <div class="my-4">
                        @foreach($options as $option)
                            <?php
                            $variantProduct = \App\Models\PluginProducts::find($option->product_id);
                            if(!$variantProduct){
                                continue;
                            }
                            $cat_prod_name = "";
                            $cat_prod_slug = "no-categoria";
                            $cat_prod = $variantProduct->category();
                            if($cat_prod){
                                $cat_prod_name = $cat_prod->name;
                                $cat_prod_slug = $cat_prod->slug;
                            }
                            $checked = "";
                            if($option_selected_2 == $option->id){
                                $checked = "checked";
                            }
                            ?>
                            <label class="{{ $type_layout }}">
                                <input <?php echo $checked;?> type="radio" name="second_attribute" value="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$variantProduct->slug]) }}" onchange="redirectVariant(this);">
                                <span class="btn" @if($option->background_color) style="background: {{ $option->background_color }}" @endif>{{ $option->value }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

        @endif
    </div>
@endif


<!--
<div class="my-4">
    <label class="checkbox-size"><input type="radio" name="choose_55"><span class="btn">XS</span></label>
    <label class="checkbox-size"><input type="radio" name="choose_55"><span class="btn">S</span></label>
    <label class="checkbox-size"><input type="radio" name="choose_55"><span class="btn">M</span></label>
    <label class="checkbox-size"><input type="radio" name="choose_55" checked><span class="btn">L</span></label>
    <label class="checkbox-size"><input type="radio" name="choose_55"><span class="btn">XL</span></label>
    <label class="checkbox-size"><input type="radio" name="choose_55"><span class="btn">XXL</span></label>
</div>

<div class="my-4">
    <label class="checkbox-color"><input type="radio" name="choose_54"><span class="btn" style="background: #1b46ce">Blue</span></label>
    <label class="checkbox-color"><input type="radio" name="choose_54" checked><span class="btn" style="background: #fca2ce">Green</span></label>
    <label class="checkbox-color"><input type="radio" name="choose_54"><span class="btn" style="background: #cc1111">Purple</span></label>
    <label class="checkbox-color"><input type="radio" name="choose_54"><span class="btn" style="background: #f46311">Brown</span></label>
</div>
-->
