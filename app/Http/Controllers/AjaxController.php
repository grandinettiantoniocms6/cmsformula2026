<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AdminPlugin;
use App\Models\AreaCountry;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartRule;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\ExtraCost;
use App\Models\GiftCard;
use App\Models\MessageTemplate;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsImagesSize;
use App\Models\PluginProductsLabels;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use App\Models\PluginProductsSettings;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingRange;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use App\Models\ShopSettings;
use App\Models\Slider;
use App\Models\WebsiteSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AjaxController extends Controller
{
    public $theme;

    public function __construct()
    {
        $this->theme = env('TEMA');
    }

    public function test(){
        dd("test");
    }

    public function get_payment_by_id(Request $request)
    {
        $id = $request->get('id');
        $payment = Payment::find($id);
        return response()->json($payment);

    }

    public function get_cities_by_province(Request $request){
        $provinceID = $request->input('id');
        $element = $request->input('element');
        $express = $request->input('express');

        $cities = City::where("sigla_provincia", $provinceID)->get();
        $html = \View::make("common.pluginProducts.partials.box_shipping_cities", compact('cities','element','express'))->render();
        if(env('TEMA') == "Webshop"){
            $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.box_shipping_cities", compact('cities','element','express'))->render();
        }

        return json_encode(["contents" => $html]);
    }

    public function get_shippings(Request $request){
        $nazioneID = $request->input('id');
        if($nazioneID == ""){
            return json_encode(["contents" => "",
                "shippings" => [],  "count_shippings" => 0, "total" =>0, "total_no_tax" => 0,
                "sum_tax" => 0, "total_ship" => 0, "first_ship_id" => 0, "tot_peso" => 0]);
        }

        $total = 0;
        $totNoTax = 0;
        $tot_peso = 0;

        $class = new CartController();
        $shippings = $class->loading_shippings($nazioneID);
        $cart = $class->loading_cart(true);

        if($cart){
            foreach ($cart as $item){
                $product = PluginProducts::with("tax")->find($item->product_id);
                if(!$product){
                    continue;
                }

                $productTotal = $item->price * $item->qty;
                $total = $total + $productTotal;

                if($product->weight){
                    $tot_peso = $tot_peso + ($product->weight * $item->qty);
                }

                $prezzoNoIva = $productTotal / ((100+$product->tax->value)/100);
                $totNoTax = $totNoTax + $prezzoNoIva;
            }
        }

        $first_ship = 0;
        $first_ship_id = 0;
        if(count($shippings) > 0){
            foreach ($shippings as $k=>$v) {
                $first_ship = $v;

                $temp = explode("-", $k);
                $first_ship_id = (int) $temp[0];
                break;
            }
        }

        $html = \View::make("common.pluginProducts.partials.box_order_shippings", compact('shippings'))->render();
        if(env('TEMA') == "Webshop"){
            $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.box_order_shippings", compact('shippings'))->render();
        }

        $total = $total;

        return json_encode(["contents" => $html,
            "shippings" => $shippings,  "count_shippings" => count($shippings), "total" =>round($total,2), "total_no_tax" => round($totNoTax,2),
            "sum_tax" => round($total - $totNoTax, 2), "total_ship" => (float) $first_ship, "first_ship_id" => $first_ship_id, "tot_peso" => $tot_peso]);
    }

    public function get_shippings_by_cities(Request $request){
        $nazioneID = $request->input('nazioneId');
        $cityID = $request->input('id');
        $total = 0;
        $totNoTax = 0;
        $tot_peso = 0;

        $class = new CartController();

        if($nazioneID == 106){
            $shippings = $class->loading_shippings($nazioneID, $cityID);
        }else{
            $shippings = $class->loading_shippings($nazioneID);
        }

        $cart = $class->loading_cart(true);

        if($cart){
            foreach ($cart as $item){
                $product = PluginProducts::find($item->product_id);
                if($product){
                    $productTotal = $item->price * $item->qty;
                    $total = $total + $productTotal;

                    if($product->weight){
                        $tot_peso = $tot_peso + ($product->weight * $item->qty);
                    }

                    $vat = $product->tax ? $product->tax->value : 22;

                    $prezzoNoIva = $productTotal / ((100+$vat)/100);
                    $totNoTax = $totNoTax + $prezzoNoIva;
                }
            }
        }

        $first_ship = 0;
        $first_ship_id = 0;
        if(count($shippings) > 0){
            foreach ($shippings as $k=>$v) {
                $first_ship = $v;

                $temp = explode("-", $k);
                $first_ship_id = (int) $temp[0];
                break;
            }
        }

        $advice_special = 0;

        $html = \View::make("common.pluginProducts.partials.checkout.box_method_shippings", compact('shippings','advice_special'))->render();
        if(env('TEMA') == "Webshop"){
            $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.checkout.box_method_shippings", compact('shippings','advice_special'))->render();
        }

        $total = $total;
        $sum_tax = $total - $totNoTax;


        if(\Auth::user()){
            if(\Auth::user()->type_client == 1){
                $first_ship_notax = $first_ship/1.22;
                $diff = $first_ship - $first_ship_notax;

                $sum_tax += $diff;
                $first_ship = $first_ship_notax;
            }
        }


        return json_encode(["contents" => $html,
            "shippings" => $shippings,  "count_shippings" => count($shippings), "total" =>round($total,2), "total_no_tax" => round($totNoTax,2),
            "sum_tax" => round($sum_tax, 2), "total_ship" => (float) $first_ship, "first_ship_id" => $first_ship_id, "tot_peso" => $tot_peso]);
    }

    public function get_box_shippings_checkout(Request $request){
        $id = $request->get('id');
        $html = "";
        if(\Session::has('user_id')){
            $user = User::with("addresses", "companies")->find(\Session::get('user_id'));
            $html = \View::make("common.pluginProducts.partials.checkout.box_shippings", compact('user', 'id'))->render();
            if(env('TEMA') == "Webshop"){
                $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.checkout.box_shippings", compact('user', 'id'))->render();
            }
        }

        return response()->json([
            "html" => $html
        ]);

    }

    public function get_box_fatturazione_checkout(Request $request){
        $id = $request->get('id');
        $html = "";
        if(\Session::has('user_id')){
            $user = User::with("addresses", "companies")->find(\Session::get('user_id'));
            $html = \View::make("common.pluginProducts.partials.checkout.box_fatturazione", compact('user', 'id'))->render();
            if(env('TEMA') == "Webshop"){
                $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.checkout.box_fatturazione", compact('user', 'id'))->render();
            }
        }

        return response()->json([
            "html" => $html
        ]);
    }

    public function get_info_for_method_shippings_checkout(Request $request){
        $address_id = $request->get('address_id');
        $address = Address::where("user_id",\Session::get('user_id'))->where("id",$address_id)->first();
        if($address){
            $address->city_id = null;
            $city = City::where("nome_comune", $address->city)->first();
            if($city){
                $address->city_id = $city->id;
            }
        }

        return response()->json([
            "address" => $address
        ]);
    }

    public function get_box_payments_checkout(Request $request){
        $id = $request->get('id');
        $payments = Payment::orderBy("order", "ASC")->get();
        $hasContrassegno = Payment::where("is_contrassegno", 1)->count();

        $tot = 0;

        $class = new CartController();
        $cart = $class->loading_cart(true);
        foreach ($cart as $item){
            $product = \App\Models\PluginProducts::find($item->product_id);
            if(!$product){
                continue;
            }

            $productTotal = $item->total_cart;
            $tot = $tot + $productTotal;
        }


        $html = "";
        if(\Session::has('user_id')){
            $user = User::with("addresses", "companies")->find(\Session::get('user_id'));
            $html = \View::make("common.pluginProducts.partials.checkout.box_method_payments", compact('user', 'id', 'payments', 'hasContrassegno','tot'))->render();
            if(env('TEMA') == "Webshop"){
                $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.checkout.box_method_payments", compact('user', 'id', 'payments', 'hasContrassegno','tot'))->render();
            }
        }

        return response()->json([
            "html" => $html
        ]);
    }

    public function new_address_checkout(Request $request){
        $address = null;
        if(\Session::has('user_id')){
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

            if($request->has('id')){
                Address::where("id", $request->get('id'))
                    ->where("user_id", \Session::get('user_id'))
                    ->update([
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

                $address_client = Address::find($request->get('id'));
            }else{
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
                    Company::create([
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
                        "number_street" => $number_street
                    ]);
                }
            }
        }

        return response()->json([
            "address" => $address_client
        ]);
    }

    public function new_fatturazione_checkout(Request $request){
        $address = null;
        if(\Session::has('user_id')){
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

            if($request->has('id')){
                Company::where("id", $request->get('id'))
                    ->where("user_id", \Session::get('user_id'))
                    ->update([
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
                $address = Company::find($request->get('id'));

            }else{
                $address = Company::create([
                    "user_id" => \Session::get('user_id'),
                    "name" => $name,
                    "business_name" => $business_name,
                    "country_id" => $country_id,
                    "county" => $province,
                    "address1" => $address,
                    "fiscal_code_vat" => $fiscal_code_vat,
                    "pec" => $pec,
                    "sdi" => $sdi,
                    "city" => $city_name,
                    "postal_code" => $postal_code,
                    "number_street" => $number_street,
                    "custom_fields_checkout" => $request->has('custom_fields') ? json_encode($request->get('custom_fields')) : null
                ]);
            }
        }

        return response()->json([
            "address" => $address
        ]);
    }

    public function get_address_checkout(Request $request){
        $id = (int) $request->get('address_id');
        if(\Session::has('user_id')) {
            $address = Address::where("user_id", \Session::get('user_id'))->where("id", $id)->first();
            if($address){
                if($address->city){
                    $city = City::where("nome_comune", $address->city)->first();
                    if($city){
                        $address->city_id = $city->id;
                    }
                }
            }
            return response()->json([
                "address" => $address
            ]);
        }

        return response()->json([
            "error" => true
        ]);
    }

    public function get_fatturazione_checkout(Request $request){
        $id = (int) $request->get('address_id');
        if(\Session::has('user_id')) {
            return response()->json([
                "address" => Company::where("user_id", \Session::get('user_id'))->where("id", $id)->first()
            ]);
        }

        return response()->json([
            "error" => true
        ]);
    }

    public function delete_address_checkout(Request $request){
        $id = (int) $request->get('address_id');
        if(\Session::has('user_id')) {
            Address::where("user_id", \Session::get('user_id'))->where("id", $id)->delete();

            $count =  Address::where("user_id", \Session::get('user_id'))->count();
            return response()->json([
                "count" => $count
            ]);
        }

        return response()->json([
            "error" => true
        ]);
    }

    public function delete_fatturazione_checkout(Request $request){
        $id = (int) $request->get('address_id');
        if(\Session::has('user_id')) {
            Company::where("user_id", \Session::get('user_id'))->where("id", $id)->delete();
        }

        return response()->json([
            "error" => true
        ]);
    }


    public function code_coupon(Request $request){
        $html_ship = "";
        $value = trim($request->input('value'));
        $total = trim($request->input('total'));
        $total_ship = (float) trim($request->input('total_ship'));
        $total_product = (float) trim($request->input('total_product'));
        $total_extra = (float) trim($request->input('total_extra'));

        //$total_product = $total - $total_ship;
        $total_cart = $total_product; //$total_product + $total_ship;
        $total_discount = 0;
        $setDiscount = 1;
        $v_cat_id = [];

        $now = Carbon::now()->toDateTimeString();

        $class = new CartController();
        $cart = $class->loading_cart(true);

        $rule = CartRule::with("products", "categories")
            ->where("code", $value)
            ->where("status", 1)
            ->whereRaw("(start_date <= '$now' AND expiration_date >='$now') AND total_available > 0")
            ->first();

        $html = "<div class='alert alert-danger mt-3 mb-0 py-2'>Coupon non trovato</div>";

        $html_coupon = "";
        $conditions = [];
        if($rule){
            $count_product = 0;
            $tot_product_cart = 0;

            //prodotti da controllare
            $conditions['rules_products'] = 0;
            if(count($rule->products)){
                $conditions['rules_products'] = 1;
            }

            $conditions['rules_categories'] = 0;
            if(count($rule->categories)){
                $conditions['rules_categories'] = 1;

                foreach ($rule->categories as $ite){
                    $temp = $ite->get_tree_categories($ite->id);
                    if($temp){
                        foreach ($temp as $vl){
                            $v_cat_id[] = $vl;
                        }
                    }
                }
            }

            if($cart){
                foreach ($cart as $item){

                    $count_product += $item->qty;

                    if(count($rule->products)){
                        if(in_array((int) $item->product_id, $rule->products()->pluck("id")->toArray())){
                            $conditions['rules_products'] = 0;

                            switch ($rule->discount_type) {
                                case "Amount - order":
                                    $tot_product_cart += round(($item->price * $item->qty) - $rule->reduction_amount,2);
                                    $total_discount += $rule->reduction_amount;
                                    break;
                                case "Percent - order":
                                    $tot_product_cart += round($item->price * $item->qty - (($item->price * $item->qty * $rule->reduction_amount) / 100),2);
                                    $total_discount += ($item->price * $item->qty * $rule->reduction_amount) / 100;
                                    break;
                            }
                        }
                    }else{
                        $tot_product_cart += $item->price * $item->qty;
                    }


                    if($rule->categories){
                        if(count($v_cat_id)){
                            $check = \DB::table("plugins_products_categories_products")->where("plugin_product_product_id", $item->product_id)
                                ->whereIn("plugin_product_category_id", $v_cat_id)
                                ->first();
                            if($check){
                                $conditions['rules_categories'] = 0;

                                switch ($rule->discount_type) {
                                    case "Amount - order":
                                        $tot_product_cart -= $tot_product_cart += $item->price * $item->qty;

                                        $tot_product_cart += round($item->price * $item->qty - $rule->reduction_amount,2);
                                        $total_discount += $rule->reduction_amount;

                                        break;
                                    case "Percent - order":
                                        $tot_product_cart -= $tot_product_cart += $item->price * $item->qty;

                                        $tot_product_cart += round($item->price * $item->qty - (($item->price * $item->qty * $rule->reduction_amount) / 100),2);
                                        $total_discount += ($item->price * $item->qty * $rule->reduction_amount) / 100;
                                        break;
                                }
                            }else{
                                $html = "<div class='alert alert-danger mt-3 mb-0 py-2'>Questo Coupon è dedicato a categorie specifiche</div>";
                            }
                        }
                    }
                }
            }

            $conditions['min_nr_products'] = 0;
            if($rule->min_nr_products){
                if($count_product < $rule->min_nr_products){
                    $conditions['min_nr_products'] = 1; //dai errore
                    $html = "<div class='alert alert-danger mt-3 mb-0 py-2'>Aggiungere minimo $rule->min_nr_products prodotti!</div>";
                }
            }
            if($rule->minimum_amount){
                $conditions['minimum_amount'] = 0;
                if ($tot_product_cart < $rule->minimum_amount) {
                    $conditions['minimum_amount'] = 1; //dai errore

                    $html = "<div class='alert alert-danger mt-3 mb-0 py-2'>Il minimo totale carrello deve essere maggiore/uguale a $rule->minimum_amount &euro;!</div>";
                }
            }

            $conditions['total_available_each_user'] = 0;
            if($rule->total_available_each_user){ //da fare anche lato php
                if(\Session::has("user_id")){
                    $user = User::find(\Session::get('user_id'));

                    if($user){
                        $countOrder = Order::where("user_id", $user->id)
                            ->where("cart_rule_id", $rule->id)
                            ->count();

                        if($countOrder > 0) {
                            if ($countOrder < $rule->total_available_each_user) {
                                $conditions['total_available_each_user'] = 1;
                            }
                        }
                    }
                }
            }

            foreach ($conditions as $v){
                if($v == 1){
                    $setDiscount = 0;
                }
            }

            $total_cart = $tot_product_cart;

            if($setDiscount > 0) {
                    switch ($rule->discount_type) {
                        case "Amount - order":

                            if(count($rule->products) == 0 && count($rule->categories) == 0){
                                $total_cart = $total_cart - $rule->reduction_amount;
                                $total_discount = $rule->reduction_amount;
                            }

                            if($rule->reduction_amount) {
                                $html_coupon = "<td class=\"pl-0\"><strong class='badge badge-warning'>Sconto coupon</strong></td>
                                    <td class=\"pr-0 text-right\"><strong>-&euro; $rule->reduction_amount</strong></td>";
                            } else {
                                $html_coupon = "<td class=\"pl-0\"><strong class='badge badge-success'>Coupon applicato</strong></td>
                                    <td class=\"pr-0 text-right\"></td>";
                            }

                            break;
                        case "Percent - order":
                            if(count($rule->products) == 0 && count($rule->categories) == 0){
                                $total_cart = $total_cart - (($total_cart * $rule->reduction_amount) / 100);
                                $total_discount = (($tot_product_cart * $rule->reduction_amount) / 100);
                            }

                            $html_coupon = "<td class=\"pl-0\"><strong class='badge badge-warning'>Sconto coupon</strong></td>
                                    <td class=\"pr-0 text-right\"><strong>- $rule->reduction_amount%</strong></td>";

                            break;

                    }


                 if($rule->free_delivery != 0) {

                    $html_ship = "<td class=\"pl-0\"><strong class='badge badge-warning'>Sconto spedizione gratuita</strong></td>
                                    <td class=\"pr-0 text-right\"><strong>-&euro;  $total_ship</strong></td>";

                    // $total_cart = $total_cart - $total_ship;
                    $total_ship = 0;

                }

                $html = "<div class='alert alert-success mt-3 mb-0 py-2'><h5 class='mb-1'>{$rule->promo_label}</h5>{$rule->promo_text}</div><input type='hidden' name='coupon_id' value='$rule->id'>";

            }
        }
        return json_encode(["contents" => $html, "contents_coupon" => $html_coupon, "contents_ship" => $html_ship,  "total_product" =>round($total_cart,2), "total" =>round(($total_cart + $total_extra),2), "total_ship" => $total_ship, "total_view" => round(($total_cart + $total_extra + $total_ship),2),  "rule" => $setDiscount, "ex_total" => $request->input('total'), "ex_total_ship"=> $request->input('total_ship'), "total_discount" => round($total_discount,2), "conditions" => $conditions]);

    }


    public function uncheck_code_coupon(Request $request){
        $class = new CartController();
        $cart = $class->loading_cart(true);

        $total_ship = $request->get('total_ship');

        $tot_product_cart = 0;
        if($cart){
            foreach ($cart as $item){
                $tot_product_cart += $item->price * $item->qty;
            }
        }

        return json_encode(["total_product" =>round($tot_product_cart,2), "total_ship" => round($total_ship,2)]);

    }

    public function get_second_attribute_detail_product(Request $request){
        $slug = null;
        $product_id = $request->get('product_id');
        $id = trim($request->get('val'));

        $attribute_item = null;
        $options = null;

        $redirect = null;



        $itemProduct = PluginProducts::find($product_id);

        $category_product = PluginProductsCategoriesProducts::where("plugin_product_product_id", $product_id)
            ->pluck("plugin_product_category_id", "plugin_product_category_id")->toArray();

        //$category_product = PluginProductsCategoriesProducts::where("plugin_product_product_id", $product_id)->first();

        //prendo il primo attribute in ordine
        /*$attribute_first = \App\Models\ShopAttributes::orderBy("lft", "asc")
            ->whereIn("category_id", $category_product->plugin_product_category_id)
            ->first();*/

        $attribute_first = \App\Models\ShopAttributes::selectRaw("shop_attributes.*")
            ->join("shop_attributes_categories", "shop_attributes_categories.shop_attribute_id", "=", "shop_attributes.id")
            ->whereIn("shop_category_id", $category_product)
            ->groupBy("shop_attributes.id")
            ->orderBy("lft", "asc")
            ->first();

        if(!$attribute_first){
            $attribute_first = \App\Models\ShopAttributes::orderBy("lft", "asc")
                ->first();
        }

        $variants_ids = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)
            ->where("is_variant", 1)
            ->where("is_active", 1)
            ->get()->pluck("id")
            ->toArray();

        $optionProduct  = ShopAttributesProducts::where("id", $id)->first();

        //prendi tutti quei prodotti che hanno come option il 7 e attribute_id = 1
        $ids = \App\Models\ShopAttributesProducts::where("attribute_id", $optionProduct->attribute_id)
            ->where("option_id", $optionProduct->option_id)
            ->whereIn("product_id", $variants_ids)
            ->get()->pluck("product_id")
            ->toArray();

        $html = "";
        $link = "";

        if(count($ids) > 1){
            /*$attribute_item = \App\Models\ShopAttributes::where("id", "!=", $attribute_first->id)
                ->where("category_id", $category_product->plugin_product_category_id)
                ->orderBy("lft", "asc")->first();*/

            $attribute_item = \App\Models\ShopAttributes::selectRaw("shop_attributes.*")
                ->join("shop_attributes_categories", "shop_attributes_categories.shop_attribute_id", "=", "shop_attributes.id")
                ->whereIn("shop_category_id", $category_product)
                ->where("shop_attributes.id", "!=", $attribute_first->id)
                ->groupBy("shop_attributes.id")
                ->orderBy("lft", "asc")
                ->first();

            if(!$attribute_item){
                $attribute_item = \App\Models\ShopAttributes::where("id", "!=", $attribute_first->id)
                    ->orderBy("lft", "asc")->first();
            }


            if($attribute_item){
                $options = \App\Models\ShopAttributesOptions::selectRaw("shop_attributes_options.*, shop_attributes_products.product_id")
                    ->join("shop_attributes_products", "shop_attributes_options.id", "shop_attributes_products.option_id")
                    ->where("attribute_id", $attribute_item->id)
                    ->whereIn("product_id", $ids)
                    ->groupBy("value")
                    ->orderBy("shop_attributes_options.ordine", "asc")
                    ->get();

                if($request->has('radio')){
                    if(count($options)){
                        $tempProduct = PluginProducts::find($options[0]->product_id);
                        $cat_prod_slug = "no-categoria";
                        $cat_prod = $tempProduct->category();
                        if($cat_prod){
                            $cat_prod_slug = $cat_prod->slug;
                        }

                        $link = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$tempProduct->slug]);
                        $slug = $tempProduct->slug;
                    }

                    $redirect = 1;

                    $html = \View::make("common.pluginProducts.shop.radio_html_variants", compact('attribute_item','options'))->render();
                }else{
                    if(count($options)) {
                        $html = \View::make("common.pluginProducts.shop.select_html_variants", compact('attribute_item','options'))->render();
                    }else{
                        $tempProduct = PluginProducts::find($ids[0]);
                        $cat_prod_slug = "no-categoria";
                        $cat_prod = $tempProduct->category();
                        if($cat_prod){
                            $cat_prod_slug = $cat_prod->slug;
                        }

                        $link = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$tempProduct->slug]);

                        $slug = $tempProduct->slug;
                    }
                }



            }else{
                $tempProduct = PluginProducts::find($ids[0]);
                $cat_prod_slug = "no-categoria";
                $cat_prod = $tempProduct->category();
                if($cat_prod){
                    $cat_prod_slug = $cat_prod->slug;
                }

                $link = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$tempProduct->slug]);

                $slug = $tempProduct->slug;
            }
        }

        if(count($ids) == 1){
            $tempProduct = PluginProducts::find($optionProduct->product_id);
            $cat_prod_slug = "no-categoria";
            $cat_prod = $tempProduct->category();
            if($cat_prod){
                $cat_prod_slug = $cat_prod->slug;
            }

            $link = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$tempProduct->slug]);
            $slug = $tempProduct->slug;
        }


        $button = null;
        if($slug){
            $button = "<a class='btn btn-primary' href='$link'>Vai al prodotto</a>";
        }

        return json_encode(["contents" => $html, "slug" => $slug, "button" => $button, "redirect" => $redirect]);

    }

    public function get_fields_custom_checkout(Request $request){
        $shopSetting = ShopSettings::first();
        $choose = $request->get('value');

        $html = \View::make("common.pluginProducts.partials.checkout.custom_fields_checkout", compact('shopSetting','choose'))->render();
        if(env('TEMA') == "Webshop"){
            $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.checkout.custom_fields_checkout", compact('shopSetting','choose'))->render();
        }
        echo $html;
    }


    public function product_detail(Request $request){
        $id = $request->get('product_id');
        $itemProduct = PluginProducts::where("id", $id)->first();
        if(!$itemProduct){
            echo "";
            die;
        }

        $itemProduct->images = PluginProductsImages::where("product_id", $itemProduct->id)->orderBy("order", "asc")->get();
        $itemProduct->images_size = PluginProductsImagesSize::where("product_id", $itemProduct->id)->orderBy("order", "asc")->get();
        $itemProduct->options = PluginProductsOptions::selectRaw("plugins_products_attributes.name, plugins_products_options.attribute_id, plugins_products_options.value")
            ->join("plugins_products_attributes", "plugins_products_attributes.id", "=", "plugins_products_options.attribute_id")
            ->where("product_id", $itemProduct->id)
            ->orderBy("plugins_products_options.lft", "asc")
            ->get();
        $itemProduct->related = PluginProductsRelated::where("product_id", $itemProduct->id)->get();
        $itemProduct->attachmentsList = PluginProductsAttachments::where("product_id", $itemProduct->id)->orderBy("lft", "asc")->get();
        $itemProduct->category = $itemProduct->category();


        $shopSetting = ShopSettings::first();
        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();
        $website = WebsiteSetting::first();
        $plugin = PluginProductsSettings::first();

        $images = [];
        $images_isext = [];

        $padre = null;
        if($itemProduct->is_variant == 1 && $shopSetting->type_view_variant == 3){
            $padre = PluginProducts::where("group_id", $itemProduct->group_id)->where("is_variant", 0)->first();
            if($padre){
                if($itemProduct->include_photo_padre == 1){
                    if($padre){
                        $padre->images = PluginProductsImages::where("product_id", $padre->id)->orderBy("order", "asc")->get();
                    }

                    if(count($padre->images)){
                        foreach($padre->images as $image){
                            $images[] = $image->image;
                            $images_isext[] = $image->is_ext;
                        }
                    }
                }
            }

            /* Se non si vuole vedere le foto delle varianti commento da riga 36 a riga 40 */
            if(count($itemProduct->images)){
                foreach($itemProduct->images as $image){
                    $images[] = $image->image;
                    $images_isext[] = $image->is_ext;
                }
            }
        }else{
            if(count($itemProduct->images)){
                foreach($itemProduct->images as $image){
                    $images[] = $image->image;
                    $images_isext[] = $image->is_ext;
                }
            }
        }

        $categories_products = PluginProductsCategories::join("plugins_products_categories_products", "plugins_products_categories.id", "=", "plugins_products_categories_products.plugin_product_category_id")
            ->where("plugin_product_product_id", $itemProduct->id)
            ->where("plugins_products_categories.is_active", 1)
            ->get();

        $path = "common.pluginProducts.partials.modal_detail_product";
        if(env('TEMA') == "Webshop"){
            $path = "Webshop.plugins.pluginProducts.v3.partials.modal_detail_product";
        }

        $html = \View::make($path, compact('itemProduct', 'shopSetting', 'labels','images','website','plugin','categories_products', 'images_isext'))->render();
        echo $html;
    }


    public function product_variant_list(Request $request){
        $id = $request->get('product_id');
        $itemProduct = PluginProducts::where("id", $id)->first();
        $padre = null;

        $itemProduct->images = PluginProductsImages::where("product_id", $itemProduct->id)->orderBy("order", "asc")->get();
        $itemProduct->images_size = PluginProductsImagesSize::where("product_id", $itemProduct->id)->orderBy("order", "asc")->get();
        $itemProduct->options = PluginProductsOptions::selectRaw("plugins_products_attributes.name, plugins_products_options.attribute_id, plugins_products_options.value")
            ->join("plugins_products_attributes", "plugins_products_attributes.id", "=", "plugins_products_options.attribute_id")
            ->where("product_id", $itemProduct->id)
            ->orderBy("plugins_products_options.lft", "asc")
            ->get();
        $itemProduct->related = PluginProductsRelated::where("product_id", $itemProduct->id)->get();
        $itemProduct->attachmentsList = PluginProductsAttachments::where("product_id", $itemProduct->id)->orderBy("lft", "asc")->get();
        $itemProduct->category = $itemProduct->category();


        $shopSetting = ShopSettings::first();
        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();
        $website = WebsiteSetting::first();
        $plugin = PluginProductsSettings::first();

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();

        $images = [];

        if($itemProduct->is_variant == 1 && $shopSetting->type_view_variant == 3){
            $padre = PluginProducts::where("group_id", $itemProduct->group_id)->where("is_variant", 0)->first();
            if(!$padre){
                $lang = \App::getLocale();
                return redirect()->route("pluginProducts.404.$lang");
            }

            if($itemProduct->include_photo_padre == 1){
                if($padre){
                    $padre->images = PluginProductsImages::where("product_id", $padre->id)->orderBy("order", "asc")->get();
                }

                if(count($padre->images)){
                    foreach($padre->images as $image){
                        $images[] = $image->image;
                    }
                }
            }

            /* Se non si vuole vedere le foto delle varianti commento da riga 36 a riga 40 */
            if(count($itemProduct->images)){
                foreach($itemProduct->images as $image){
                    $images[] = $image->image;
                }
            }
        }else{
            if(count($itemProduct->images)){
                foreach($itemProduct->images as $image){
                    $images[] = $image->image;
                }
            }
        }

        $categories_products = PluginProductsCategories::join("plugins_products_categories_products", "plugins_products_categories.id", "=", "plugins_products_categories_products.plugin_product_category_id")
            ->where("plugin_product_product_id", $itemProduct->id)
            ->where("plugins_products_categories.is_active", 1)
            ->get();

        $product = PluginProducts::where("id", $id)->first();

        $variants_ids = PluginProducts::where("group_id", $product->group_id)
            ->where("is_variant", 1)
            ->where("is_active", 1)
            ->get()->pluck("id")
            ->toArray();

        //prendo il primo attribute in ordine
        $attribute_first = ShopAttributes::orderBy("lft", "asc")->first();

        if(count($variants_ids)){
            $temp_ids = PluginProducts::selectRaw("count(*) as tot, code_article, group_concat(id) as ids")
                ->whereIn("id", $variants_ids)
                ->orderBy("code_article", "ASC")
                ->groupBy("code_article")
                ->get();


            $v_final = [];
            foreach($temp_ids as $pp){
                $vet_ids = ShopAttributesProducts::selectRaw("GROUP_CONCAT(product_id) as ids, option_id")->whereRaw("product_id IN ($pp->ids)")
                    ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                    ->where("attribute_id", $attribute_first->id)
                    ->orderBy("shop_attributes_options.value", "asc")
                    ->groupBy("option_id")
                    ->get()
                    ->pluck("ids", "option_id")
                    ->toArray();

                if($vet_ids){
                    foreach ($vet_ids as $k=>$v){
                        //tra gli ids quali ha attribute_shop_id 2 con valore inferiore alfabeticamente?
                        $temp_v = explode(",", $v);

                        $options_p = ShopAttributesProducts::selectRaw("shop_attributes_products.product_id")
                            ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                            ->whereIn("product_id", $temp_v)
                            ->where("attribute_id", 2)
                            ->orderBy("shop_attributes_options.value", "asc")
                            ->first();

                        if($options_p){
                            $vet_ids[$k] = $options_p->product_id;
                        }

                    }
                }

                if($vet_ids){
                    foreach ($vet_ids as $idF){
                        $v_final[] = $idF;
                    }
                }
            }
            $vet_ids = $v_final;
        }

        $thema = env('TEMA');
        $html = \View::make("common.pluginProducts.partials.modal_detail_product_variants", compact('adminPlugin','thema', 'itemProduct','padre', 'shopSetting', 'labels','images','website','plugin','categories_products', 'vet_ids'))->render();
        if(env('TEMA') == "Webshop"){
            $html = \View::make("Webshop.plugins.pluginProducts.v3.partials.modal_detail_product_variants", compact('adminPlugin','thema', 'itemProduct','padre', 'shopSetting', 'labels','images','website','plugin','categories_products', 'vet_ids'))->render();
        }
        echo $html;
    }



}
