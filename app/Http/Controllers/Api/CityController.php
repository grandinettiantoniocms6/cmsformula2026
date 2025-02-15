<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Backpack\NewsCRUD\app\Models\Category;

class CityController extends Controller
{
    public function cities(Request $request)
    {
        $search_term = $request->input('q');
        if ($search_term)
        {
            $results = City::whereRaw("(nome_comune LIKE '%$search_term%')")
                ->paginate(10);
        }
        else
        {
            $results = City::paginate(10);
        }

        return $results;
    }


    public function show($id)
    {
        return City::find($id);
    }
}