<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Address;
use App\Models\AreaCity;
use App\Models\AreaCountry;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartRule;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\ExtraCost;
use App\Models\GiftCard;
use App\Models\GiftCardHistory;
use App\Models\Order;
use App\Models\OrderExtraCost;
use App\Models\OrderProduct;
use App\Models\Page;
use App\Models\Payment;
use App\Models\PluginProducts;
use App\Models\PluginProductsQuantities;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Shipping;
use App\Models\ShippingRange;
use App\Models\ShopCartExtra;
use App\Models\ShopExtra;
use App\Models\ShopOrderProductExtra;
use App\Models\ShopSettings;
use App\Models\Slider;
use App\Models\SpecificPrice;
use App\Models\UserSubscription;
use App\Models\WebsiteSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class CartController extends Controller
{
    public $theme;

    public function __construct()
    {
        $this->theme = env('TEMA');
    }

    public function cart(){
        $index = new IndexController();
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();

        $slug = "cart";
        $page = $index->check_page($slug);
        if(is_string($page)){
            return redirect()->to($page);
        }

        $cart = $this->loading_cart(true);

        $blockButton = 0;
        /*$contSub = 0;
        foreach ($cart as $item){
            $product = PluginProducts::find($item->product_id);
            if($product){
                if($product->is_subscription){
                    $contSub++;
                }
            }
        }

        if($contSub == count($cart)){
            if($contSub > 1){
                $blockButton = 1;
            }
        }*/

        return view("cart", compact("menu","page", "website", "cart", "blockButton"));
    }

    public function checkout(){
        $index = new IndexController();
        $slug = "checkout";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);

        if(is_string($page)){
            return redirect()->to($page);
        }

        $cart = $this->loading_cart(true);
        if(count($cart) == 0){
            return redirect()->route("cart");
        }

        $countries = Country::orderBy("name")->get();
        $cities = City::orderBy("sigla_provincia", "asc")->groupBy("sigla_provincia")->get();

        $user = null;
        if(\Session::has('user_id')){
            \Session::forget('redirect_to_checkout');
            $user = User::with("addresses", "companies")->find(\Session::get('user_id'));
        }else{
            \Session::put('redirect_to_checkout');
        }

        $categories = null;

        $categories_orizz = null;
        $payments = Payment::orderBy("order", "ASC")->get();
        $hasContrassegno = Payment::where("is_contrassegno", 1)->count();

        $onlySubscriptions = 0;
        $contSub = 0;
        foreach ($cart as $item){
            $product = PluginProducts::find($item->product_id);
            if($product){
                if($product->is_subscription){
                    $contSub = $contSub + $item->qty;
                }
            }
        }

        if($contSub == count($cart)){
            $onlySubscriptions = 1;

            if($contSub > 1){
                return redirect()->route('cart');
            }
        }

        return view("checkout", compact("menu","page", "website", "cart", 'countries','cities','user','categories_orizz','payments','hasContrassegno', 'onlySubscriptions','contSub'));
    }

    public function remove_cart_list(Request $request){
        $this->remove_cart($request);
        return redirect()->back();
    }

    public function add_to_cart_from_product_multiple(Request $request){
        $variants_ids = $request->get('variants_ids');

        $add_cart = 0;
        if(count($variants_ids)){
            foreach ($variants_ids as $id => $qty){
                if($qty == 0){
                    continue;
                }

                $product = PluginProducts::find($id);
                if($product){
                    //nel carrello deve andare sempre il prezzo IVATO
                    $finalPrice = $product->get_promo_price(true);

                    if(\Session::has('user_id')){
                        $check = Cart::where("product_id", $id)
                            ->where("user_id", \Session::get('user_id'))
                            ->first();
                        if(!$check){
                            Cart::create([
                                "product_id" => $id,
                                "user_id" => \Session::get('user_id'),
                                "price" => round($finalPrice,2),
                                "qty" => $qty,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }else{
                            Cart::where("product_id", $id)->where("user_id", \Session::get('user_id'))->update([
                                "price" => round($finalPrice,2),
                                "qty" => $qty
                            ]);
                        }
                    }else{
                        $v_ = [];
                        $in_cart = \Session::get("cart.products");

                        if(is_array($in_cart)){
                            if(count($in_cart)){
                                foreach ($in_cart as $c){
                                    $v_[] = $c->product_id;
                                }
                            }
                        }

                        //da non loggato vedere se nel multicarrello aggiorna la qta inserita
                        if(!in_array($id, $v_)){
                            $obj = new \stdClass();
                            $obj->product_id = $id;
                            $obj->product_name = $product->name;
                            $obj->qty = $qty;
                            $obj->price = round($finalPrice,2);
                            \Session::push("cart.products", $obj);
                        }
                    }

                    $add_cart++;
                }
            }
        }

        if($add_cart > 0){
            return redirect()->back()->with('message', "_");
        }

        return redirect()->back()->with('error', "_");
    }

    public function add_to_cart_from_product_search(Request $request){
        $this->add_cart($request);

        return redirect()->route("cart");

        //return redirect()->back()->with('message-autocomplete', "_");
    }

    public function add_to_cart_from_product(Request $request){
        $this->add_cart($request);

        $cart = $this->loading_cart(true);

        if($request->has('modal')){
            return response()->json([
               "ok" => 1,
               "count" => count($cart)
            ]);
        }

        return redirect()->route("cart");

        //return redirect()->back()->with('message', "_");
    }

    public function add_cart(Request $request){
        $shopSetting = ShopSettings::first();

        $product = PluginProducts::find($request->input('id'));
        if($product){
            //nel carrello deve andare sempre il prezzo IVATO
            $finalPrice = $product->get_promo_price(true);

            if($request->has('extra')){
                $extra = $request->get('extra');
                foreach ($extra as $extra_id => $value){
                   if($value !== null && trim($value) != ""){
                       $shopExtra = ShopExtra::find($extra_id);
                       if($shopExtra){
                           $finalPrice += $shopExtra->price;
                       }
                   }
                }
            }

            $qty = 1;
            if($request->has('qty')){
                $qty = (int) $request->get('qty');
            }

            if($qty > $product->qty){
                $qty = $product->qty;
            }

            //------------------PRODUCT QUANTITY
            $products_quantities = PluginProductsQuantities::where("plugin_product_id", $product->id)
                ->where("quantity_min", "<=", $qty)
                ->orderBy("quantity_min", "DESC")
                ->first();
            if($products_quantities && $shopSetting->is_qta_minima){
                $vat = $product->tax ? $product->tax->value : 22;
                $vat_calculate = ($vat / 100) + 1;

                $finalPrice = $products_quantities->price * $vat_calculate;
            }

            if(\Session::has('user_id')){
                $check = Cart::where("product_id", $request->input('id'))
                    ->where("user_id", \Session::get('user_id'))
                    ->first();
                if(!$check){
                    $cart = Cart::create([
                        "product_id" => $request->input('id'),
                        "user_id" => \Session::get('user_id'),
                        "price" => round($finalPrice,3),
                        "qty" => $qty,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    if($request->has('extra')){
                        $extra = $request->get('extra');
                        foreach ($extra as $extra_id => $value){
                            if($value !== null && trim($value) != "") {
                                ShopCartExtra::create([
                                    "cart_id" => $cart->id,
                                    "extra_id" => $extra_id,
                                    "value" => $value
                                ]);
                            }
                        }
                    }

                }
            }else{
                $v_ = [];
                $in_cart = \Session::get("cart.products");

                if(is_array($in_cart)){
                    if(count($in_cart)){
                        foreach ($in_cart as $c){
                            $v_[] = $c->product_id;
                        }
                    }
                }

                if(!in_array($request->input('id'), $v_)){
                    $obj = new \stdClass();
                    $obj->product_id = $request->input('id');
                    $obj->product_name = $product->name;
                    $obj->qty = $qty;
                    $obj->price = round($finalPrice,3);

                    if($request->has('extra')){
                        $extra = $request->get('extra');
                        foreach ($extra as $extra_id => $value){
                            if($value == null || trim($value) == "") {
                                  unset($extra[$extra_id]);
                            }
                        }

                        $obj->extra = $extra;
                    }

                    \Session::push("cart.products", $obj);
                }
            }

        }
    }

    public function loading_cart($getArray = null){
        $cart = [];
        if(\Session::has('user_id')){
            $result = Cart::where("user_id", \Session::get('user_id'))->get();
            if($result){
                foreach($result as $item){
                    $product = PluginProducts::find($item->product_id);
                    if(!$product){
                        continue;
                    }
                    $obj = new \stdClass();
                    $obj->product_id = $product->id;
                    $obj->product_name = $product->name;
                    $obj->qty = $item->qty;
                    $obj->price = $item->price;

                    $obj->extra = ShopCartExtra::where("cart_id", $item->id)->get()->pluck("value", "extra_id")->toArray();

                    $cart[] = $obj;
                }
            }
        }else{
            if(\Session::has('cart')){
                $cart = \Session::get('cart.products');
            }
        }

        if($getArray){
            return $cart;
        }
    }

    public function update_cart(Request $request){
        $shopSetting = ShopSettings::first();

        $cart = $this->loading_cart(true);
        $quantities = $request->get('quantity');
        if($cart){
            foreach ($cart as $product){
                $product_item = PluginProducts::find($product->product_id);
                if($product_item){
                    //nel carrello deve andare sempre il prezzo IVATO
                    $finalPrice = $product_item->get_promo_price(true);

                    //------------------PRODUCT QUANTITY
                    $products_quantities = PluginProductsQuantities::where("plugin_product_id", $product_item->id)
                        ->where("quantity_min", "<=", $quantities)
                        ->orderBy("quantity_min", "DESC")
                        ->first();
                    if($products_quantities && $shopSetting->is_qta_minima){
                        $vat = $product_item->tax ? $product_item->tax->value : 22;
                        $vat_calculate = ($vat / 100) + 1;

                        $finalPrice = $products_quantities->price * $vat_calculate;
                    }

                    if(key_exists($product->product_id, $quantities)){
                        $product->qty = $quantities[$product->product_id];
                        $product->price = $finalPrice;
                    }

                    if(\Session::has('user_id')){
                        if(key_exists($product->product_id, $quantities)){
                            $check = Cart::where("product_id", $product->product_id)
                                ->where("user_id", \Session::get('user_id'))
                                ->first();
                            if($check){
                                $item = PluginProducts::find($product->product_id);
                                if($quantities[$product->product_id] > $item->qty){
                                    $check->qty = $item->qty;
                                }else{
                                    $check->qty = $quantities[$product->product_id];
                                }
                                $check->save();
                            }
                        }
                    }
                }
            }
            if(!\Session::has('user_id')) {
                \Session::put("cart.products", $cart);
            }
        }
        return redirect()->back();
    }

    public function remove_cart(Request $request){
        $product = PluginProducts::find($request->input('id'));
        if($product){
            if(\Session::has('user_id')){
                $check = Cart::where("product_id", $request->input('id'))
                    ->where("user_id", \Session::get('user_id'))
                    ->first();
                if($check){
                    $check->delete();
                }
            }else{
                $cart =  \Session::get("cart.products");
                if ($cart) {
                    foreach ($cart as $k=>$item){
                        if($product->id == $item->product_id){
                            unset($cart[$k]);
                        }
                    }
                }
                \Session::put("cart.products", $cart);
            }

            $cart = $this->loading_cart(true);
            $tot = 0;
            if($cart){
                foreach($cart as $item) {
                    $product = PluginProducts::find($item->product_id);
                    $productTotal = $item->price * $item->qty;
                    $tot = $tot + $productTotal;
                }
            }
            echo "<p id='cartRiassunto'>Hai <b>".count($cart)." prodotti</b> nel carrello,<br/><strong>Totale (IVA inc.): &euro;".$tot."</strong></p>";
        }
    }

    public function loading_shippings($nazioneID, $cityID = null){
        $cart = $this->loading_cart(true);

        //calcolare anche totale peso
        if($nazioneID == "undefined"){
            $nazioneID = 106;
        }

        $nazioneID = (int) $nazioneID;

        $tot = 0;
        $tot_peso = 0;
        $shippings = [];
        if($cart){
            foreach ($cart as $item){
                $product = PluginProducts::find($item->product_id);
                if(!$product){
                    continue;
                }

                $productTotal = $item->price * $item->qty;
                $tot = $tot + $productTotal;

                if($product->weight){
                    $tot_peso = $tot_peso + ($product->weight * $item->qty);
                }

                //----------------SPEDIZIONI IN BASE AL TOTALE

                if($cityID === null){
                    $areasID = AreaCountry::where("country_id", $nazioneID)->groupBy("area_id")->get()->pluck("area_id")->toArray();

                    //prendo il primo con la nazione prezzo piu basso
                    $ship = ShippingRange::selectRaw("shop_shippings.id, shop_shippings.name, shop_shippings_ranges.price")
                        ->join("shop_shippings", "shop_shippings.id", "=", "shop_shippings_ranges.shipping_id")
                        ->join("shop_shippings_areas", "shop_shippings.id", "=", "shop_shippings_areas.shipping_id")
                        ->join("shop_areas", "shop_shippings_areas.area_id", "=", "shop_areas.id")
                        ->join("shop_areas_countries", "shop_areas.id", "=", "shop_areas_countries.area_id")
                        ->whereRaw("(min <= '$tot' AND max >= '$tot') AND shop_areas_countries.country_id = $nazioneID")
                        ->whereIn("shop_shippings_ranges.area_id", $areasID)
                        ->where("shop_shippings.type_ship", 0)
                        ->where("shop_shippings.is_active", 1)
                        ->orderBy("price", "asc")
                        ->take(1)
                        ->get();
                }else{
                    $areasID = AreaCity::where("city_id", $cityID)->groupBy("area_id")->get()->pluck("area_id")->toArray();
                    $ship = ShippingRange::selectRaw("shop_shippings.id, shop_shippings.name, shop_shippings_ranges.price")
                        ->join("shop_shippings", "shop_shippings.id", "=", "shop_shippings_ranges.shipping_id")
                        ->join("shop_shippings_areas", "shop_shippings.id", "=", "shop_shippings_areas.shipping_id")
                        ->whereRaw("(min <= '$tot' AND max >= '$tot')")
                        ->whereIn("shop_shippings_ranges.area_id", $areasID)
                        ->where("shop_shippings.type_ship", 0)
                        ->where("shop_shippings.is_active", 1)
                        ->groupBy("shop_shippings.id")
                        ->get();

                    //se non ci sono per la città, e la nazione è Italia prendi quella della SOLA NAZIONE
                   /* if(count($ship) == 0 && $nazioneID == 106){
                        $areasID = AreaCountry::where("country_id", $nazioneID)->groupBy("area_id")->get()->pluck("area_id")->toArray();
                        $ship = ShippingRange::selectRaw("shop_shippings.id, shop_shippings.name, shop_shippings_ranges.price")
                            ->join("shop_shippings", "shop_shippings.id", "=", "shop_shippings_ranges.shipping_id")
                            ->join("shop_shippings_areas", "shop_shippings.id", "=", "shop_shippings_areas.shipping_id")
                            ->join("shop_areas", "shop_shippings_areas.area_id", "=", "shop_areas.id")
                            ->join("shop_areas_countries", "shop_areas.id", "=", "shop_areas_countries.area_id")
                            ->whereRaw("(min <= '$tot' AND max >= '$tot') AND shop_areas_countries.country_id = $nazioneID")
                            ->whereIn("shop_shippings_ranges.area_id", $areasID)
                            ->where("shop_shippings.type_ship", 0)
                            ->where("shop_shippings.is_active", 1)
                            ->orderBy("price", "asc")
                            ->take(1)
                            ->get();
                    } */
                }

                if($ship){
                    foreach ($ship as $shipItem){
                        $shippings["{$shipItem->id}-{$shipItem->name}"] =  (1 * $shipItem->price); //$item->qty
                    }
                }



                //----------------SPEDIZIONI IN BASE AL PESO
                if($cityID === null) {
                    $areasID = AreaCountry::where("country_id", $nazioneID)->groupBy("area_id")->get()->pluck("area_id")->toArray();
                    $ship = ShippingRange::selectRaw("shop_shippings.id, shop_shippings.name, shop_shippings_ranges.price")
                        ->join("shop_shippings", "shop_shippings.id", "=", "shop_shippings_ranges.shipping_id")
                        ->join("shop_shippings_areas", "shop_shippings.id", "=", "shop_shippings_areas.shipping_id")
                        ->join("shop_areas", "shop_shippings_areas.area_id", "=", "shop_areas.id")
                        ->join("shop_areas_countries", "shop_areas.id", "=", "shop_areas_countries.area_id")
                        ->whereRaw("(min <= '$tot_peso' AND max >= '$tot_peso') AND shop_areas_countries.country_id = $nazioneID")
                        ->whereIn("shop_shippings_ranges.area_id", $areasID)
                        ->where("shop_shippings.type_ship", 1)
                        ->where("shop_shippings.is_active", 1)
                        ->get();

                }else{

                    $areasID = AreaCity::where("city_id", $cityID)->groupBy("area_id")->get()->pluck("area_id")->toArray();
                    $ship = ShippingRange::selectRaw("shop_shippings.id, shop_shippings.name, shop_shippings_ranges.price")
                        ->join("shop_shippings", "shop_shippings.id", "=", "shop_shippings_ranges.shipping_id")
                        ->join("shop_shippings_areas", "shop_shippings.id", "=", "shop_shippings_areas.shipping_id")
                        ->whereRaw("(min <= '$tot_peso' AND max >= '$tot_peso')")
                        ->whereIn("shop_shippings_ranges.area_id", $areasID)
                        ->where("shop_shippings.type_ship", 1)
                        ->where("shop_shippings.is_active", 1)
                        ->groupBy("shop_shippings.id")
                        ->get();


                    /*$ship = ShippingRange::selectRaw("shop_shippings.id, shop_shippings.name, shop_shippings_ranges.price")
                        ->join("shop_shippings", "shop_shippings.id", "=", "shop_shippings_ranges.shipping_id")
                        ->join("shop_shippings_areas", "shop_shippings.id", "=", "shop_shippings_areas.shipping_id")
                        ->join("shop_areas", "shop_shippings_areas.area_id", "=", "shop_areas.id")
                        ->join("shop_areas_cities", "shop_areas.id", "=", "shop_areas_cities.area_id")
                        ->whereRaw("(min <= '$tot_peso' AND max >= '$tot_peso') AND shop_areas_cities.city_id = $cityID")
                        ->where("shop_shippings.type_ship", 1)
                        ->where("shop_shippings.is_active", 1)
                        ->get();*/

                    //se non ci sono per la città, e la nazione è Italia prendi quella della SOLA NAZIONE
                    /*if(count($ship) == 0 && $nazioneID == 106){
                        $areasID = AreaCountry::where("country_id", $nazioneID)->groupBy("area_id")->get()->pluck("area_id")->toArray();
                        $ship = ShippingRange::selectRaw("shop_shippings.id, shop_shippings.name, shop_shippings_ranges.price")
                            ->join("shop_shippings", "shop_shippings.id", "=", "shop_shippings_ranges.shipping_id")
                            ->join("shop_shippings_areas", "shop_shippings.id", "=", "shop_shippings_areas.shipping_id")
                            ->join("shop_areas", "shop_shippings_areas.area_id", "=", "shop_areas.id")
                            ->join("shop_areas_countries", "shop_areas.id", "=", "shop_areas_countries.area_id")
                            ->whereRaw("(min <= '$tot_peso' AND max >= '$tot_peso') AND shop_areas_countries.country_id = $nazioneID")
                            ->whereIn("shop_shippings_ranges.area_id", $areasID)
                            ->where("shop_shippings.type_ship", 1)
                            ->where("shop_shippings.is_active", 1)
                            ->get();
                    }*/
                }

                if($ship){
                    foreach ($ship as $shipItem){
                        $shippings["{$shipItem->id}-{$shipItem->name}"] =  (1 * $shipItem->price); //$item->qty
                    }
                }

            }
        }

        /*$shipFree = Shipping::where("is_active", 1)->where("is_free", 1)->get();
        if($shipFree){
            foreach ($shipFree as $sf){
                $shippings["{$sf->id}-{$sf->name}"] = 0;
            }
        }*/

        ksort($shippings);

        return $shippings;
    }

    public function save_order_new(Request $request){
        $send_psw = 0;  $code_psw = "";
        if(\Session::has('user_id')){
            if(!$request->has('mini')){
                $this->validate($request, [
                    'address_id' => 'required',
                    'company_id' => 'required',
                    'payment_id' => 'required',
                    'shipping_id' => 'required',
                ],
                    [
                        "address_id.required" => "Selezionare un indirizzo di spedizione",
                        "company_id.required" => "Selezionare un indirizzo di fatturazione",
                        "payment_id.required" => "Selezionare un metodo di pagamento",
                        "shipping_id.required" => "Selezionare una spedizione",
                    ]
                );
            }else{
                $this->validate($request, [
                    'address_id' => 'required',
                    'company_id' => 'required',
                ],
                    [
                        "address_id.required" => "Selezionare un indirizzo di spedizione",
                        "company_id.required" => "Selezionare un indirizzo di fatturazione",
                    ]
                );
            }
        }else{
                $this->validate($request, [
                    'payment_id' => 'required',
                    'shipping_id' => 'required',
                ],
                    [
                        "payment_id.required" => "Selezionare un metodo di pagamento",
                        "shipping_id.required" => "Selezionare una spedizione",
                    ]
                );

            $authUser = User::withTrashed()->where('email', $request->get('email_access'))->first();
            if($authUser){
                if($authUser->deleted_at !== null){
                    $authUser->deleted_at = null;
                    $authUser->save();
                }

                \Auth::loginUsingId($authUser->id);
                \Session::put("user_id", $authUser->id);
            }else{
                $send_psw = 1;
                $code = unique_random("users", "code", "25");
                $code_psw = \Str::random(8);
                $authUser = User::create([
                    "name" => "{$request->input('first_name')} {$request->input('last_name')}",
                    "email" => trim($request->input('email_access')),
                    "password" => bcrypt($code_psw),
                    "code" => $code,
                    "check_privacy" => $request->input('check_privacy'),
                    "check_newsletter" => $request->input('check_newsletter'),
                    "active" => 1
                ]);

                $shopSetting = ShopSettings::first();
                $role_id = $shopSetting->role_default_register;

                $check_role = \DB::table('model_has_roles')->where("model_id", $authUser->id)->where("role_id", $role_id)->first();
                if(!$check_role){
                    \DB::table('model_has_roles')->insert([
                        "role_id" => $role_id,
                        "model_type" => "App\User",
                        "model_id" => $authUser->id
                    ]);
                }

                \Auth::loginUsingId($authUser->id);
                \Session::put("user_id", $authUser->id);
            }

            if(\Session::has("cart.products")){
                $products = \Session::get('cart.products');
                if($products){
                    foreach ($products as $product){
                        $cart = Cart::create([
                            "product_id" => $product->product_id,
                            "user_id" => $authUser->id,
                            "qty" => $product->qty,
                            "price" => $product->price
                        ]);

                        if(property_exists($product, "extra")){
                            if($product->extra){
                                foreach ($product->extra as $extra_id => $value){
                                    if($value !== null && trim($value) != "") {
                                        ShopCartExtra::create([
                                            "cart_id" => $cart->id,
                                            "extra_id" => $extra_id,
                                            "value" => $value
                                        ]);
                                    }
                                }
                            }
                        }

                    }
                }

                \Session::forget('cart.products');
            }

            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $country_id = $request->get('country_id');
            $province = $request->get('province');
            $address = $request->get('address');
            $number_street = $request->get('number_street');
            $mobile_phone = $request->get('mobile_phone');
            $zip = $request->get('zip');
            $comment = $request->get('comment');

            $city_name = $request->get('city_id');
            if($request->has('city_id')){
                $city = City::find($request->get('city_id'));
                if($city){
                    $city_name = $city->nome_comune;
                }
            }

            //salvo nell'users il mobile che va anche in address
            $authUser->mobile = $mobile_phone;
            $authUser->country_id = $country_id;
            $authUser->save();

            $address_client = Address::create([
                "user_id" => \Session::get('user_id'),
                "name" => "$first_name $last_name",
                "country_id" => $country_id,
                "county" => $province,
                "address1" => $address,
                "number_street" => $number_street,
                "phone" => $mobile_phone,
                "postal_code" => $zip,
                "comment" => $comment,
                "city" => $city_name,
                "custom_fields_shipping" => $request->has('custom_fields_shipping') ? json_encode($request->get('custom_fields_shipping')) : null
            ]);

            $count_fatturazione = Company::where("user_id", \Session::get('user_id'))->count();
            if($count_fatturazione == 0){
                if($request->has('name')){
                    $name = $request->get('name');
                    $business_name = $request->get('business_name');
                    $country_id = $request->get('country_id');
                    $province = $request->get('province');
                    $address = $request->get('address');
                    $fiscal_code_vat = $request->get('fiscal_code_vat');
                    $city_name = $request->get('city');
                    $pec = $request->get('pec');
                    $sdi = $request->get('sdi');
                    $postal_code = $request->get('postal_code');
                    $number_street = $request->get('number_street');

                    $company_client = Company::create([
                        "user_id" => \Session::get('user_id'),
                        "name" => $name,
                        "business_name" => $business_name,
                        "country_id" => $country_id,
                        "county" => $province,
                        "address1" => $address,
                        "fiscal_code_vat" => $fiscal_code_vat,
                        "pec" => $pec,
                        "sdi" => $sdi,
                        "postal_code" => $postal_code,
                        "city" => $city_name,
                        "number_street" => $number_street,
                        "custom_fields_checkout" => $request->has('custom_fields') ? json_encode($request->get('custom_fields')) : null
                    ]);
                }else{
                    $company_client = Company::create([
                        "user_id" => \Session::get('user_id'),
                        "name" => "$first_name $last_name",
                        "business_name" => null,
                        "country_id" => $country_id,
                        "county" => $province,
                        "address1" => $address,
                        "fiscal_code_vat" => null,
                        "pec" => null,
                        "sdi" => null,
                        "city" => $city_name,
                        "number_street" => $number_street,
                        "custom_fields_checkout" => $request->has('custom_fields') ? json_encode($request->get('custom_fields')) : null
                    ]);
                }
            }else{
                $company_client = Company::where("user_id", \Session::get('user_id'))->first();
            }
        }

        $user = User::find(\Session::get('user_id'));
        $theme = env("PROJECT_NAME");

        $total = $request->get('total');

        $payment_id = $request->get('payment_id');

        $shopSetting = ShopSettings::first();
        $status_id = $shopSetting->status_default_nonpagato;

        $coupon = null;
        $total_coupon = 0;
        if($request->has('coupon_id')){
            $coupon = CartRule::find($request->get('coupon_id'));
            if($coupon){
                $total_coupon = $request->get('total_coupon');
            }
        }

        $address_id = null;
        if($request->has('address_id')){
            $address_id = $request->get('address_id');
        }else{
            if($address_client){
                $address_id = $address_client->id;
            }
        }


        $company_id = null;
        if($request->has('company_id')){
            $company_id = $request->get('company_id');
        }else{
            if($company_client){
                $company_id = $company_client->id;
            }
        }


        $currency_id = 1;
        if(in_array($user->country_id, config('config.default_country_user_dollar'))){
             $currency_id = 2;
        }
        if(in_array($user->country_id, config('config.default_country_user_listino_2'))){
            $currency_id = 1;
        }


        $order = Order::create([
            "user_id" => $user->id,
            "status_id" => $status_id,
            "shipping_id" => $request->get('shipping_id') === null ? 0 : $request->get('shipping_id'),
            "payment_id" => $payment_id,
            "shipping_address_id" => $address_id,
            "billing_company_id" => $company_id,
            "currency_id" => $currency_id,
            "comment" => $request->get('note'),
            //"total" => (($total + $total_coupon) /1.22),
            //"total_tax" => $total + $total_coupon,
            "total_extra" => $request->get('total_extra'),
            "total_shipping" => ($request->get('total_ship')/1.22),
            "total_shipping_tax" => $request->get('total_ship'),
            "total_giftcard" => $request->get('total_gift'),
            "code_coupon" => $coupon ? $coupon->code : null,
            "total_coupon" => $total_coupon,
        ]);

        //scalo il coupon
        if($coupon){
            $coupon->total_available = $coupon->total_available - 1;
            $coupon->save();
        }

        $subscriptions_name = $request->get('subscriptions_name');

        if($order){
            $cart = $this->loading_cart(true);
            if($cart){
                foreach ($cart as $item){
                    $product = PluginProducts::find($item->product_id);
                    //scalo la qty
                    $product->qty = $product->qty - $item->qty;
                    //$product->last_update = Carbon::now()->toDateTimeString();
                    $product->save();

                    $vat = $product->tax ? $product->tax->value : 22;
                    $vat_calculate = ($vat / 100) + 1;

                    $price = $item->price / $vat_calculate;
                    $price_with_tax = $item->price;

                     OrderProduct::create([
                        "product_id" => $item->product_id,
                        "order_id" => $order->id,
                        "name" => $product->name,
                        "sku" => $product->sku,
                        "price" => $price,
                        "price_with_tax" => $price_with_tax,
                        "quantity" => $item->qty,
                        "custom_label_1" => $product->custom_1,
                        "custom_label_2" => $product->custom_2
                    ]);

                    if($product->is_subscription){

                        for($k=1; $k<=$item->qty; $k++){
                            $nominativo = $user->name;
                            if(key_exists($k-1, $subscriptions_name)){
                                $nominativo =  $subscriptions_name[$k-1];
                            }

                            UserSubscription::create([
                                "name" => $nominativo,
                                "user_id" => $user->id,
                                "product_id" => $item->product_id,
                                "start" => Carbon::now()->toDateString(),
                                "order_id" => $order->id
                            ]);
                        }
                    }

                    if(property_exists($item, "extra")){
                        if($item->extra){
                            foreach ($item->extra as $extra_id => $value){
                                if($value !== null && trim($value) != "") {
                                    ShopOrderProductExtra::create([
                                        "shop_order_id" => $order->id,
                                        "shop_product_id" => $item->product_id,
                                        "extra_id" => $extra_id,
                                        "value" => $value
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            $total = 0;
            $total_temp = OrderProduct::selectRaw("SUM(price * quantity) as tot")->where("order_id" , $order->id)->first();
            if($total_temp){
                $total = $total_temp->tot;
            }

            $total_with_tax = 0;
            $total_temp_tax = OrderProduct::selectRaw("SUM(price_with_tax * quantity) as tot")->where("order_id" , $order->id)->first();
            if($total_temp_tax){
                $total_with_tax = $total_temp_tax->tot;
            }

            $order->total = $total;
            $order->total_tax = $total_with_tax;
            $order->save();

        }

        $order->load(["shippingAddress", "billingCompanyInfo", "products", "payment", "status"]);

        if(env('PROJECT_NAME') == "Maison-Flaneur") {
            Excel::store(new OrderExport($order), "Ordine_$order->id.xlsx");
        }

        try{
            $destinatario = $user->email;
            \Mail::send("common.emails.order", ['order' => $order, 'send_psw' => $send_psw, 'code_psw'=>$code_psw, 'user'=> $user], function ($m) use ($destinatario, $theme, $order) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $m->to($destinatario)->subject("Nuovo ordine su $theme");
            });
        }catch (\Throwable $e) {
        }

        try{
            $destinatario = env('PROJECT_EMAIL_ALERT');
            \Mail::send("common.emails.orderForStaff", ['order' => $order, 'send_psw' => $send_psw, 'code_psw'=>$code_psw, 'user'=> $user], function ($m) use ($destinatario, $theme, $order, $shopSetting) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); //info@... env
                $m->to($destinatario)->subject("Nuovo ordine su $theme"); // a chi compra

                if($shopSetting->ccn_ordered){
                    $emails = explode(",", $shopSetting->ccn_ordered);

                    if(count($emails)){
                        foreach ($emails as $k=>$temp_email){
                            $emails[$k] = trim($temp_email);
                        }
                        $m->bcc($emails);
                    }
                }

                if(env('PROJECT_NAME') == "Maison-Flaneur") {
                    $location = storage_path("app/Ordine_{$order->id}.xlsx");
                    $m->attach($location);
                }
            });
        }catch (\Throwable $e) {
        }


        if(\Session::has('user_id')){
            Cart::where("user_id", $user->id)->delete();
        }else{
            \Session::forget('cart');
        }

        return redirect()->to("/order_result?order_id=$order->id");
    }

    public function order_result(Request $request){
        $id = $request->get('order_id');
        $order = Order::find($id);
        if(!$order){
            return redirect()->to("/");
        }

        $order->load(["user","products", "payment", "status"]);
        if(\Auth::user()) {
            if ($order->user_id != \Auth::user()->id) {
                return redirect()->to("/");
            }
        }

        $v_products = [];
        $v_products_gtin = [];
        if($order->products){
            foreach ($order->products as $product){
                $obj = new \stdClass();
                $obj->id = $product->pivot->sku;
                $obj->name = $product->pivot->name;
                $obj->category = $product->sku;
                $obj->price = $product->pivot->price_with_tax;
                $obj->quantity = $product->pivot->quantity;
                $v_products[] = $obj;

                if($product->ean){
                    $v_products_gtin[] = "{\"gtin\":\"{$product->ean}\"}";
                }
            }
        }

        $index = new IndexController();
        $slug = "order_result";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            return redirect()->to($page);
        }


        return view("order_result", compact("menu","page", "website", "order", 'v_products','v_products_gtin'));
    }

    public function order_result_paypal_payment(Request $request){
        $id = $request->get('order_id');
        $order = Order::find($id);
        if(!$order){
            return redirect()->to("/");
        }

        $order->load(["user","products", "payment", "status"]);

        if(\Auth::user()) {
            if ($order->user_id != \Auth::user()->id) {
                die;
            }
        }

        $index = new IndexController();
        $slug = "order_result_paypal";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            return redirect()->to($page);
        }



        $v_products = [];
        $v_products_gtin = [];
        if($order->products){
            foreach ($order->products as $product){
                $obj = new \stdClass();
                $obj->sku = $product->pivot->sku;
                $obj->name = $product->pivot->name;
                $obj->category = $product->sku;
                $obj->price = $product->pivot->price_with_tax;
                $obj->quantity = $product->pivot->quantity;
                $v_products[] = $obj;

                if($product->ean){
                    $v_products_gtin[] = "{\"gtin\":\"{$product->ean}\"}";
                }
            }
        }

        return view("order_result_paypal", compact("menu","page", "website", "order", 'v_products','v_products_gtin'));
    }

    public function email_order_test(Request $request){
        $order = Order::with("products")->orderBy("id", "desc")->first();
        $user = User::find($order->user_id);
        $send_psw = 0;
        $code_psw = "abcdefg";
        $theme = env('TEMA');

        if($request->has('html')){
            $html = view('common.emails.order', compact('order', 'send_psw', 'code_psw', 'user'))->render();
            die($html);
        }


        try{
            $destinatario = $user->email;
            \Mail::send("common.emails.order", ['order' => $order, 'send_psw' => $send_psw, 'code_psw'=>$code_psw, 'user'=> $user], function ($m) use ($destinatario, $theme, $order) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $m->to($destinatario)->subject("Nuovo ordine su $theme");
                if(env('PROJECT_NAME') == "Maison-Flaneur") {
                    $location = storage_path("app/Ordine_{$order->id}.xlsx");
                    $m->attach($location);
                }
            });

            echo "Email inviata";
        }catch (\Throwable $e) {
        }
    }

}
