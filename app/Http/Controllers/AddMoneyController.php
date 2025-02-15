<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Models\Activity;
use App\Models\Address;
use App\Models\Category;
use App\Models\Client;
use App\Models\ClientCheckAdvice;
use App\Models\Company;
use App\Models\Country;
use App\Models\GiftCard;
use App\Models\GiftCardHistory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Package;
use App\Models\PackageCheck;
use App\Models\PluginBookingReservation;
use App\Models\PluginBookingSettings;
use App\Models\Product;
use App\Models\ShippingRange;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Srmklive\PayPal\Facades\PayPal;
use Validator;
use URL;
use Session;
use Input;
/** All Paypal Details class **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

class AddMoneyController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithPaypal()
    {

    }
    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {

        if(\Auth::user()) {
            $order = Order::where("user_id", \Auth::user()->id)
                ->where("id", $request->input('order_id'))
                ->first();
        }else{
            $order = Order::where("id", $request->input('order_id'))
                ->first();
        }

        if(!$order){
            dd("ordine non trovato");
        }

        \Session::put("order_id", $order->id);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName("Ordine n. {$order->id}") /** item name **/
        ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription("Ordine n. {$order->id}");
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status')) /** Specify return URL **/
        ->setCancelUrl(URL::route('payment.status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                /*\Session::put('error','Connection timeout');
                return Redirect::route('addmoney.paywithpaypal');*/
                 echo "Exception: " . $ex->getMessage() . PHP_EOL;
                 $err_data = json_decode($ex->getData(), true);
                 print_r($err_data);
                 exit;
            } else {
                /*\Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('addmoney.paywithpaypal');*/
                die('Some error occur, sorry for inconvenient');
            }
        }
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error','Unknown error occurred');
        return Redirect::route('addmoney.paywithpaypal');
    }
    public function getPaymentStatus()
    {
        if(!\Session::has('order_id')){
            dd("ordine non riconosciuto");
        }
        /** Get the payment ID before session clear **/
        $payment_id = \Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        \Session::forget('paypal_payment_id');

        if($payment_id === null){
            return Redirect::route('addmoney.paypal.error_paypal');
        }

        if (empty(\Illuminate\Support\Facades\Input::get('PayerID')) || empty(\Illuminate\Support\Facades\Input::get('token'))) {
            \Session::put('error','Payment failed');
            return Redirect::route('addmoney.paywithpaypal');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(\Illuminate\Support\Facades\Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);


        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {

            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            \Session::put('success','Payment success');

            if(\Session::has('order_id')){
                $order_id = \Session::get('order_id');
                $order = Order::where("id", $order_id)->first();
                if($order){
                    $order = Order::where("year_invoice", Carbon::now()->format('Y'))->orderBy("number_invoice", "desc")->first();
                    if(!$order){
                        $number = 1;
                    }else{
                        $number = $order->number_invoice + 1;
                    }

                    Order::where("id", $order_id)
                        ->update([
                            "status_id" => 1,
                            "paypal_payment_id" => $payment_id,
                            "number_invoice" => $number,
                            "year_invoice" => Carbon::now()->format('Y'),
                            "payment_date" => Carbon::now()->toDateTimeString()
                        ]);


                    //IN CASO DI ABBONAMENTO, CHE E' UNICO NEL CARRELLO
                    /*$subscription = OrderProduct::selectRaw("plugins_products.*")
                        ->join("plugins_products", "plugins_products.id", "=", "product_id")
                        ->where("order_id", $order_id)
                        ->where("is_subscription", 1)
                        ->first();

                    if($subscription){
                        $user = User::find($order->user_id);

                        if(!$user->subscription_id){
                            $user->subscription_id = $subscription->id;
                            $user->subscription_start = Carbon::now()->toDateString();
                            $user->subscription_end = Carbon::now()->addDays($subscription->subscription_days)->toDateString();
                            $user->save();
                        }else{
                            $now = Carbon::now();
                            $date_end = Carbon::createFromFormat("Y-m-d", $user->subscription_end);

                            $diff = $date_end->diffInDays($now);
                            $user->subscription_id = $subscription->id;
                            $user->subscription_end = Carbon::now()->addDays($subscription->subscription_days + $diff)->toDateString();
                            $user->save();
                        }
                    }*/
                }

                \Session::forget('order_id');
                return redirect()->route('myarea.orders');
            }

            return Redirect::route('addmoney.paywithpaypal');
        }else{
            dd($result->getState());
        }
        \Session::put('error','Payment failed');
        //return Redirect::route('addmoney.paywithpaypal');
    }

    public function error_paypal(){
        $theme = env('THEME');

        $CLASS = new IndexController();
        $categories = $CLASS->get_categories_menu();

        $categories_orizz = Category::where("in_menu",1)->get();

        $payments = \App\Models\Payment::where("id", 1)->get();

        return view("{$theme}.paypal_error", compact('theme','categories','payments','categories_orizz'));

    }

    public function paypal_transaction_complete(Request $request){
        $payment_id = $request->get('orderID');
        $order_id = $request->get('order_id');
        $details = $request->get('details');

        $order = Order::where("id", $order_id)->first();
        if($order){
            $order = Order::where("year_invoice", Carbon::now()->format('Y'))->orderBy("number_invoice", "desc")->first();
            if(!$order){
                $number = 1;
            }else{
                $number = $order->number_invoice + 1;
            }

            if($payment_id){
                Order::where("id", $order_id)
                    ->update([
                        "status_id" => 1,
                        "paypal_payment_id" => $payment_id,
                        "number_invoice" => $number,
                        "result_paypal" => $details,
                        "year_invoice" => Carbon::now()->format('Y'),
                        "payment_date" => Carbon::now()->toDateTimeString()
                    ]);
            }
        }
    }

    public function paypal_transaction_complete_booking(Request $request){
        $payment_id = $request->get('orderID');
        $order_id = $request->get('order_id');
        $details = $request->get('details');

        $order = PluginBookingReservation::where("id", $order_id)->first();
        if($order){
            $order = PluginBookingReservation::where("year", Carbon::now()->format('Y'))->orderBy("number_invoice", "desc")->first();
            if(!$order){
                $number = 1;
            }else{
                $number = $order->number_invoice + 1;
            }

            if($payment_id){
                $setting = PluginBookingSettings::first();

                PluginBookingReservation::where("id", $order_id)
                    ->update([
                        "is_payed" => 1,
                        "plugin_booking_status_id" => $setting->default_status_id,
                        "paypal_payment_id" => $payment_id,
                        "number_invoice" => $number,
                        "result_paypal" => $details,
                        "year" => Carbon::now()->format('Y'),
                        "payment_date" => Carbon::now()->toDateTimeString()
                    ]);


                PluginBookingReservation::where("parent_id", $order_id)
                    ->update([
                        "is_payed" => 1,
                        "plugin_booking_status_id" => $setting->default_status_id,
                        "paypal_payment_id" => $payment_id,
                        "number_invoice" => $number,
                        "result_paypal" => $details,
                        "year" => Carbon::now()->format('Y'),
                        "payment_date" => Carbon::now()->toDateTimeString()
                    ]);
            }
        }
    }

    public function paypal_transaction_error(Request $request){
        $detail = $request->get('details');
        $order_id = $request->get('order_id');

        $theme  = env('THEME');
        $destinatario = "Keivantg@gmail.com";
        \Mail::send("$theme.emails.paypal_error", ['data' => $detail, "order_id" => $order_id], function ($m) use ($destinatario) {
            $m->to($destinatario)->subject("PAYPAL ERROR ECOMMERCE");
        });

    }

}
