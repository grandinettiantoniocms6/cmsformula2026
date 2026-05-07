<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AdminLanguage;
use App\Models\AdminPlugin;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SitemapController extends Controller
{

    public function index(Request $r)
    {
        $pages = \DB::table("pages")->orderBy('id','desc')->where('is_active', 1)->get();

        $categories = null;
        $products = null;

        $adminPlugin = AdminPlugin::where("is_active", 1)->get();
        if($adminPlugin){
            foreach($adminPlugin as $aP){
                switch ($aP->name){
                    case "pluginProducts":
                        $categories = \DB::table("plugins_products_categories")
                            ->whereNull("deleted_at")
                            ->where("is_active", 1)
                            ->get();

                        $products = \DB::table("plugins_products")->where("is_active", 1)
                            ->where("is_variant", 0)
                            ->whereNull("deleted_at")
                            ->get();

                        break;
                }
            }
        }

        $langs = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get()->pluck("name", "name")->toArray();
        $urls = $this->buildUrls($pages, $categories, $products, $langs);

        return response()->view('sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml');

    }

    private function buildUrls($pages, $categories, $products, array $langs)
    {
        $urls = [];
        $activeLangs = array_values($langs);

        if($pages){
            foreach ($pages as $page){
                $slugs = json_decode($page->slug, true);

                if(!$slugs){
                    continue;
                }

                foreach($slugs as $lang => $slug){
                    if(!in_array($lang, $activeLangs)){
                        continue;
                    }

                    if(in_array($slug, (array) config('config.slug_shop_formula'))){
                        continue;
                    }

                    if(in_array($slug, (array) config('config.slug_plugin_booking'))){
                        continue;
                    }

                    $urls[] = [
                        'loc' => url($slug != "/" ? "/$slug" : "/"),
                        'lastmod' => $this->formatLastmod($page->updated_at ?: $page->created_at),
                    ];
                }
            }
        }

        if($categories){
            foreach ($categories as $category){
                $slugs = json_decode($category->slug, true);

                if(!$slugs){
                    continue;
                }

                foreach($slugs as $lang => $slug){
                    if(!in_array($lang, $activeLangs)){
                        continue;
                    }

                    $urls[] = [
                        'loc' => route("pluginProducts.".$lang, [$slug]),
                        'lastmod' => $this->formatLastmod($category->updated_at ?: $category->created_at),
                    ];
                }
            }
        }

        if($products){
            $categorySlugsByProduct = $this->getCategorySlugsByProduct($products);

            foreach ($products as $product){
                $slugs = json_decode($product->slug, true);

                if(!$slugs || !isset($categorySlugsByProduct[$product->id])){
                    continue;
                }

                $categorySlugs = $categorySlugsByProduct[$product->id];

                foreach($slugs as $lang => $slug){
                    if(!in_array($lang, $activeLangs)){
                        continue;
                    }

                    if(!is_array($categorySlugs) || !array_key_exists($lang, $categorySlugs)){
                        continue;
                    }

                    $urls[] = [
                        'loc' => route("pluginProducts.detail.".$lang, [$categorySlugs[$lang], $slug]),
                        'lastmod' => $this->formatLastmod($product->updated_at ?: $product->created_at),
                    ];
                }
            }
        }

        return $urls;
    }

    private function getCategorySlugsByProduct($products)
    {
        $productIds = $products->pluck('id')->toArray();

        if(!count($productIds)){
            return [];
        }

        $categories = \DB::table("plugins_products_categories_products")
            ->selectRaw("plugins_products_categories_products.plugin_product_product_id, plugins_products_categories.slug")
            ->join("plugins_products_categories", "plugins_products_categories.id", "=", "plugin_product_category_id")
            ->whereIn("plugin_product_product_id", $productIds)
            ->whereNull("plugins_products_categories.deleted_at")
            ->orderBy("plugins_products_categories_products.id")
            ->get();

        $categorySlugsByProduct = [];

        foreach($categories as $category){
            if(isset($categorySlugsByProduct[$category->plugin_product_product_id])){
                continue;
            }

            $categorySlugsByProduct[$category->plugin_product_product_id] = json_decode($category->slug, true);
        }

        return $categorySlugsByProduct;
    }

    private function formatLastmod($date)
    {
        if(!$date){
            return null;
        }

        return Carbon::parse($date)->toDateString();
    }
}

/*$slug = json_decode($category->slug, true); ?>
@if($langs)
@foreach($langs as $lang)
@if(key_exists($lang, $slug))
<!--<url>
    <loc>{{ route("pluginProducts.".$lang, [$slug[$lang]]) }}</loc>
    <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($category->updated_at)) }}</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.6</priority>
</url>-->
@endif
@endforeach
@endif*/
