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

        //prendo il primo attribute in ordine
        $attribute_first = \App\Models\ShopAttributes::orderBy("lft", "asc")->first();

        //prendo ids varianti
        $variants_ids = \App\Models\PluginProducts::where("group_id", $product->group_id)
            ->where("is_variant", 1)
            ->where("is_active", 1)
            ->get()->pluck("id")
            ->toArray();

        if(count($variants_ids)){
            $temp_ids = \App\Models\PluginProducts::selectRaw("count(*) as tot, code_article, group_concat(id) as ids")
                ->whereIn("id", $variants_ids)
                ->orderBy("code_article", "ASC")
                ->groupBy("code_article")
                ->get();


            $v_final = [];
            foreach($temp_ids as $pp){


                $vet_ids = \App\Models\ShopAttributesProducts::selectRaw("GROUP_CONCAT(product_id) as ids, option_id")->whereRaw("product_id IN ($pp->ids)")
                    ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                    ->where("attribute_id", $attribute_first->id)
                    ->orderBy("shop_attributes_options.value", "asc")
                    ->groupBy("option_id")
                    ->get()
                    ->pluck("ids", "option_id")
                    ->toArray();

                $vet_ids_final = [];
                if($vet_ids){
                    foreach ($vet_ids as $k=>$v){
                        //tra gli ids quali ha attribute_shop_id 2 con valore inferiore alfabeticamente?
                        $temp_option = \App\Models\ShopAttributesOptions::find($k);
                        $temp_v = explode(",", $v);

                        $options_p = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_products.product_id")
                            ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                            ->whereIn("product_id", $temp_v)
                            ->where("attribute_id", 2)
                            ->orderBy("shop_attributes_options.value", "asc")
                            ->first();

                        if($options_p){
                            $vet_ids[$k] = $options_p->product_id;
                        }

                    }
                }

                if($vet_ids){
                    foreach ($vet_ids as $idF){
                        $v_final[] = $idF;
                    }
                }
            }
            $vet_ids = $v_final;
        }
        ?>
        @include('common.pluginProducts.shop.box_product_grid')
    @endforeach

    <nav class="toolbox toolbox-pagination" id="box_pagination">
        {{ $products->links() }}
    </nav>
@endif
