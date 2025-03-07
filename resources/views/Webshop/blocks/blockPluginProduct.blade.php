<?php $pluginSetting = \App\Models\PluginProductsSettings::first(); ?>
<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$shopSetting = \App\Models\ShopSettings::first();
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$optionsList = \App\Models\ShopAttributesOptions::pluck("icon", "id")->toArray();

$title = json_decode($item->title, true);
$description = json_decode($item->description, true);
?>

<section class="block-products" id="block-products-{{ $item->id }}">
    <div class="container">
        <div class="text-center">
            @if($title)<h3 class="title">{{ $title[\App::getLocale()] }}</h3>@endif
            @if($description)<div class="description">{!! $description[\App::getLocale()] !!}</div>@endif
        </div>

        @if($array)
            @foreach($array as $value)
                <div class="products-grid grid-view row row-cols-2 row-cols-sm-2 row-cols-md-{{ $value->col_span }}">
                    <?php
                    if($value->category_id){
                        $category = \App\Models\PluginProductsCategories::where("id", $value->category_id)->first();
                        $category_slug = $category->slug;

                        if($value->is_random){
                            $products = \App\Models\PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
                                ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
                                ->join("plugins_products_categories_products", "plugins_products_categories_products.plugin_product_product_id", "=", "plugins_products.id")
                                ->where("plugins_products_categories_products.plugin_product_category_id", $value->category_id)
                                ->where("plugins_products.is_active", 1)
                                ->inRandomOrder()
                                ->take($value->number_max)
                                ->get();

                        }else{
                            $products = \App\Models\PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
                                ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
                                ->join("plugins_products_categories_products", "plugins_products_categories_products.plugin_product_product_id", "=", "plugins_products.id")
                                ->where("plugins_products_categories_products.plugin_product_category_id", $value->category_id)
                                ->where("plugins_products.is_active", 1)->take($value->number_max)->get();
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
                        <?php $now = \Carbon\Carbon::now();
                        ?>
                        @foreach($products as $product)
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
                                $vet_ids = [];
                                if($product->vet_ids_list){
                                    $vet_ids = json_decode($product->vet_ids_list, true);
                                }
                                ?>
                                @include("Webshop.plugins.pluginProducts.v3.shop.box_product_grid",['adminPlugin' => $adminPlugin, 'shopSetting' => $shopSetting, "optionsList" => $optionsList])
                            </div>
                        @endforeach
                    @endif

                </div>
                <a class="btn btn-primary mb-4" href="{{ route("pluginProducts.".\App::getLocale(), [$category_slug]) }}">{{ @$labels['vedi-tutti'] }}</a>
            @endforeach
        @endif
    </div>
</section>
