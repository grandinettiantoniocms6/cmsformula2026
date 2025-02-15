<?php $plugin = \App\Models\PluginProductsSettings::first(); ?>
<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$title = json_decode($item->title, true);
$description = json_decode($item->description, true);
$shopSetting = \App\Models\ShopSettings::first();
$website = \App\Models\WebsiteSetting::first();
?>

<section class="shop grid page-section-ptb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <h5>{{ $title[\App::getLocale()] }}</h5>
                {!! $description[\App::getLocale()] !!}

                    @if($array)
                        @foreach($array as $value)

                        <div class="isotope columns-3">

                            <?php
                                if($value->category_id){
                                    $category = \App\Models\PluginProductsCategories::where("id", $value->category_id)->first();
                                    $category_slug = $category->slug;

                                    if($value->is_random){
                                        $products = \App\Models\PluginProducts::selectRaw("plugins_products.*")
                                            ->join("plugins_products_categories_products", "plugins_products_categories_products.plugin_product_product_id", "=", "plugins_products.id")
                                            ->where("plugins_products_categories_products.plugin_product_category_id", $value->category_id)
                                            ->where("is_active", 1)
                                            ->inRandomOrder()
                                            ->take($value->number_max)
                                            ->get();

                                    }else{
                                        $products = \App\Models\PluginProducts::selectRaw("plugins_products.*")
                                            ->join("plugins_products_categories_products", "plugins_products_categories_products.plugin_product_product_id", "=", "plugins_products.id")
                                            ->where("plugins_products_categories_products.plugin_product_category_id", $value->category_id)
                                            ->where("is_active", 1)->take($value->number_max)->get();
                                    }

                                }else{
                                    $category = null;
                                    $category_slug = null;
                                    if($value->is_random){
                                        $products = \App\Models\PluginProducts::where("is_active", 1)->inRandomOrder()->take($value->number_max)->get();
                                    }else{
                                        $products = \App\Models\PluginProducts::where("is_active", 1)->take($value->number_max)->get();
                                    }
                                }
                            ?>
                            @if($products)
                                <?php $now = \Carbon\Carbon::now(); ?>
                                @foreach($products as $product)
                                    <?php
                                        $check = \App\Models\PluginProductsImages::where("product_id", $product->id)->orderBy("order", "asc")->first();
                                        $product->cover = null;
                                        if($check){
                                            if(is_numeric(strpos($check->image, "uploads"))){
                                                $url = url("$check->image");
                                            }else{
                                                $url = url("uploads/products/$check->image");
                                            }

                                            $product->cover = $url;
                                        }

                                        $product->in_promo = 0;
                                        if($product->data_promo_end){
                                            $data_end = \Carbon\Carbon::createFromFormat("Y-m-d", $product->data_promo_end);
                                            if($now->lte($data_end)){
                                                $product->in_promo = 1;
                                            }
                                        }else{
                                            if($product->promo_price < $product->price){
                                                $product->in_promo = 1;
                                            }
                                        }
                                    ?>

                                    <div class="grid-item">

                                        <?php
                                        $vet_ids = [];

                                        $cat_prod_name = "";
                                        $cat_prod_slug = "no-categoria";
                                        $cat_prod = $product->category();
                                        if($cat_prod){
                                            $cat_prod_name = $cat_prod->name;
                                            $cat_prod_slug = $cat_prod->slug;
                                        }

                                        $product->cover = $product->getCover();
                                        ?>
                                        @include('common.pluginProducts.shop.box_product_grid')

                                    </div>
                                @endforeach
                            @endif

                        @endforeach
                    @endif

                </div>

                <div class="row">
                    <a class="btn btn-primary" href="{{ route("pluginProducts.".\App::getLocale(), [$category_slug]) }}">{{ @$labels['vedi-tutti'] }}</a>
                </div>

            </div>
        </div>
    </div>
</section>
