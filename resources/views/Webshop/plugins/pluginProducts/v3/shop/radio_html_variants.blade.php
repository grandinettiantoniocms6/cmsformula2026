@if($attribute_item)
    @if(count($options))
        <label class="variation-label form-label">{{ $attribute_item->name }}:</label>

        <?php if($attribute_item->type_layout == 0){
            $type_layout = "checkbox-size";
        } else {
            $type_layout = "checkbox-color";
        } ?>

        <div class="product-form product-variations">
            @foreach($options as $option)
                <?php
                $variantProduct = \App\Models\PluginProducts::find($option->product_id);
                $cat_prod_name = "";
                $cat_prod_slug = "no-categoria";
                $cat_prod = $variantProduct->category();
                if($cat_prod){
                    $cat_prod_name = $cat_prod->name;
                    $cat_prod_slug = $cat_prod->slug;
                }
                ?>
                <label class="{{ $type_layout }}">
                    <input type="radio" name="second_attribute" value="{{ route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$variantProduct->slug]) }}" onchange="redirectVariant(this);">
                    <span class="btn" @if($option->background_color) style="background: {{ $option->background_color }}" @endif>{{ $option->value }}</span>
                </label>
            @endforeach
        </div>
    @else
        <label class="variation-label form-label">{{ $attribute_item->name }}:</label>
        <div class="product-form product-variations product-color">
             <span class="text text-danger">Nessuna disponibilità</span>
        </div>
    @endif
@endif
