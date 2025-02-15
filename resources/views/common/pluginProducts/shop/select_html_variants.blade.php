@if($attribute_item)
    <?php
   $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
   ?>
<div class="product-form product-variations product-color">
    <label class="form-label">{{ $attribute_item->name }}:</label>
    <div class="select-box">
        <select name="second_attribute" class="form-control" onchange="redirectVariant(this);">
            <option value="" selected="selected">{{ @$labels['shop-seleziona'] }}</option>
            @foreach($options as $option)
                <?php
                $variantProduct = \App\Models\PluginProducts::find($option->product_id);
                $cat_prod_name = "";
                $cat_prod_slug = "no-categoria";

                if($variantProduct){
                    $cat_prod = $variantProduct->category();
                    if($cat_prod){
                        $cat_prod_name = $cat_prod->name;
                        $cat_prod_slug = $cat_prod->slug;
                    }
                }
                ?>
                <option value="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$variantProduct->slug]) }}">{{ $option->value }}</option>
            @endforeach
        </select>
    </div>
</div>
@endif
