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
       $options = \App\Models\ShopAttributesOptions::selectRaw("shop_attributes_options.value,shop_attributes_products.id")
           ->join("shop_attributes_products", "shop_attributes_options.id", "shop_attributes_products.option_id")
           ->where("attribute_id", $attribute_item->id)
           ->whereIn("product_id", $figli_ids)
           ->orderBy("shop_attributes_options.ordine", "asc")
           ->groupBy("value")
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
    <div class="product-variations">
        <label class="form-label">{{ $attribute_item->name }}: </label>
        <div class="select-box">
            <select name="first_attribute" class="form-select" id="first_attribute">
                <option value="" selected="selected">{{ @$labels['shop-seleziona'] }}</option>
                @foreach($options as $option)
                    @if($option_selected == $option->value)
                        <option value="{{ $option->id }}" selected>{{ $option->value }}</option>
                    @else
                        <option value="{{ $option->id }}">{{ $option->value }}</option>
                    @endif
                @endforeach
            </select>
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
                    $options = \App\Models\ShopAttributesOptions::selectRaw("shop_attributes_options.*, shop_attributes_products.product_id")
                        ->join("shop_attributes_products", "shop_attributes_options.id", "shop_attributes_products.option_id")
                        ->where("attribute_id", $attribute_item->id)
                        ->whereIn("product_id", $ids)
                        ->groupBy("value")
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
                <div class="product-variations">
                    <label class="form-label">{{ $attribute_item->name }}:</label>
                    <div class="select-box">
                        <select name="second_attribute" class="form-select" onchange="redirectVariant(this);">
                            @foreach($options as $option)
                                <?php
                                $variantProduct = \App\Models\PluginProducts::find($option->product_id);
                                if(!$variantProduct){
                                    continue;
                                }

                                $vat = $variantProduct->tax ? $variantProduct->tax->value : 22;
                                $vat_calculate = ($vat / 100) + 1;

                                $cat_prod_name = "";
                                $cat_prod_slug = "no-categoria";
                                $cat_prod = $variantProduct->category();
                                if($cat_prod){
                                    $cat_prod_name = $cat_prod->name;
                                    $cat_prod_slug = $cat_prod->slug;
                                }
                                ?>
                                @if($option_selected_2 == $option->id)
                                     <option value="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$variantProduct->slug]) }}" selected>{{ $option->value }}
                                         @if($option->price)
                                             @if(env('VIEW_WITH_IVA') == 1)
                                                 (+{{ number_format($option->price * $vat_calculate, 2, ",", ".") }} &euro;)
                                             @else
                                                 (+{{ number_format($option->price, 2, ",", ".") }} &euro;)
                                             @endif
                                         @endif
                                     </option>
                                @else
                                     <option value="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$variantProduct->slug]) }}">{{ $option->value }}
                                         @if($option->price)
                                             @if(env('VIEW_WITH_IVA') == 1)
                                                 (+{{ number_format($option->price * $vat_calculate, 2, ",", ".") }} &euro;)
                                             @else
                                                 (+{{ number_format($option->price, 2, ",", ".") }} &euro;)
                                             @endif
                                         @endif
                                     </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

        @endif
    </div>
@endif


