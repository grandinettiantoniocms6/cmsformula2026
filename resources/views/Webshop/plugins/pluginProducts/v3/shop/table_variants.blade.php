<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$options = null;
$figli_ids = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)->where("is_active", 1)->where("is_variant", 1)->get()->pluck("id")->toArray();
if(count($figli_ids)){
    $attribute_primary = \App\Models\ShopAttributes::orderBy("lft", "asc")->first();
    $options = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.*, shop_attributes_products.product_id")
        ->where("attribute_id", $attribute_primary->id)
        ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
        ->whereIn("product_id", $figli_ids)
        ->orderBy("value", "asc")
        ->groupBy("shop_attributes_options.id")
        ->get();

    $attribute_secondary = \App\Models\ShopAttributes::where("id", "!=", $attribute_primary->id)->orderBy("lft", "asc")->first();
}


$cart_class = new \App\Http\Controllers\CartController();
$my_cart = $cart_class->loading_cart(true);

$v_my_cart = [];
if(count($my_cart)){
    foreach ($my_cart as $mc){
        $v_my_cart[$mc->product_id] = $mc->qty;
    }
}

$cont = 0;
?>


@if($options)
    <form method="post" action="{{ route('add.cart.product.multiple') }}" class="product-variations">
        {{ csrf_field() }}

        <table class="table table-responsive table-sm">
            <thead>
            <tr>
                <th></th>
                @if(!$attribute_secondary)
                    <th></th>
                @else
                    <?php
                    $options_2 = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.*, shop_attributes_products.product_id")
                        ->where("attribute_id", $attribute_secondary->id)
                        ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                        ->whereIn("product_id", $figli_ids)
                        ->orderBy("value", "asc")
                        ->groupBy("shop_attributes_options.id")
                        ->get();
                    ?>
                    @if($options_2)
                        @foreach($options_2 as $option_2)
                            <th>{{ $option_2->value }}</th>
                        @endforeach
                    @endif
                @endif
            </tr>
            </thead>
            @foreach($options as $option)
                <tr>
                    <td><strong>{{ $option->value }}</strong></td>
                    @if(!$attribute_secondary)
                        <td><input type="number" class="form-control form-control-sm" min="1" max="20" value="0"></td>
                    @else
                        @if($options_2)
                            @foreach($options_2 as $option_2)
                                <?php
                                $options_ids = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_products.product_id")
                                    ->join("plugins_products", "plugins_products.id", "=", "shop_attributes_products.product_id")
                                    ->where("attribute_id", $attribute_primary->id)
                                    ->whereRaw("plugins_products.deleted_at IS NULL")
                                    ->whereIn("product_id", $figli_ids)
                                    ->where("option_id", $option->id)
                                    ->get()
                                    ->pluck("product_id")->toArray();

                                if(count($options_ids)){
                                    $item_p = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_products.product_id")
                                        ->where("attribute_id", $attribute_secondary->id)
                                        ->whereIn("product_id", $options_ids)
                                        ->where("option_id", $option_2->id)
                                        ->first();
                                }
                                ?>
                                @if($item_p)
                                    <td>
                                        <?php
                                        $value_qty = 0;
                                        if(key_exists($item_p->product_id, $v_my_cart)){
                                            $value_qty = $v_my_cart[$item_p->product_id];
                                            $cont++;
                                        }
                                        $variant_p = \App\Models\PluginProducts::find($item_p->product_id);
                                        $cover = $variant_p->getCover();
                                        ?>
                                        <img src="{{ $cover }}" width="20" height="20" class="text-center">
                                        <input type="number" name="variants_ids[{{ $item_p->product_id }}]" min="0" max="{{ $variant_p->qty }}" class="form-control form-control-sm form-control-variant" value="<?php echo $value_qty;?>">
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                        @endif
                    @endif
                </tr>
            @endforeach
        </table>
        <button class="btn btn-primary btn-lg w-100">{{ @$labels['shop-add-to-cart'] }}</button>
    </form>

    @if($cont > 0)
        <a href="{{ route('cart') }}" class="btn btn-secondary w-100 my-2"><span class="text">{{ @$labels['shop-varie-hai-nel-carrello'] }} {{ $cont }} {{ @$labels['shop-varie-prodotti-vai-carello'] }}</span></a>
    @endif
@endif
