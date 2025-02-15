<?php

namespace App\Http\Controllers\Api;

use App\Models\PluginProducts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');
        if ($search_term)
        {
            $results = PluginProducts::whereRaw("(name LIKE '%$search_term%' OR sku LIKE '%$search_term%')")
                ->paginate(10);
        }
        else
        {
            $results = PluginProducts::paginate(10);
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
                'name' => "$name ($product->sku)",
            ];
        });
        return $results;
    }


    public function show($id)
    {
        return PluginProducts::find($id);
    }
}
