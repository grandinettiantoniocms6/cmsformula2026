@if($products)
    @foreach($products as $product)
            <?php
            $vet_ids = [];

            $cat_prod_name = $productCategoryMap[$product->id]['name'] ?? "";
            $cat_prod_slug = $productCategoryMap[$product->id]['slug'] ?? "no-categoria";

            //$vet_ids = $product->get_vet_ids($shopSetting);
            $vet_ids = [];
            if ($product->vet_ids_list) {
                $vet_ids = json_decode($product->vet_ids_list, true);
            }
            ?>
        @include("Webshop.plugins.pluginProducts.v3.shop.box_product_grid", ['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, 'pluginSetting' => $plugin, "optionsList" => $optionsList, 'cartCompare' => $cartCompare, 'variantChildCounts' => $variantChildCounts, 'promoPriceByProductId' => $promoPriceByProductId])
    @endforeach

    <div id="box_pagination" class="w-100">
        {{ $products->links() }}
    </div>
@endif
