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
    $options = \App\Models\ShopAttributesOptions::selectRaw("shop_attributes_options.icon, shop_attributes_options.id as option_id, shop_attributes_options.value, shop_attributes_options.background_color, shop_attributes_products.id")
        ->join("shop_attributes_products", "shop_attributes_options.id", "shop_attributes_products.option_id")
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

    $variant_option = \App\Models\ShopAttributesOptions::selectRaw("shop_attributes_options.*, shop_attributes_products.id")
        ->join("shop_attributes_products", "shop_attributes_options.id", "shop_attributes_products.option_id")
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

    <div class="product-variations">
        <div class="variation-list">
            <div class="row gx-1">
                @if($options)
                    @foreach($options as $option)
                            <?php
                            //background_color
                            if($option->type_layout == 0){
                                $type_layout = "checkbox-size";
                            }else{
                                $type_layout = "checkbox-color";
                            }

                            $IconImage = null;
                            if($option->icon){
                                $IconImage = $option->icon;
                            }

                            $itemProductVariant = \App\Models\PluginProducts::find($option->id);
                            if($itemProductVariant) {
                                $cat_prod_slug = "no-categoria";
                                $cat_prod = $itemProductVariant->category();
                                if ($cat_prod) {
                                    $cat_prod_slug = $cat_prod->slug;
                                }
                            }

                            $url = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$itemProductVariant->slug]);
                            $checked = "";
                            if($option_selected == $option->value){
                                $checked = "checked";
                            }
                            ?>
                        <div class="mb-1">

                            {{ $checked }}
                            <a class="card card-variant mb-2 " title="{{ $option->value }}" href="{{ $url }}">
                                <div class="row no-gutters">
                                    @if($IconImage)
                                        <div class="col-auto">
                                            <div class="px-3 py-2">
                                                <img width="50" height="50" class="img-fluid" src="{{ url($IconImage) }}" alt="{{ $option->value }}">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col border-left bg-light d-flex flex-column px-3 py-2">
                                        <div class="fw-bold text-uppercase">{{ $option->value }}</div>
                                        <div class="small text-dark">Contattaci</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endif
