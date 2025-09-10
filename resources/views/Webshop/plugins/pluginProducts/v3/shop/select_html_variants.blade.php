@if($attribute_item)
    <?php
    $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
    ?>
<div class="product-variations">
    <label class="form-label">{{ $attribute_item->name }}:</label>
    <select name="second_attribute" class="form-select" onchange="redirectVariant(this);">
        <option value="" selected="selected">{{ @$labels['shop-seleziona'] }}</option>
        @foreach($options as $option)
            <?php
            $variantProduct = \App\Models\PluginProducts::find($option->product_id);
            if(!$variantProduct){
                continue;
            }

            $cat_prod_name = "";
            $cat_prod_slug = "no-categoria";

            $vat = $variantProduct->tax ? $variantProduct->tax->value : 22;
            $vat_calculate = ($vat / 100) + 1;

            if($variantProduct){
                $cat_prod = $variantProduct->category();
                if($cat_prod){
                    $cat_prod_name = $cat_prod->name;
                    $cat_prod_slug = $cat_prod->slug;
                }
            }
            ?>
            <option value="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$variantProduct->slug]) }}">
                {{ $option->value }}
                @if($option->price)
                    @if(env('VIEW_WITH_IVA') == 1)
                        (+{{ number_format($option->price * $vat_calculate, 2, ",", ".") }} &euro;)
                    @else
                        (+{{ number_format($option->price, 2, ",", ".") }} &euro;)
                    @endif
                @endif
            </option>
        @endforeach
    </select>
</div>
@endif
