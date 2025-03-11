<?php
$shopSetting = \App\Models\ShopSettings::first();
$pluginSetting = \App\Models\PluginProductsSettings::first();
?>
@if($plugin->show_related_products == 1)
    @if(count($itemProduct->related) > 0)
        <?php
        $item = 1;
        if(count($itemProduct->related) > 4){
            $item = 5;
        }
        ?>
        <section class="pt-3 mt-10">
            <h2 class="title justify-content-center">{{ @$labels['accessori'] }}</h2>

            <div class="owl-carousel owl-theme owl-carousel-shop owl-nav-full row cols-2 cols-md-3 cols-lg-4"
                 data-owl-options="{
							'items': {{ $item }},
							'nav': false,
							'loop': false,
							'dots': true,
							'margin': 20,
							'responsive': {
								'0': {
									'items': 2
								},
								'768': {
									'items': 3
								},
								'992': {
									'items': 4,
									'dots': false,
									'nav': true
								}
							}
						}">

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
                          // $vet_ids = $product->get_vet_ids($shopSetting);

                            $vet_ids = [];
                            if($product->vet_ids_list){
                                $vet_ids = json_decode($product->vet_ids_list, true);
                            }
                        ?>

                        @include('common.pluginProducts.shop.box_product_grid', ['shopSetting' => $shopSetting])
                    @endif
                @endforeach
            </div>
        </section>
    @endif
@endif
