<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AdminLanguage;
use App\Models\AdminPlugin;
use App\Models\Page;
use App\Models\PluginProducts;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use Illuminate\Http\Request;


class SitemapController extends Controller
{

    public function index(Request $r)
    {
        $pages = \DB::table("pages")->orderBy('id','desc')->where('is_active', 1)->get();

        $categories = null;
        $products = null;
        $tags = null;

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

                        $tags = [];
                        if($products){
                            foreach ($products as $product){
                                $itemTags = explode(",", $product->tags);
                                if(count($itemTags)){
                                    foreach ($itemTags as $item){
                                        if(trim($item) != ""){
                                            $tags[] = trim($item);
                                        }
                                    }
                                }
                            }
                        }
                        $tags = array_unique($tags);
                        break;
                }
            }
        }

        $langs = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get()->pluck("name", "name")->toArray();

        return response()->view('sitemap', compact('pages', 'categories', 'products','tags', 'langs'))
            ->header('Content-Type', 'text/xml');

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
