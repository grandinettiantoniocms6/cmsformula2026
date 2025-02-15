<?php

namespace App\Http\Controllers\Api;

use App\Models\PluginProductsCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Backpack\NewsCRUD\app\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = PluginProductsCategories::where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = PluginProductsCategories::paginate(10);
        }

        $results->getCollection()->transform(function($product, $key) {
            $name = $product->name;
            $temp = json_decode($product->name, true);
            if($temp){
                if(count($temp)){
                    if(key_exists("it", $temp))
                        $name = $temp['it'];
                }
            }

            return [
                'id' => $product->id,
                'name' => "$name",
            ];
        });

        return $results;
    }

    public function show($id)
    {
        return PluginProductsCategories::find($id);
    }
}
