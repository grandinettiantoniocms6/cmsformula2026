<?php
$optionsList = \App\Models\ShopAttributesOptions::pluck("icon", "id")->toArray();
?>
@if($products)
    @foreach($products as $product)
        <?php
        $vet_ids = [];

        $cat_prod_name = "";
        $cat_prod_slug = "no-categoria";
        $cat_prod = $product->category();
        if($cat_prod){
            $cat_prod_name = $cat_prod->name;
            $cat_prod_slug = $cat_prod->slug;
        }

        //$vet_ids = $product->get_vet_ids($shopSetting);
            $vet_ids = [];
            if($product->vet_ids_list){
                $vet_ids = json_decode($product->vet_ids_list, true);
            }
        ?>
        @include("Webshop.plugins.pluginProducts.v3.shop.box_product_grid", ['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, 'pluginSetting' => $plugin, "optionsList" => $optionsList])
    @endforeach

    <div id="box_pagination" class="w-100">
        {{ $products->links() }}
    </div>
@endif
