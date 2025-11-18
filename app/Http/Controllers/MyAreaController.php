<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use App\Models\ActivityRate;
use App\Models\Address;
use App\Models\AgentUser;
use App\Models\AreaCountry;
use App\Models\Category;
use App\Models\CategoryActivity;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientOrder;
use App\Models\ClientWishlist;
use App\Models\Company;
use App\Models\Country;
use App\Models\GiftCard;
use App\Models\Message;
use App\Models\Order;
use App\Models\Page;
use App\Models\Payment;
use App\Models\PluginBookingReservation;
use App\Models\PluginProducts;
use App\Models\PluginProductsContacts;
use App\Models\PluginProductsLabels;
use App\Models\PluginProductsRequests;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingRange;
use App\Models\ShopOrders;
use App\Models\UserSubscription;
use App\Models\WebsiteSetting;
use App\Models\Wishlist;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyAreaController extends Controller
{
    public $theme;

    public function __construct()
    {
        $this->theme = env('TEMA');
    }

    public function check_user(){
        if (\Auth::user()){
            $user = User::find(\Auth::user()->id);
            if($user){
                return $user;
            }
        }
    }

    public function dashboard(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }


        $index = new IndexController();
        $slug = "myarea_dashboard";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $countries = Country::orderBy("name", "asc")->get();
        return view("myarea.dashboard", compact("menu","page", "website", "user", "countries"));
    }

    public function profile(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_profile";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $countries = Country::orderBy("name", "asc")->get();
        return view("myarea.profile", compact("menu","page", "website", "user", "countries"));
    }

    public function profileProcess(Request $request){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $vet = [];

        $vet["name"] = "required";
        $vet["mobile"] = "required";
        if($request->get('old_password') != ""){
            $vet["old_password"] = "required|min:3";
            $vet["password"] = "required|min:3|confirmed";
            $vet["password_confirmation"] = "required|min:3";
        }

        $this->validate($request, $vet,
            [
                "name.required" => "Nominativo/Ragione Sociale campo obbligatorio",
                "mobile.required" => "Telefono campo obbligatorio",
                "password.required" => "Nuova Password campo obbligatorio",
                "password_confirmation.required" => "Conferma Password deve coincidere",
            ]
        );

        $user = User::find(\Auth::user()->id);

        if($request->get('old_password') != "") {
            if (\Hash::check($request->input('old_password'), $user->password)) {
                $user->password = bcrypt($request->get('password'));
            } else {
                return redirect()->back()->withErrors(['Password vecchia errata!']);
            }
        }

        $user->name = trim($request->input('name'));
        $user->mobile = trim($request->input('mobile'));
        $user->country_id = trim($request->input('country_id'));
        if($request->has('check_newsletter')){
            $user->check_newsletter = 1;
        }else{
            $user->check_newsletter = 0;
        }

        $user->save();

        return redirect()->back()->with('message', "Dati salvati con successo!");

    }

    public function wishlist(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_wishlist";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }


        $products = Wishlist::with("product")->where("user_id", $user->id)->get();
        return view("myarea.wishlist", compact("menu","page", "website", "user", "products"));
    }

    public function wishlistAdd(Request $request){
        $user = $this->check_user();


        $product = PluginProducts::find($request->get('id'));

        if($product){
            $check = Wishlist::where("user_id", $user->id)
                ->where("product_id", $product->id)->first();
            if(!$check){
                Wishlist::insert([
                    "user_id" => $user->id,
                    "product_id" => $product->id,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }
        echo "success";
    }

    public function wishlistDelete(Request $request){
        $user = $this->check_user();
        $product = PluginProducts::find($request->get('id'));

        if($product){
            Wishlist::where("user_id", $user->id)
                ->where("product_id", $product->id)->delete();
        }
        echo "success";
    }

    public function wishlistDeleteList(Request $request){
        $this->wishlistDelete($request);
        return redirect()->back();
    }

    public function orders(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_orders";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $orders = Order::where("user_id", $user->id)->orderBy("id", "desc")->get();
        return view("myarea.orders", compact("menu","page", "website", "user", "orders"));

    }

    public function subscriptions(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_subscriptions";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $orders = UserSubscription::where("user_id", $user->id)->orderBy("id", "desc")->get();
        return view("myarea.subscriptions", compact("menu","page", "website", "user", "orders"));

    }

    public function reservations(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_reservations";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $reservations = PluginBookingReservation::where("user_id", $user->id)
            ->where("is_hidden", 0)
            ->orderBy("id", "desc")
            ->get();

        return view("myarea.reservations", compact("menu","page", "website", "user", "reservations"));
    }

    public function support(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_support";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $orders = Order::where("user_id", $user->id)->orderBy("id", "desc")->get();
        return view("myarea.support", compact("menu","page", "website", "user", "orders"));
    }


    public function addresses(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_addresses";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $addresses = Address::where("user_id", $user->id)->get();
        return view("myarea.addresses", compact("menu","page", "website", "user", "addresses"));
    }

    public function address($id = null){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_address";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }


        $address = null;
        if($id){
            $address = Address::where("user_id", $user->id)->where("id", $id)->first();
        }

        $countries = Country::orderBy("name", "asc")->get();
        return view("myarea.address", compact("menu","page", "website", "user", "address", "countries"));

    }

    public function address_save(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'address1' => 'required',
            'county' => 'required',
            'city_id' => 'required',
            'zip' => 'required',
        ],
            [
                "name.required" => "Nominativo campo obbligatorio",
                "address1.required" => "Indirizzo campo obbligatorio",
                "county.required" => "Provincia campo obbligatorio",
                "city_id.required" => "Città campo obbligatorio",
                "zip.required" => "Cap campo obbligatorio"
            ]
        );

        $city_name = "";
        if(is_numeric($request->get('city_id'))){
            $city = City::find($request->get('city_id'));
            if($city){
                $city_name = $city->nome_comune;
            }
        }else{
            $city_name = trim($request->get('city_id'));
        }

        if($request->get('address_id') != 0){
            $address = Address::where("user_id", \Session::get("user_id"))->where("id", $request->get('address_id'))->first();
            if($address){
                $address->name = $request->get('name');
                $address->address1 = $request->get('address1');
                $address->county = $request->get('county');
                $address->country_id = $request->get('country_id');
                $address->city = $city_name;
                $address->postal_code = $request->get('zip');
                $address->save();
            }
        }else{
            Address::insert([
                "name" => $request->get('name'),
                "country_id" => $request->get('country_id'),
                "address1" => $request->get('address1'),
                "county" => $request->get('county'),
                "city" => $city_name,
                "postal_code" => $request->get('zip'),
                "user_id" => \Session::get('user_id'),
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        return redirect()->route("myarea.addresses")->with("message", "Indirizzo salvato con successo");
    }

    public function address_delete($id){
        $address = Address::where("user_id", \Session::get("user_id"))->where("id", $id)->first();
        if($address){
            $address->delete();
            return redirect()->route("myarea.addresses")->with("message", "Indirizzo cancellato con successo");
        }

        return redirect()->route("myarea.addresses");
    }

    public function companies(){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_companies";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $companies = Company::where("user_id", $user->id)->get();

        return view("myarea.companies", compact("menu","page", "website", "user", "companies"));
    }

    public function company($id = null){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_company";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $company = null;
        if($id){
            $company = Company::where("user_id", $user->id)->where("id", $id)->first();
        }

        $countries = Country::orderBy("name", "asc")->get();
        return view("myarea.company", compact("menu","page", "website", "user", "company", "countries"));
    }

    public function company_save(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'address1' => 'required',
            'country_id' => 'required',
            'county' => 'required',
            'city' => 'required',
            //'fiscal_code_vat' => 'required',
        ],
            [
                "name.required" => "Nominativo campo obbligatorio",
                "address1.required" => "Indirizzo campo obbligatorio",
                "country_id.required" => "Nazione campo obbligatorio",
                "county.required" => "Provincia campo obbligatorio",
                "city.required" => "Città campo obbligatorio",
                "fiscal_code_vat.required" => "P.Iva campo obbligatorio"
            ]
        );


        if($request->get('company_id') != 0){
            $company = Company::where("user_id", \Session::get("user_id"))->where("id", $request->get('company_id'))->first();
            if($company){
                $company->name = $request->get('name');
                $company->business_name = $request->get('business_name');
                $company->address1 = $request->get('address1');
                $company->country_id = $request->get('country_id');
                $company->county = $request->get('county');
                $company->city = $request->get('city');
                $company->pec = $request->get('pec');
                $company->sdi = $request->get('sdi');
                $company->postal_code = $request->get('postal_code');
                $company->fiscal_code_vat = $request->get('fiscal_code_vat');
                $company->fiscal_code = $request->get('fiscal_code');
                $company->save();
            }
        }else{
            Company::insert([
                "name" => $request->get('name'),
                "business_name" => $request->get('business_name'),
                "address1" => $request->get('address1'),
                "county" => $request->get('county'),
                "city" => $request->get('city'),
                "fiscal_code_vat" => $request->get('fiscal_code_vat'),
                "fiscal_code" => $request->get('fiscal_code'),
                "country_id" => $request->get('country_id'),
                "pec" => $request->get('pec'),
                "sdi" => $request->get('sdi'),
                "postal_code" => $request->get('postal_code'),
                "user_id" => \Session::get('user_id'),
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        return redirect()->route("myarea.companies")->with("message", "Indirizzo salvato con successo");
    }

    public function company_delete($id){
        $user = User::find(\Session::get("user_id"));
        if(!$user){
            return redirect()->route("login");
        }

        $company = Company::where("user_id", $user->id)->where("id", $id)->first();
        if($company){
            $company->delete();
            return redirect()->route("myarea.companies")->with("message", "Indirizzo cancellato con successo");
        }

        return redirect()->route("myarea.companies");
    }

    public function message_save(Request $request){
        $user = User::find(\Session::get("user_id"));
        if(!$user){
            return redirect()->route("login");
        }

        $order_id = $request->get('order_id');
        $order = Order::find($order_id);
        if(!$order){
            return redirect()->back();
        }

        $user = User::find($order->user_id);
        if(!$user){
            return redirect()->back();
        }

        $object = $request->get('name_support');
        $content = $request->get('content');

        $item = PluginProductsContacts::first();

        $data = $request->except(['_token']);
        $vet_email = ["request" => $data];
        $dst_email = $item->email;

        try{
            \Mail::send("common.emails.contact", ['data' => $vet_email], function ($m) use ($dst_email, $item, $data, $object, $user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo($user->email, $user->first_name);
                $m->to($dst_email);
                if($item->cc){
                    $cc_email = explode(",", $item->cc);
                    $m->cc($cc_email);
                }

                if($item->ccn){
                    $ccn_email = explode(",", $item->ccn);
                    $m->bcc($ccn_email);
                }

                $m->subject("$object n.{$data['order_id']}");
            });
        }catch (\Throwable $e) {

        }

        PluginProductsRequests::create([
            "email" => $user->email,
            "order_id" => $order_id,
            "object" => "$object n.{$data['order_id']}",
            "content" => json_encode($data)
        ]);

        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();
        return redirect()->back()->with('message', $labels['richiesta-assistenza-inviata']);

    }

    public function order_detail(Request $request){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_order_detail";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }



        $id = $request->get('order_id');
        $order = Order::find($id);
        if(!$order){
            return redirect()->to("/");
        }

        if(\Auth::user()) {
            if ($order->user_id != \Auth::user()->id) {
                return redirect()->to("/");
            }
        }

        $order->load(["products", "payment", "status"]);
        $shipping = Address::withTrashed()->find($order->shipping_address_id);
        $billing = Company::withTrashed()->find($order->billing_company_id);
        $companies = Company::where("user_id", $user->id)->get();

        return view("myarea.order_detail", compact("menu","page", "website", "user", "companies", 'order', 'shipping','billing'));
    }

    public function reservation_detail(Request $request){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $index = new IndexController();
        $slug = "myarea_reservation_detail";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                return redirect()->to($page);
            }
        }

        $id = $request->get('reservation_id');
        $reservation = PluginBookingReservation::find($id);
        if(!$reservation){
            return redirect()->to("/");
        }

        if($reservation->is_hidden == 1){
            return redirect()->to("/");
        }

        if(\Auth::user()) {
            if ($reservation->user_id != \Auth::user()->id) {
                return redirect()->to("/");
            }
        }

       return view("myarea.reservation_detail", compact("menu","page", "website", "user", 'reservation'));
    }

    public function order_edit_payment(Request $request){
        $user = $this->check_user();
        if($user === null){
            \Auth::logout();
            \Session::forget("user_id");
            return redirect()->to("/");
        }

        $order_id = $request->get('order_id');
        $payment_id = $request->get('payment_id');

        $payment = Payment::find($payment_id);
        if($payment){
            $order = Order::find($order_id);
            $address = Address::where("id", $order->shipping_address_id)->first();
            $area = AreaCountry::where("country_id", $address->country_id)->first();


            if($order->paypal_payment_id === null){
                if($payment->is_contrassegno == 1){
                    $order->status_id = 1;

                    $shipContrassegno = Shipping::whereRaw("name like '%contrassegno%'")->first();
                    if($shipContrassegno){
                        if($area){
                            $shippingRange = ShippingRange::where("area_id", $area->area_id)->where("shipping_id", $shipContrassegno->id)
                                ->whereRaw("(min <= '{$order->total_tax}' AND max >= '{$order->total_tax}')")
                                ->first();
                            if($shippingRange){
                                $order->total_shipping_tax = $shippingRange->price;
                                $order->total_shipping = $order->total_shipping_tax / 1.22;
                            }
                        }

                        $order->shipping_id = $shipContrassegno->id;
                    }

                }else{
                    $order->status_id = 5;
                    if($area){
                        $shippingRange = ShippingRange::where("area_id", $area->area_id)
                            ->whereRaw("(min <= '{$order->total_tax}' AND max >= '{$order->total_tax}')")
                            ->first();
                        if($shippingRange){
                            $order->total_shipping_tax = $shippingRange->price;
                            $order->total_shipping = $order->total_shipping_tax / 1.22;
                        }
                    }
                }

                if($payment->is_contrassegno){
                    $order->total_payment_tax = $payment->price_contrassegno;
                }else{
                    $order->total_payment_tax = 0;
                }

                $order->payment_id = $payment_id;
                $order->save();
            }

        }

        return redirect()->back()->with('msg', 'Metodo di pagamento modificato con successo');
    }

}
