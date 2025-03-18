<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if($pages)
        @foreach ($pages as $page)
            <?php
                $temp = json_decode($page->slug, true);
            ?>

            @if($temp)
                @foreach($temp as $k=>$slug)
                    <?php
                    if(!in_array($k, $langs)){
                        continue;
                    }
                    ?>

                    @if($slug != "/")
                        <?php
                        $slug = "/$slug";
                        ?>
                    @else
                        <?php
                        $slug = "/";
                        ?>
                    @endif

                        <?php
                        if(in_array($slug, config('config.slug_shop_formula'))){
                            continue;
                        }
                        if(in_array($slug, config('config.slug_plugin_booking'))){
                            continue;
                        }
                        ?>

                    <url>
                        <loc>{{ url($slug) }}</loc>
                        <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime(\Carbon\Carbon::now()->toDateTimeString())) }}</lastmod>
                        <changefreq>daily</changefreq>
                        <priority>1.0</priority>
                    </url>
                @endforeach
            @endif
        @endforeach
    @endif

    @if($categories)
        @foreach ($categories as $category)
                <?php
                $temp = json_decode($category->slug, true);
                ?>

                @if($temp)
                    @foreach($temp as $k=>$slug)
                        <?php
                        if(!in_array($k, $langs)){
                            continue;
                        }
                        ?>
                        <url>
                            <loc>{{ route("pluginProducts.".$k, [$slug]) }}</loc>
                            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime(\Carbon\Carbon::now()->toDateTimeString())) }}</lastmod>
                            <changefreq>daily</changefreq>
                            <priority>1.0</priority>
                        </url>
                    @endforeach
                @endif

        @endforeach
    @endif

        @if($products)
            @foreach ($products as $product)
                <?php
                $temp = json_decode($product->slug, true);

                $cat_prod_slug = "no-categoria";

                $itemProd = \App\Models\PluginProducts::find($product->id);
               /* if($itemProd->is_active == 0){
                    continue;
                }*/

                $cat_prod = null;
                $first_cat = \DB::table("plugins_products_categories_products")->where("plugin_product_product_id", $product->id)->first();
                if($first_cat){
                    $cat_prod = \DB::table("plugins_products_categories")->where("id", $first_cat->plugin_product_category_id)->first();
                }

                if($cat_prod){
                    $temp_cat_slug = json_decode($cat_prod->slug, true);
                    $cat_prod_slug = $temp_cat_slug;
                }
               ?>

                @if($temp)
                    @foreach($temp as $k=>$slug)
                        <?php
                        if(!in_array($k, $langs)){
                            continue;
                        }

                        if($cat_prod_slug == null){
                            continue;
                        }

                        if(is_array($cat_prod_slug)){
                            if(!key_exists($k, $cat_prod_slug)){
                                continue;
                            }
                        }else{
                            continue;
                        }

                        ?>
                        <url>
                            <loc>{{ route("pluginProducts.detail.".$k, [$cat_prod_slug[$k], $slug]) }}</loc>
                            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime(\Carbon\Carbon::now()->toDateTimeString())) }}</lastmod>
                            <changefreq>daily</changefreq>
                            <priority>1.0</priority>
                        </url>
                    @endforeach
                @endif
            @endforeach
        @endif

</urlset>
