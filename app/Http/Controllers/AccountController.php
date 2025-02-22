<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\Company;
use App\Models\PluginBookingSettings;
use App\Models\PluginInvitations;
use App\Models\PluginProducts;
use App\Models\PluginProductsLabels;
use App\Models\ShopSettings;
use App\Models\WebsiteSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Facades\Socialite;

class AccountController extends Controller
{
    public $theme;

    public function __construct()
    {
        $this->theme = env('TEMA');
    }


    public function loginProcess(Request $request)
    {
        $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ],
            [
                "email.required" => "Email campo obbligatorio",
                "password.required" => "Password campo obbligatorio",
            ]
        );

        $credentials = $request->only('email', 'password');
        $user = User::where("email", $request->get('email'))->first();
        if(!$user){
            return redirect()->back()->withErrors([@$labels['utente-non-riconosciuto']]);
        }

        if($user->active == 0){
            return redirect()->back()->withErrors([@$labels['utente-non-attivo']]);
        }

        if (\Auth::attempt($credentials)) {
            \Session::put("user_id", $user->id);

            if(\Session::has("cart.products")){
                $products = \Session::get('cart.products');
                if($products){
                    foreach ($products as $product){
                        Cart::insert([
                            "product_id" => $product->product_id,
                            "user_id" => $user->id,
                            "qty" => $product->qty,
                            "price" => $product->price,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }
                }

                \Session::forget('cart.products');
            }

            //invitations
            $check = PluginInvitations::where("email", $user->email)->first();
            if($check){
                if($check->is_login == 0){
                    $check->is_login = 1;
                    $check->login_at = Carbon::now()->toDateTimeString();
                    $check->save();
                }
            }

            $result = Cart::where("user_id", $user->id)->get()->toArray();
            if(count($result) > 0){
                return redirect()->route('checkout');
            }

            /*if(\Session::get('redirect_to_checkout') === true){
                \Session::forget('redirect_to_checkout');
                return redirect()->to('/checkout_new');
            }*/

            if(env('PROJECT_NAME') == "Maison-Flaneur"){
                $lang = \App::getLocale();
                return redirect()->route("pluginProducts.$lang");
            }

            return redirect()->route('myarea.dashboard');
        }

        return redirect()->back()->withErrors([@$labels['password-non-riconosciuta']]);
    }

    public function registerProcess(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'check_privacy' => 'required',
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3',
        ],
            [
                "name.required" => "Nome campo obbligatorio",
                "email.required" => "Email campo obbligatorio",
                "mobile.required" => "Telefono campo obbligatorio",
                "check_privacy.required" => "Accettazione privacy policy campo obbligatorio",
                "password.required" => "Password campo obbligatorio",
                "password_confirmation.required" => "Conferma Password campo obbligatorio"
            ]
        );

        $user = User::where("email", $request->input('email'))->first();
        if($user){
            return redirect()->back()->withErrors(['Account già esistente!']);
        }

        $code = unique_random("users", "code", "25");

        $shopSetting = ShopSettings::first();

        $user = User::create([
            "name" => trim($request->input('name')),
            "email" =>  trim($request->input('email')),
            "mobile" =>  trim($request->input('mobile')),
            "password" =>  trim(bcrypt($request->input('password'))),
            "code" => $code,
            "check_privacy" => $request->input('check_privacy'),
            "check_newsletter" => $request->input('check_newsletter'),
            "text_privacy" => $shopSetting->text_privacy,
            "text_cookie" => $shopSetting->text_cookie,
            "date_newsletter" => $request->input('check_newsletter') ? Carbon::now()->toDateTimeString() : null,
            "active" => 0,
            "type_client" => 0
        ]);


        $role_id = $shopSetting->role_default_register;
        $check = \DB::table('model_has_roles')->where("role_id", $role_id)->where("model_id", $user->id)->first();
        if(!$check){
            \DB::table('model_has_roles')->insert([
                "role_id" => $role_id,
                "model_type" => "App\User",
                "model_id" => $user->id
            ]);
        }

        $vet_email = ["code_activation" => $code, 'user' => $user];
        $destinatario = $request->input('email');


        $setting = null;
        $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->first();
        if($adminPlugin){
            $setting = ShopSettings::first();
        }

        $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
        if($adminPluginBooking){
            $setting = PluginBookingSettings::first();
        }

        \Mail::send("common.emails.register", ['data' => $vet_email], function ($m) use ($destinatario, $setting) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));

            if($setting){
                if($setting->ccn_registered){
                    $emails = explode(",", $setting->ccn_registered);

                    if(count($emails)){
                        foreach ($emails as $k=>$temp_email){
                            $emails[$k] = trim($temp_email);
                        }
                        $m->bcc($emails);
                    }
                }
            }

            $m->to($destinatario)->subject("Registrazione account");
        });

        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();



        return redirect()->back()
            ->with('message', @$labels['register-message'])
            ->with('submessage', @$labels['register-submessage']);
    }

    public function registerProcessFull(Request $request){
        $authUser = User::withTrashed()->where('email', $request->get('email_access'))->first();
        $code = unique_random("users", "code", "25");

        if($authUser){
            if($authUser->deleted_at !== null){
                $authUser->deleted_at = null;
                $authUser->save();
            }

            return redirect()->back()->withErrors(["Utente già registrato. Recupera la tua password."]);

            //\Auth::loginUsingId($authUser->id);
            //\Session::put("user_id", $authUser->id);
        }else{

            //$code_psw = $request->input('password');
            $authUser = User::create([
                "name" => "{$request->input('first_name')} {$request->input('last_name')}",
                "email" => trim($request->input('email_access')),
                "password" => trim(bcrypt($request->input('password'))),
                "code" => $code,
                "plugin_product_id" => $request->input('plugin_product_id'),
                "check_privacy" => $request->input('check_privacy'),
                "check_newsletter" => $request->input('check_newsletter'),
                "active" => 0,
                "type_client" => $request->input('type_client')
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

           // \Auth::loginUsingId($authUser->id);
            //\Session::put("user_id", $authUser->id);
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
            "user_id" => $authUser->id,
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

        $count_fatturazione = Company::where("user_id", $authUser->id)->count();
        if($count_fatturazione == 0){
            if($request->has('name')){
                $name = $request->get('name');
                $business_name = $request->get('business_name');
                $country_id = $request->get('country_id_fatt');
                $province = $request->get('province_fatt');
                $address = $request->get('address_fatt');
                $fiscal_code_vat = $request->get('fiscal_code_vat');
                $city_name = $request->get('city_fatt');
                $pec = $request->get('pec');
                $sdi = $request->get('sdi');
                $postal_code = $request->get('postal_code_fatt');
                $number_street = $request->get('number_street_fatt');

                $company_client = Company::create([
                    "user_id" => $authUser->id,
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
                    "user_id" => $authUser->id,
                    "name" => "$first_name $last_name",
                    "business_name" => "$first_name $last_name",
                    "country_id" => $country_id,
                    "county" => $province,
                    "address1" => $address,
                    "fiscal_code_vat" => null,
                    "fiscal_code" => $request->get('fiscal_code'),
                    "postal_code" => $request->get('zip'),
                    "pec" => null,
                    "sdi" => null,
                    "city" => $city_name,
                    "number_street" => $number_street,
                    "custom_fields_checkout" => $request->has('custom_fields') ? json_encode($request->get('custom_fields')) : null
                ]);
            }
        }else{
            $company_client = Company::where("user_id", $authUser->id)->first();
        }

        $vet_email = ["code_activation" => $code, 'user' => $authUser];
        $destinatario = $request->input('email_access');


        $setting = null;
        $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->first();
        if($adminPlugin){
            $setting = ShopSettings::first();
        }

        $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
        if($adminPluginBooking){
            $setting = PluginBookingSettings::first();
        }

        \Mail::send("common.emails.register", ['data' => $vet_email], function ($m) use ($destinatario, $setting) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));

            if($setting){
                if($setting->ccn_registered){
                    $emails = explode(",", $setting->ccn_registered);

                    if(count($emails)){
                        foreach ($emails as $k=>$temp_email){
                            $emails[$k] = trim($temp_email);
                        }
                        $m->bcc($emails);
                    }
                }
            }

            $m->to($destinatario)->subject("Registrazione account");
        });

        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();

        return redirect()->back()
            ->with('message', @$labels['register-message'])
            ->with('submessage', @$labels['register-submessage']);


    }

    public function auto_login_subscriptions($code, Request $request){
        $user = User::where("code", $code)->first();
        if($user){
            \Auth::loginUsingId($user->id);
            \Session::put("user_id", $user->id);

            $ids = $request->get('ids');
            $v_ids = explode(",", $ids);

            $products = PluginProducts::whereIn("id", $v_ids)->get();

            Cart::where("user_id", $user->id)->delete();
            if($products){
                foreach ($products as $product){
                    Cart::insert([
                        "product_id" => $product->id,
                        "user_id" => $user->id,
                        "qty" => count($v_ids),
                        "price" => $product->price,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }

            return redirect()->route('checkout');
        }

        return redirect()->route('login');
    }

    public function activate($code, Request $request){
        //$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

        $user = User::where("code", $code)->first();
        if($user){
            $user->active = 1;
            $user->save();

            //invitations
            $check = PluginInvitations::where("email", $user->email)->first();
            if($check){
                backpack_auth()->login($user);

                if($check->is_login == 0){
                    $check->is_login = 1;
                    $check->login_at = Carbon::now()->toDateTimeString();
                    $check->save();

                    $role = \DB::table('model_has_roles')->where("model_id", $user->id)->first();
                    if($role->role_id == 7){
                        \Auth::loginUsingId($user->id);
                        \Session::put("user_id", $user->id);

                        return redirect()->to("/admin");
                    }

                    //invio email
                    /*$password = \Str::random("8");
                    $user->password = bcrypt($password);
                    $user->save();

                    $vet_email = ["code_activation" => $user->code, "password" => $password, "email" => $user->email, "country_id" => $user->country_id];
                    $destinatario = $user->email;

                    \Mail::send("common.emails.register_plugin_invitations", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));

                        if($user->country_id == config('config.default_country_user_it')){
                            $m->to($destinatario)->subject("Le tue credenziali");
                        }else{
                            $m->to($destinatario)->subject("Your credentials");
                        }
                    });*/
                }
            }

            \Auth::loginUsingId($user->id);
            \Session::put("user_id", $user->id);

            if(\Session::has("cart.products")){
                $products = \Session::get('cart.products');
                if($products){
                    foreach ($products as $product){
                        Cart::insert([
                            "product_id" => $product->product_id,
                            "user_id" => $user->id,
                            "qty" => $product->qty,
                            "price" => $product->price,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }
                }

                \Session::forget('cart.products');
            }

            if(\Session::get('redirect_to_checkout') === true){
                \Session::forget('redirect_to_checkout');
                return redirect()->to('/checkout_new');
            }

            if(env('PROJECT_NAME') == "Maison-Flaneur"){
                $lang = \App::getLocale();
                return redirect()->route("pluginProducts.$lang");
            }

            if($user->plugin_product_id){
                $product = PluginProducts::find($user->plugin_product_id);

                $cat_prod_slug = "no-categoria";
                $cat_prod = $product->category();
                if($cat_prod){
                    $cat_prod_slug = $cat_prod->slug;
                }

                return redirect()->route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$product->slug]);
            }

            return redirect()->route('myarea.dashboard');
        }

        return redirect()->route('login');
    }

    public function logout(){
        \Auth::logout();
        \Session::forget("user_id");
        return redirect()->to("/");
    }

    public function changePasswordProcess(Request $request){
        $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

        $this->validate($request, [
            'code' => 'required',
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3'
        ],
            [
                "code.required" => "Code campo obbligatorio",
                "password.required" => "Password campo obbligatorio",
                "password_confirmation.required" => "Conferma Password campo obbligatorio"
            ]
        );

        $user = User::where("code", trim($request->input('code')))->first();
        if($user){
            $user->password = trim(bcrypt($request->input('password')));
            $user->save();

            return redirect()->route('login')->with('message', "Password cambiata con successo!");
        }else{
            return redirect()->route('login')->with('noUser', @$labels['utente-non-riconosciuto']);
        }
    }


    public function recoveryProcess(Request $request){
        $labels = \App\Models\Label::get()->pluck("value", "key")->toArray();

        $this->validate($request, [
            'email' => 'required|email'
        ],
            [
                "email.required" => "Email campo obbligatorio",
            ]
        );



        $user = User::where("email", trim($request->input('email')))->first();
        if($user){
            $vet_email = ["code_activation" => $user->code];
            $destinatario = $request->input('email');

            \Mail::send("common.emails.recovery", ['data' => $vet_email], function ($m) use ($destinatario) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $m->to($destinatario)->subject("Recupera password");
            });

            if($request->has('ajax')){
                return response()->json([
                    "error" => 0,
                    "message" => "Inviata procedura per email",
                ]);
            }else{
                return redirect()->route('recovery_password')->with('message', "Inviata procedura per email");
            }

        }else{
            if($request->has('ajax')){
                return response()->json([
                    "error" => 1,
                    "message" => "Utente non riconosciuto",
                ]);
            }else{
                return redirect()->route('recovery_password')->with('noUser', @$labels['utente-non-riconosciuto']);
            }

        }

    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
            if(trim($user->email) == "" || !$user->email){
                return redirect()->route('error_facebook');
            }

            $authUser = $this->findOrCreateUser($user, $provider);
            \Session::put('user_id', $authUser->id);

            if(\Session::has("cart.products")){
                $products = \Session::get('cart.products');
                if($products){
                    foreach ($products as $product){
                        Cart::insert([
                            "product_id" => $product->product_id,
                            "user_id" => $authUser->id,
                            "qty" => $product->qty,
                            "price" => $product->price,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }
                }

                \Session::forget('cart.products');
            }

            if(\Session::get('redirect_to_checkout') === true){
                \Session::forget('redirect_to_checkout');
                return redirect()->route('checkout');
            }

            return redirect()->route('myarea.dashboard');
        } catch (\Exception $e) {
            return redirect()->route('error_facebook');
        }
    }

    public function error_facebook(){
        $index = new IndexController();
        $slug = "error_facebook";
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();
        $page = $index->check_page($slug);
        if(is_string($page)){
            return redirect()->to($page);
        }

        return view("error_facebook", compact("menu","page", "website"));
    }

    public function google_sign(Request $request)
    {
        $user = new \stdClass();
        $user->id = $request->get('user_id');
        $user->email = $request->get('user_email');
        $user->name = $request->get('user_name');
        $authUser = $this->findOrCreateUser($user, "google");

        if(\Session::has("cart.products")){
            $products = \Session::get('cart.products');
            if($products){
                foreach ($products as $product){
                    Cart::insert([
                        "product_id" => $product->product_id,
                        "user_id" => $authUser->id,
                        "qty" => $product->qty,
                        "price" => $product->price,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
            \Session::forget('cart.products');
        }

        \Session::put('user_id', $authUser->id);
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();

        if ($authUser) {
            \Auth::loginUsingId($authUser->id);
            \Session::put("user_id", $authUser->id);
            return $authUser;
        }

        $code = unique_random("users", "code", "25");

        $authUser = User::where("email", $user->email)->first();

        if(!$authUser) {
            $authUser = User::create([
                "name" => $user->name,
                "email" => $user->email,
                "password" => bcrypt("12345678"),
                'provider' => $provider,
                'provider_id' => $user->id,
                "code" => $code,
                "active" => 1
            ]);

        }else{
            if($authUser->deleted_at){
                $authUser->deleted_at = null;
            }

            $authUser->provider = $provider;
            $authUser->provider_id = $user->id;
            $authUser->active = 1;
            $authUser->save();
        }

        $shopSetting = ShopSettings::first();
        $role_id = $shopSetting->role_default_register;

        $check = \DB::table('model_has_roles')->where("role_id", $role_id)->where("model_id", $authUser->id)->first();
        if(!$check){
            \DB::table('model_has_roles')->insert([
                "role_id" => $role_id,
                "model_type" => "App\User",
                "model_id" => $authUser->id
            ]);
        }

        \Auth::loginUsingId($authUser->id);
        \Session::put("user_id", $authUser->id);

        return $authUser;
    }

}
