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


class XmlController extends Controller
{
    public function facebook(){
        $products = PluginProducts::where("is_active", 1)->where("qty", ">", 0)->where("is_variant", 0)->get();

        return response()->view('common.xml.facebook', compact('products'))->header('Content-Type', 'text/xml');

    }
}
