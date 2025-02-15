<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\Page;
use App\Models\PluginProducts;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Slider;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Spatie\ArrayToXml\ArrayToXml;


class TrovaPrezziController extends Controller
{
    public function index(){
        $products = PluginProducts::where("is_active", 1)->get();
        /*if($products){
            foreach ($products as $product){
                $product->name = str_replace("&deg;", ".", $product->name);
                $product->name = str_replace("&Acirc;", "", $product->name);
                //$product->description = $product->getTranslation("description", "it");
                $product->description = $product->getTranslation("description_short", "it");

                $categoriesProd = $product->categories()->whereNotIn("id", [310])->get();
                if($categoriesProd){
                    foreach($categoriesProd as $category){
                        if($product->brand){
                            $product->url = route('detail', ["it",$category->slug, $product->brand->slug, $product->slug]);
                        }else{
                            $product->url = route('detail', ["it",$category->slug, "no-brand", $product->slug]);
                        }
                    }
                }


                if($categoriesProd){
                    if($categoriesProd){
                        $vcat = [];
                        foreach ($categoriesProd as $category){
                            $vcat[] = $category->name;
                            if($category->parent_id != 0){
                                $category1 = Category::find($category->parent_id);
                                $vcat[] = $category1->name;
                                if($category1->parent_id != 0){
                                    $category2 = Category::find($category1->parent_id);
                                    $vcat[] = $category2->name;
                                }
                            }
                        }

                        krsort($vcat);
                        $product->cat_tree = implode(" / ", $vcat);
                    }
                }

            }
        }

        return response()->view('xml.trovaprezzi', compact('products'))->header('Content-Type', 'text/xml');*/
    }
}
