<?php
$shopSetting = \App\Models\ShopSettings::first();
$pluginSetting = \App\Models\PluginProductsSettings::first();
$optionsList = \App\Models\ShopAttributesOptions::pluck("icon", "id")->toArray();
?>
@if($plugin->show_related_products == 1)
    @if(count($itemProduct->related) > 0)
        <?php
        $item = 1;
        $loop = false;
        if(count($itemProduct->related) > 4){
            $item = 5;
            $loop = true;
        }
        ?>
        <div class="related-products">
            <div class="container">
                <h3 class="text-center h4 mb-4">{{ @$labels['accessori'] }}</h3>
                <div id="related-products" class="owl-carousel owl-theme"
                     data-toggle='owlcarousel'
                     data-margin='[10,10,10,10,10,10,10]'
                     data-autowidth='[false,false,false,false,false,false,false]'
                     data-autoplay='[true,3000]'
                     data-loop="{{ $loop }}"
                     data-responsive='[1,2,2,2,3,4,4]'
                     data-dots='[true, true, true, true, true, true, true]'
                     data-nav='[false, false, false, false, false, false, false]'
                >
                    @foreach($itemProduct->related as $related)
                        @if($related->product)
                            <?php
                            $product = $related->product;
                            $vet_ids = [];

                            $cat_prod_name = "";
                            $cat_prod_slug = "no-categoria";
                            $cat_prod = $product->category();
                            if($cat_prod){
                                $cat_prod_name = $cat_prod->name;
                                $cat_prod_slug = $cat_prod->slug;
                            }
                            $vet_ids = $product->get_vet_ids($shopSetting);
                            ?>

                            @include("$thema.plugins.pluginProducts.v3.shop.box_product_grid", ['shopSetting' => $shopSetting, "optionsList" => $optionsList])
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif
