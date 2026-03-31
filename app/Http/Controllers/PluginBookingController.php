<?php


namespace App\Http\Controllers;


use App\Http\Requests\PluginProductsRequest;
use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\BlockContact;
use App\Models\BlockNews;
use App\Models\Cart;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\PluginBookingReservation;
use App\Models\PluginBookingReservationRoom;
use App\Models\PluginBookingReservationRoomCheckin;
use App\Models\PluginBookingReservationService;
use App\Models\PluginBookingRoom;
use App\Models\PluginBookingRoomAddictions;
use App\Models\PluginBookingRoomPrices;
use App\Models\PluginBookingRoomPromos;
use App\Models\PluginBookingRoomServices;
use App\Models\PluginBookingServices;
use App\Models\PluginBookingSettings;
use App\Models\PluginBookingType;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsContacts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsImagesSize;
use App\Models\PluginProductsLabels;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use App\Models\PluginProductsRequests;
use App\Models\PluginProductsSettings;
use App\Models\Promotion;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use App\Models\ShopSettings;
use App\Models\WebsiteSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;
use Spatie\Permission\Models\Role;

class PluginBookingController extends Controller
{

    public function hidden(Request $request){

        \Session::forget("buy");

        $obj = new \stdClass();
        $obj->type = $request->get('type');
        $obj->out = 1;
        \Session::put("buy", $obj);

        $lang = \App::getLocale();

        $html = $this->get_rooms($request, 1);

        if(\Session::has('buy')){
            $session = \Session::get('buy');
            $session->out = 1;
            $session->html = $html;
            \Session::put("buy", $session);
        }

        return redirect()->route("pluginBooking.$lang");
    }

    public function index(Request $request)
    {
       /* if(\Session::has('buy')){
            \Session::forget('buy');
            return redirect()->route("pluginBooking.$lang");
        }*/

        $thema = env('TEMA');
        $index = new IndexController();
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();

        $plugin = PluginBookingSettings::first();

        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_booking = env("PLUGIN_BOOKING_URL_$lang_");

        if($request->has('r')){
            if(\Session::has('buy')){
                \Session::forget('buy');
                return redirect()->route("pluginBooking.$lang");
            }
        }

        $page = Page::whereRaw("slug like '%$slug_booking%'")->where("is_active", 1)->first();
        if(!$page){
            return redirect()->to("/");
        }

        if($request->has('type_id')){
            $obj = new \stdClass();
            $obj->type = $request->get('type_id');
            $obj->start = $request->get('start');
            $obj->qty = $request->get('letti');
            $obj->qty_bimbi = $request->get('letti_bimbi');

            if($request->has('end')){
                $obj->end = $request->get('end');
            }

            if($request->has('start_time')){
                $obj->start_time = $request->get('start_time');
            }

            if($request->has('end_time')){
                $obj->end_time = $request->get('end_time');
            }

            $obj->html = "";

            \Session::put("buy", $obj);

        }

        return view("$thema.plugins.pluginBooking.index", compact('menu', 'page','website', 'plugin'));
    }

    public function register(Request $request)
    {
        $thema = env('TEMA');
        $index = new IndexController();
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();

        $plugin = PluginBookingSettings::first();

        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_booking = env("PLUGIN_BOOKING_URL_$lang_");

        $page = Page::whereRaw("slug like '%$slug_booking%'")->where("is_active", 1)->first();
        if(!$page){
            return redirect()->to("/");
        }

        return view("$thema.plugins.pluginBooking.register", compact('menu', 'page','website', 'plugin'));
    }

    public function riassume(Request $request)
    {
        $thema = env('TEMA');
        $index = new IndexController();
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();

        $plugin = PluginBookingSettings::first();

        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_booking = env("PLUGIN_BOOKING_URL_$lang_");

        $page = Page::whereRaw("slug like '%$slug_booking%'")->where("is_active", 1)->first();
        if(!$page){
            return redirect()->to("/");
        }

        $session = null;
        if(\Session::has('buy')){
            $session = \Session::get('buy');
        }

        $user = User::find(\Session::get("user_id"));

        $reservation = PluginBookingReservation::where("user_id", $user->id)
            ->orderBy("id", "desc")
            ->first();


        if($reservation){
            $session = (object) json_decode($reservation->sessione,true);
            $session->reservation_id = $reservation->id;
            \Session::put('buy', $session);
        }

        if($session == null){
            return redirect()->to("/$slug_booking");
        }

        return view("$thema.plugins.pluginBooking.riassume", compact('menu', 'page','website', 'plugin', 'session'));
    }

    public function order($id, Request $request)
    {
        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_booking = env("PLUGIN_BOOKING_URL_$lang_");

        if(!\Session::has('user_id')){
            return redirect()->to("/$slug_booking");
        }

        $reservation = PluginBookingReservation::where("id", $id)->where("user_id", \Session::get('user_id'))->first();
        if(!$reservation){
            return redirect()->to("/$slug_booking");
        }

        $thema = env('TEMA');
        $index = new IndexController();
        $website = WebsiteSetting::first();
        $menu = $index->get_menu();

        $plugin = PluginBookingSettings::first();

        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_booking = env("PLUGIN_BOOKING_URL_$lang_");

        $page = Page::whereRaw("slug like '%$slug_booking%'")->where("is_active", 1)->first();
        if(!$page){
            return redirect()->to("/");
        }

        return view("$thema.plugins.pluginBooking.order", compact('menu', 'page','website', 'plugin', 'reservation'));
    }

    public function choose_type(Request $request){
        $thema = env('TEMA');

        $obj = new \stdClass();
        $obj->type = $request->get('type');
        $obj->total = 0;

        \Session::put("buy", $obj);

        $type = PluginBookingType::where("id", $request->get('type'))->first();

        $start = \Carbon\Carbon::now()->toDateString();
        $end = \Carbon\Carbon::now()->toDateString();
        $letti = 1;


        $html = \View::make("$thema.plugins.pluginBooking.inc.box_date", compact('type','start', 'end', 'letti'))->render();

        return response()->json([
            "html" => $html,
            "step_partecipanti" => $type->is_checkin,
            "session" => $obj
        ]);
    }

    public function get_rooms(Request $request, $html_get = null)
    {

        try{
            $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();

            $thema = env('TEMA');

            $start = $request->get('start');

            if($start == null || trim($start) == ""){
                return false;
            }

            if($start == "undefined"){
                $start = null;
            }

            $end = $request->get('end');
            if($end == null || trim($end) == ""){
                return false;
            }

            if($end == "undefined"){
                $end = null;
            }

            $start_time = $request->get('start_time');
            if($start_time == "undefined"){
                $start_time = null;
            }

            $end_time = $request->get('end_time');
            if($end_time == "undefined"){
                $end_time = null;
            }


            $letti = $request->get('letti');
            $letti_bimbi = $request->get('letti_bimbi');

            $type = $request->get('type');

            if(\Session::has('buy')){
                $session = \Session::get('buy');
                if($start){
                    $session->start = Carbon::createFromFormat("d-m-Y", $start)->format("Y-m-d");
                }else{
                    $session->start = null;
                }

                $session->html = "";

                if($end){
                    $session->end = Carbon::createFromFormat("d-m-Y", $end)->format("Y-m-d");
                }else{
                    $session->end = null;
                }

                $session->start_time = $start_time;
                $session->end_time = $end_time;
                $session->qty = $letti;
                $session->qty_bimbi = $letti_bimbi;
                $session->room_id = null;
                $session->days = [];
                $session->days_promo = [];
                $session->services = [];
                $session->partecipants = [];
                \Session::put("buy", $session);
            }


            $rooms = PluginBookingRoom::where("plugin_booking_type_id", $type)
                //->where("id", 4)
                ->where("is_active",1)
                ->get();


            $start_ = null;
            if($start){
                $start_ = Carbon::createFromFormat("d-m-Y", $start);
            }

            $end_ = null;
            if($end){
                $end_ = Carbon::createFromFormat("d-m-Y", $end);
            }

            $diff_day = 1;
            $start_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start);
            if($session->end){
                $end_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->end);
                $diff_day = $start_carbon->diffInDays($end_carbon);
                if($diff_day == 0){
                    $diff_day = 1;
                }
            }

            $v_days = [];
            $v_days[] = $start_carbon->format("Y-m-d");
            for ($i=1; $i<$diff_day; $i++){
                $v_days[] = $start_carbon->addDay()->format("Y-m-d");
            }



            $status_confermati = \App\Models\PluginBookingStatus::where("is_unblock","!=", 1)->get()->pluck("id", "id")->toArray();

            if($rooms){
                foreach ($rooms as $k=>$room){
                    if($room->qty_bambini > 0){
                        if($letti_bimbi > $room->qty_bambini){
                            $room->is_disp = 0;
                            $room->msg_disp = "Max <strong>$room->qty_bambini</strong> {$labels['booking-prenota-bambini-per-camera']}";
                            continue;
                        }
                    }else{
                        if($room->qty_bambini == 0){
                            if($letti_bimbi > 0){
                                $room->is_disp = 0;
                                $room->msg_disp = "{$labels['booking-prenota-lettini-non-disponibili']}";
                                continue;
                            }
                        }
                    }

                    $room->msg_disp = "";
                    $session->listino_vet[$room->id] = "";

                    $sql_special = "";
                    if($type == 2){ //APPARTAMENTI
                        $sql_special = "AND (min_day <= $diff_day && max_day >= $diff_day)";
                    }

                    //controllo prenotazione
                    $check_reservation = null;
                    $res_ids = \App\Models\PluginBookingReservationRoom::where("plugin_booking_room_id", $room->id)
                        ->pluck("plugin_booking_reservation_id", "plugin_booking_reservation_id")
                        ->toArray();

                    if(count($res_ids)){
                        if($session->end){
                            $sql_add = "";
                            if($session->end_time){
                                $sql_add = "AND end_time = '$session->end_time'";
                            }

                            /*$session->start = "2025-04-08";
                            $session->end = "2025-04-21";
                            dump("DAL $session->start AL $session->end");*/

                            $check_res_start = Carbon::createFromFormat("Y-m-d", $session->start)->subDay();
                            $check_res_end = Carbon::createFromFormat("Y-m-d", $session->end);
                            $check_diff = $check_res_start->diffInDays($check_res_end);


                            $prenotabile = 1;
                            for($i=0;$i<$check_diff;$i++){

                                $check_date = $check_res_start->addDay()->format("Y-m-d");
                                //dump($check_date);

                                if(count($status_confermati)) {
                                    $check_r_list = \App\Models\PluginBookingReservation::whereRaw("(date_start <= '$check_date' AND date_end >= '$check_date' $sql_add)")
                                        ->whereIn("id", $res_ids)
                                        ->whereIn("plugin_booking_status_id", $status_confermati)
                                        ->get();
                                }else {
                                    $check_r_list = \App\Models\PluginBookingReservation::whereRaw("(date_start <= '$check_date' AND date_end >= '$check_date' $sql_add)")
                                        ->whereIn("id", $res_ids)
                                        ->get();
                                }

                                if(count($check_r_list) == 0){
                                    continue;
                                }

                                foreach ($check_r_list as $check_r){
                                    if($check_date == $session->end){ //se il giorno in questione è la mia data di checkout
                                        //controllo se la prenotazione già avvenuta
                                        if($check_r->date_start == $check_date){ //se  check-in prenotazione già avvenuta coincide con checkout
                                            $prenotabile = 1;
                                        }
                                    }else{
                                        if($check_date == $check_r->date_end){
                                            $prenotabile = 1;
                                        }else{
                                            $check_reservation = $check_r;
                                            $prenotabile = 0;
                                            break;
                                        }
                                    }

                                    //dump($check_date, $check_r->id, "dal $check_r->date_start al $check_r->date_end", $prenotabile);
                                }

                                if($prenotabile == 0){
                                    break;
                                }
                            }

                            //dd($prenotabile);

                            if($prenotabile > 0){
                                //echo "Prenotabile";
                                $check_reservation = null;
                            }
                        }else{
                            $sql_add = "";
                            if($session->start_time){
                                $sql_add = "AND start_time = '$session->start_time'";
                            }

                            if(count($status_confermati)){
                                $check_reservation = \App\Models\PluginBookingReservation::whereRaw("(date_start = '$session->start' $sql_add)")
                                    ->whereIn("id", $res_ids)
                                    ->whereIn("plugin_booking_status_id", $status_confermati)
                                    ->first();
                            }else{
                                $check_reservation = \App\Models\PluginBookingReservation::whereRaw("(date_start = '$session->start' $sql_add)")
                                    ->whereIn("id", $res_ids)
                                    ->first();
                            }
                        }
                    }


                    if($check_reservation){
                        $room->is_disp = 0;
                        $check_res_start = Carbon::createFromFormat("Y-m-d", $check_reservation->date_start)->format("d/m/Y");
                        $check_res_end = Carbon::createFromFormat("Y-m-d", $check_reservation->date_end)->format("d/m/Y");
                        $room->msg_disp = "<strong>$check_res_start - $check_res_end</strong> {$labels['booking-prenota-gia-prenotata']}";
                        continue;
                    }

                    foreach ($v_days as $day_item){
                        $final_price = 0;
                        $session->days[$day_item] = 0;

                        $prices = PluginBookingRoomPrices::where("plugin_booking_room_id", $room->id)
                            ->whereRaw("(min <= $letti && max >= $letti) $sql_special")
                            //->whereRaw("((date_start <= '$day_item' AND date_end >= '$day_item'))")
                            ->get();

                        if(count($prices) == 0){
                            unset($rooms[$k]);
                            continue;
                        }

                        $promos = PluginBookingRoomPromos::where("plugin_booking_room_id", $room->id)
                            ->whereRaw("((date_start <= '$day_item' AND date_end > '$day_item'))")
                            ->orderBy("lft", "asc")
                            ->get();


                        if(count($prices) == 0){
                            $room->is_disp = 0;
                        }else{
                            $room->is_disp = 1;

                            foreach ($prices as $price){
                                if($price->date_start && $price->date_end) {
                                    $day_carbon = Carbon::createFromFormat("Y-m-d", $day_item);

                                    if($price->all_years == 1){
                                        $temp_start = explode("-", $price->date_start);
                                        $year_start = $temp_start[0];

                                        $temp_start_day = explode("-", $day_item);
                                        $temp_start[0] = $temp_start_day[0];
                                        $data_start = Carbon::createFromFormat("Y-m-d", implode("-", $temp_start));

                                        $temp_end = explode("-", $price->date_end);
                                        $year_end = $temp_end[0];

                                        $temp_end_choose = explode("-", $day_item);

                                        if($year_start == $year_end){
                                            $temp_end[0] = $temp_start[0];
                                        }else{
                                            $temp_end[0] = $temp_end_choose[0] + 1;
                                        }

                                        $data_end = Carbon::createFromFormat("Y-m-d", implode("-", $temp_end));

                                        if (($day_carbon->gte($data_start) && $day_carbon->lt($data_end))) {
                                            $disp_date = 1;
                                            $room->is_disp = $disp_date;

                                            $final_price = $final_price + $price->price;

                                            if($room->qty_bambini > 0 && $letti_bimbi > 0){
                                                $total_bimbo = ($letti_bimbi * $room->price_bambini) * 1;
                                                $final_price = $final_price + $total_bimbo;
                                            }
                                        }else{
                                            continue;
                                        }
                                    }else{
                                        $data_start = Carbon::createFromFormat("Y-m-d", $price->date_start);
                                        $data_end = Carbon::createFromFormat("Y-m-d", $price->date_end);

                                        if (($day_carbon->gte($data_start) && $day_carbon->lt($data_end))) {
                                            $disp_date = 1;
                                            $room->is_disp = $disp_date;

                                            $final_price = $final_price + $price->price;

                                            if($room->qty_bambini > 0 && $letti_bimbi > 0){
                                                $total_bimbo = ($letti_bimbi * $room->price_bambini) * 1;
                                                $final_price = $final_price + $total_bimbo;
                                            }
                                        }else{
                                            continue;
                                        }
                                    }
                                }
                            }

                            $room->price = $final_price;
                            $room->promo_price = $final_price;

                            //controllo se sta una promo

                            $is_in_promo = 0;
                            if(count($promos)){
                                foreach ($promos as $promo){
                                    $data_start = Carbon::createFromFormat("Y-m-d", $promo->date_start);
                                    $data_end = Carbon::createFromFormat("Y-m-d", $promo->date_end);

                                    if (($start_->gte($data_start) && $start_->lte($data_end)) || $end_->gte($data_start) && $end_->lte($data_end)) {
                                        $is_in_promo = 1;
                                    }else{
                                        $is_in_promo = 0;
                                    }



                                    if($is_in_promo == 1){
                                        switch ($promo->condition_discount){
                                            case 0:
                                                if($promo->type_discount == 0){ // euro
                                                    $room->promo_price -= $promo->discount;
                                                }else{
                                                    $calc = $room->price - (($room->price * (100 - $promo->discount)) / 100);
                                                    $room->promo_price -= $calc;
                                                }
                                                break;
                                            case 1:
                                                if($end_){
                                                    $diff_days = $end_->diffInDays($start_);
                                                    switch ($promo->rule_discount){
                                                        case 0: //uguale
                                                            if($diff_days == $promo->value_discount){
                                                                if($promo->type_discount == 0){ // euro
                                                                    $room->promo_price -= $promo->discount;
                                                                }else{
                                                                    $calc = $room->price - (($room->price * (100 - $promo->discount)) / 100);
                                                                    $room->promo_price -= $calc;
                                                                }
                                                            }

                                                            break;
                                                        case 1: //maggiore
                                                            if($diff_days > $promo->value_discount){
                                                                if($promo->type_discount == 0){ // euro
                                                                    $room->promo_price -= $promo->discount;
                                                                }else{
                                                                    $calc = $room->price - (($room->price * (100 - $promo->discount)) / 100);
                                                                    $room->promo_price -= $calc;
                                                                }
                                                            }
                                                            break;
                                                    }
                                                }
                                                break;
                                            case 2:


                                                switch ($promo->rule_discount){
                                                    case 0: //uguale
                                                        if($letti == $promo->value_discount){
                                                            if($promo->type_discount == 0){ // euro
                                                                $room->promo_price -= $promo->discount;
                                                            }else{
                                                                $calc = $room->price - (($room->price * (100 - $promo->discount)) / 100);
                                                                $room->promo_price -= $calc;
                                                            }
                                                        }

                                                        break;
                                                    case 1: //maggiore
                                                        if($letti > $promo->value_discount){
                                                            if($promo->type_discount == 0){ // euro
                                                                $room->promo_price -= $promo->discount;
                                                            }else{
                                                                $calc = $room->price - (($room->price * (100 - $promo->discount)) / 100);
                                                                $room->promo_price -= $calc;
                                                            }
                                                        }
                                                        break;
                                                }

                                                break;
                                        }
                                    }

                                }
                            }

                            $session->days[$day_item] = $room->price;
                            $session->days_promo[$day_item] = $room->promo_price;

                        }
                    }


                    $total_euro_rooms = 0;
                    $room->listino = "";

                    if(count($session->days)){
                        $room->listino = "<table class='table table-sm font-sm line-height-md'>";
                        foreach ($session->days as $d=>$v){

                            $total_bimbo = 0;
                            if($room->qty_bambini > 0){
                                $total_bimbo = ($letti_bimbi * $room->price_bambini) * 1;
                            }

                            $d_it = Carbon::createFromFormat("Y-m-d", $d)->format("d/m/Y");

                            $html_price = "";
                            $html_price_partecipant = "";
                            if(key_exists($d, $session->days_promo)){

                                if($v != $session->days_promo[$d] && $session->days_promo[$d] != 0){
                                    $total_euro_rooms += $session->days_promo[$d];

                                    $total_adulti = number_format($session->days_promo[$d] - $total_bimbo, 2);

                                    $html_price = '<div class="prices line-height-xs">
                                            <del class="old-price font-sm">&euro; '.number_format($v, 2, ",", ".").'</del><ins class="new-price font-lg">&euro; '.number_format($session->days_promo[$d], 2, ",", ".").'</ins><span class="unit">/ a notte</span>
                                        </div>';

                                    $html_price_partecipant = "{$labels['booking-prenota-adulti']}  $total_adulti &euro;";
                                    if($room->qty_bambini > 0 && $letti_bimbi > 0){
                                        $total_bimbo_format = number_format($total_bimbo, 2);

                                        $html_price_partecipant .= " {$labels['booking-prenota-bambini']}  $total_bimbo_format &euro;";
                                    }


                                }else{
                                    $total_euro_rooms += $v;

                                    $total_adulti = number_format($v - $total_bimbo, 2);

                                    $html_price = ' <div class="prices line-height-xs">
                                            <ins class="new-price font-lg">&euro; '.number_format($v, 2, ",", ".").'</ins><span class="unit">/ '.$labels['booking-prenota-a-notte'].'</span>
                                        </div>';

                                    $html_price_partecipant = "{$labels['booking-prenota-adulti']} $total_adulti &euro;";
                                    if($room->qty_bambini > 0 && $letti_bimbi > 0){
                                        $total_bimbo_format = number_format($total_bimbo, 2);

                                        $html_price_partecipant .= " {$labels['booking-prenota-bambini']} $total_bimbo_format &euro;";
                                    }
                                }
                            }

                            $room->listino .= "<tbody><tr><td rowspan='2' class='fw-bold'>$d_it</td><td>$html_price</td></tr><tr><td class='font-xs'>$html_price_partecipant</td></tr></tbody>";
                        }
                        $room->listino .= "</table>";
                    }



                    $room->total_euro_rooms =  $total_euro_rooms;

                    $session->listino_vet[$room->id] = $room->listino;


                }
            }

            if(\Session::has('buy')){
                $session = \Session::get('buy');
            }

            $html = \View::make("$thema.plugins.pluginBooking.inc.box_room", compact('rooms','session'))->render();
            if($html_get == 1){
                return $html;
            }
            return response()->json([
                "html" => $html,
                "session" => $session,
                "rooms" => $rooms,
                "diff_day" => $diff_day
            ]);
        } catch (\Throwable $e) {
            return false;
        }

    }

    public function get_services(Request $request)
    {
        $thema = env('TEMA');

        if(\Session::has('buy')){
            $session = \Session::get('buy');
        }

        $room_id = $request->get('id');
        $price = $request->get('price');

        $session->room_id = $room_id;
        $session->total = $price;

        $start_ = Carbon::createFromFormat("Y-m-d", $session->start);
        $diff_days = 0;
        if($session->end){
            $end_ = Carbon::createFromFormat("Y-m-d", $session->end);
            $diff_days = $end_->diffInDays($start_);
        }

        $type = PluginBookingType::where("id", $session->type)->first();

        \Session::put('buy', $session);

        $services = PluginBookingRoomServices::where("plugin_booking_room_id", $room_id)
            ->whereNull("is_free")
            ->pluck("plugin_booking_service_id", "plugin_booking_service_id")
            ->toArray();

        //if(count($services)){
            $html = \View::make("$thema.plugins.pluginBooking.inc.box_service", compact('services', 'session','diff_days'))->render();
       /* }else{
            $html = "";
        }*/

        return response()->json([
            "html" => $html,
            "step_partecipanti" => $type->is_checkin,
            "session" => $session,
            "list" => count($services)
        ]);
    }

    public function set_partecipants(Request $request){
        $thema = env('TEMA');

        if(\Session::has('buy')){
            $session = \Session::get('buy');
            $session->services = [];

            $type = PluginBookingType::where("id", $session->type)->first();

        }

        if($request->has('services')){
            $services = $request->get('services');
            $services_qty = $request->get('services_qty');
            $services_day = $request->get('services_day');

            if($services_qty == null){
                $services_qty = [];
            }

            if($services_day == null){
                $services_day = [];
            }

            if($services){
                foreach ($services as $k=>$serviceID){
                    $item_service = PluginBookingServices::find($serviceID);
                    if($item_service){
                        if(key_exists($item_service->id, $services_qty)){
                            $session->services[$item_service->id] = "{$item_service->id}|{$item_service->name}|{$item_service->price_1}|{$services_qty[$item_service->id]}";
                        }else{
                            $session->services[$item_service->id] = "{$item_service->id}|{$item_service->name}|{$item_service->price_1}|1";
                        }

                        if(key_exists($item_service->id, $services_day)){
                            $session->services_day[$item_service->id] = $services_day[$item_service->id];
                        }

                    }
                }
            }

            \Session::put('buy', $session);
        }

        $html = \View::make("$thema.plugins.pluginBooking.inc.box_partecipants", compact('session'))->render();
        return response()->json([
            "html" => $html,
            "step_partecipanti" => $type->is_checkin,
            "session" => $session
        ]);
    }


    public function get_services_2(Request $request)
    {
        $thema = env('TEMA');

        if(\Session::has('buy')){
            $session = \Session::get('buy');
        }

        if($request->has('partecipants')){
            $session->partecipants = $request->get('partecipants');
            \Session::put('buy', $session);
        }

        $start_ = Carbon::createFromFormat("Y-m-d", $session->start);
        $diff_days = 0;
        if($session->end){
            $end_ = Carbon::createFromFormat("Y-m-d", $session->end);
            $diff_days = $end_->diffInDays($start_);
        }

        $v_ids = [];
        if($session->services){
            foreach ($session->services as $service){
                $temp = explode("|", $service);
                $v_ids[] = (int) $temp[0];
            }
        }

        if(count($v_ids)){
            $services = PluginBookingRoomServices::where("plugin_booking_room_id", $session->room_id)
                ->whereRaw("(plugin_booking_service_id NOT IN (".implode("," ,$v_ids).") AND is_free IS NULL)")
                ->pluck("plugin_booking_service_id", "plugin_booking_service_id")
                ->toArray();

        }else{
            $services = PluginBookingRoomServices::where("plugin_booking_room_id", $session->room_id)
                ->whereNull("is_free")
                ->pluck("plugin_booking_service_id", "plugin_booking_service_id")
                ->toArray();
        }


        $html = \View::make("$thema.plugins.pluginBooking.inc.box_service_2", compact('services', 'session', 'diff_days'))->render();

        return response()->json([
            "html" => $html,
            "session" => $session,
            "list" => count($services)
        ]);
    }

    public function get_checkout(Request $request){
        $thema = env('TEMA');

        if(\Session::has('buy')){
            $session = \Session::get('buy');
        }

        if($request->has('services')){
            $services_2 = $request->get('services');
            $services_qty = $request->get('services_qty');
            $services_day = $request->get('services_day');

            if($services_qty == null){
                $services_qty = [];
            }

            if($services_day == null){
                $services_day = [];
            }

            if($services_2){
                foreach ($services_2 as $k=>$serviceID){
                    $item_service = PluginBookingServices::find($serviceID);
                    if($item_service){
                        if(key_exists($item_service->id, $services_qty)){
                            $session->services[$item_service->id] = "{$item_service->id}|{$item_service->name}|{$item_service->price_2}|{$services_qty[$item_service->id]}";
                        }else{
                            $session->services[$item_service->id] = "{$item_service->id}|{$item_service->name}|{$item_service->price_2}|1";
                        }

                        if(key_exists($item_service->id, $services_day)){
                            $session->services_day[$item_service->id] = $services_day[$item_service->id];
                        }

                    }
                }
            }

            /*if($services_2){
                foreach ($services_2 as $k=>$serviceID){
                    $item_service = PluginBookingServices::find($serviceID);
                    if($item_service){
                        if(key_exists($k, $services_qty)){
                            $session->services[$item_service->id] = "{$item_service->id}|{$item_service->name}|{$item_service->price_2}|{$services_qty[$k]}";
                        }else{
                            $session->services[$item_service->id] = "{$item_service->id}|{$item_service->name}|{$item_service->price_2}|1";
                        }
                    }
                }
            }*/

        }

        \Session::put('buy', $session);

        $html = \View::make("$thema.plugins.pluginBooking.inc.box_checkout", compact('session'))->render();
        return response()->json([
            "html" => $html,
            "session" => $session
        ]);

    }




    public function save_documents(Request $request){
        PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $request->get('reservation_id'))->delete();

        if($request->has('first_name')){
            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $birthdate = $request->get('birthdate');
            $email = $request->get('email');
            $mobile = $request->get('mobile');
            $carta = $request->get('carta');
            $scadenza_carta = $request->get('scadenza_carta');
            $comune = $request->get('comune');
            $documento = $request->file('file');


            foreach ($first_name as $k=>$value){
                $path = null;
                if(key_exists($k, $documento)) {
                    if ($documento[$k]) {
                        //Storage::delete('/public/avatars/'.$user->avatar);

                        // Get filename with the extension
                        $filenameWithExt = $documento[$k]->getClientOriginalName();
                        //Get just filename
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        // Get just ext
                        $extension = $documento[$k]->getClientOriginalExtension();
                        // Filename to store
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        // Upload Image
                        $path = $documento[$k]->storeAs('public/plugins_booking/documents', $fileNameToStore);
                    }
                }

                PluginBookingReservationRoomCheckin::create([
                    "plugin_booking_reservation_room_id" => $request->get('reservation_id'),
                    "first_name" => $value,
                    "last_name" => $last_name[$k],
                    "email" => $email[$k],
                    "mobile" => $mobile[$k],
                    "birthdate" => $birthdate[$k],
                    "numero_carta_identita" => $carta[$k],
                    "scadenza_carta_identita" => $scadenza_carta[$k],
                    "comune_carta_identita" => $comune[$k],
                    "document_file" => $path
                ]);
            }
        }

        return redirect()->back()
            ->with('message', "Dati caricati con successo!");
    }

    public function checkout(Request $request){
        if(!$request->has('mobile')){
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
                return response()->json([
                    "error" => 1,
                    "message" => "Account non riconosciuto!"
                ]);
            }

            $check = \DB::table('model_has_roles')->where("role_id", 5)->where("model_id", $user->id)->first();
            if(!$check){
                if($user->is_active == 0){
                    return response()->json([
                        "error" => 1,
                        "message" => "Account non attivo!"
                    ]);
                }
            }

            if (\Auth::attempt($credentials)) {
                \Session::put("user_id", $user->id);


                if(\Session::has('buy')){
                    $session = \Session::get('buy');
                }

                $type = PluginBookingType::find($session->type);

                $start_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start);
                $diff_day = 1;

                if($session->end){
                    $end_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->end);
                    $diff_day = $start_carbon->diffInDays($end_carbon);
                    if($diff_day == 0){
                        $diff_day = 1;
                    }
                }


                //$tot = $session->total * $diff_day;
                $tot = $session->total;

                if($session->services){
                    foreach($session->services as $k=>$servizio){
                        $temp = explode("|", $servizio);

                        if(property_exists($session, "services_day")){
                            if(key_exists($k, $session->services_day)){
                                $tot = $tot + (($temp[2]*$temp[3]) * $session->services_day[$k]);
                            }else{
                                $tot = $tot + ($temp[2]*$temp[3]);
                            }
                        }else{
                            $tot = $tot + ($temp[2]*$temp[3]);
                        }

                        //$tot = $tot + $temp[2];
                    }
                }

                if($session->start_time){
                    $start_time = Carbon::createFromFormat("H:i", $session->start_time);

                    if(!$session->end_time){
                        $session->end_time = $start_time->addMinutes($type->duration)->format("H:i:s");
                    }
                }

                if(!$session->end){
                    $session->end = $session->start;
                }

                $session_temp = $session;
                $session_temp->html = "";

                $reservation = PluginBookingReservation::create([
                    "date_start" => $session->start,
                    "date_end" => $session->end,
                    "start_time" => $session->start_time,
                    "end_time" => $session->end_time,
                    "total" => $tot,
                    "total_qty" => $session->qty,
                    "total_qty_bimbi" => $session->qty_bimbi,
                    "type_id" => $session->type,
                    "user_id" => $user->id,
                    "is_payed" => 0,
                    "plugin_booking_status_id" => $type->default_status_id,
                    "plugin_booking_room_id" => $session->room_id,
                    "sessione" => json_encode($session_temp)
                ]);

                if($reservation) {
                    $reservation_room = PluginBookingReservationRoom::create([
                        "plugin_booking_reservation_id" => $reservation->id,
                        "plugin_booking_room_id" => $session->room_id,
                        "price" => $session->total
                    ]);

                    if ($session->services) {
                        foreach ($session->services as $k => $servizio) {
                            $temp = explode("|", $servizio);
                            if (!key_exists(3, $temp)) {
                                $temp[3] = 1;
                            }

                            $days = 1;
                            if (property_exists($session, "services_day")) {
                                if ((key_exists($k, $session->services_day))) {
                                    $days = $session->services_day[$k];
                                }
                            }

                            PluginBookingReservationService::create([
                                "plugin_booking_reservation_id" => $reservation->id,
                                "plugin_booking_service_id" => $temp[0],
                                "name" => $temp[1],
                                "price" => $temp[2],
                                "qty" => $temp[3],
                                "days" => $days
                            ]);
                        }
                    }

                    if ($type->is_checkin) {
                        if ($session->partecipants) {
                            foreach ($session->partecipants as $partecipant) {
                                PluginBookingReservationRoomCheckin::create([
                                    "plugin_booking_reservation_room_id" => $reservation_room->id,
                                    "plugin_booking_reservation_id" => $reservation->id,
                                    "first_name" => $partecipant['first_name'],
                                    "last_name" => $partecipant['last_name'],
                                    "birthdate" => $partecipant['birthdate'],
                                    "line_code" => "1243"
                                ]);
                            }
                        }
                    }
                }


                return response()->json([
                    "error" => 0,
                    "url" => route('pluginBooking.riassume.it')
                ]);

            }else{
                return response()->json([
                    "error" => 1,
                    "message" => "Account non riconosciuto!"
                ]);
            }
        }else{
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required',
                'password' => 'required|min:3|confirmed',
                'password_confirmation' => 'required|min:3',
            ],
                [
                    "first_name.required" => "Nome campo obbligatorio",
                    "last_name.required" => "Cognome campo obbligatorio",
                    "email.required" => "Email campo obbligatorio",
                    "mobile.required" => "Telefono campo obbligatorio",
                    "password.required" => "Password campo obbligatorio",
                    "password_confirmation.required" => "Conferma Password campo obbligatorio"
                ]
            );

            $user = User::withTrashed()->where("email", $request->input('email'))->first();
            if($user){
                $user->forceDelete();

                if($user){
                    $message = "Account già esistente con l’email <strong class='font-xl'>$user->email</strong>. <br>Esegui il login o registrati usando un'email diversa";
                    return response()->json([
                        "error" => 1,
                        "message" => $message
                    ]);
                }
            }

            $first_name = trim($request->input('first_name'));
            $last_name = trim($request->input('last_name'));
            $prefix_mobile = trim($request->input('prefix_mobile'));
            if(!$prefix_mobile){
                $prefix = "+39";
            }else{
                $prefix = "+$prefix_mobile";
            }

            $mobile = trim($request->input('mobile'));
            $mobile_complete = "{$prefix}{$mobile}";

            $code = unique_random("users", "code", "25");

            $shopSetting = ShopSettings::first();

            $user = User::create([
                "name" => "$first_name $last_name",
                "email" =>  trim($request->input('email')),
                "mobile" =>  trim($mobile_complete),
                "password" =>  trim(bcrypt($request->input('password'))),
                "code" => $code,
                "check_privacy" => $request->input('check_privacy'),
                "check_newsletter" => $request->input('check_newsletter'),
                "text_privacy" => $shopSetting->text_privacy,
                "text_cookie" => $shopSetting->text_cookie,
                "date_newsletter" => $request->input('check_newsletter') ? Carbon::now()->toDateTimeString() : null,
                "active" => 0
            ]);

            $role_id = 5; //cliente;

            $role = Role::where("id", $role_id)->first();
            if(!$role){
                Role::insert([
                    "id" => $role_id,
                    "name" => "Cliente",
                    "guard_name" => "web"
                ]);
            }

            $check = \DB::table('model_has_roles')->where("role_id", $role_id)->where("model_id", $user->id)->first();
            if(!$check){
                \DB::table('model_has_roles')->insert([
                    "role_id" => $role_id,
                    "model_type" => "App\User",
                    "model_id" => $user->id
                ]);
            }


            if(\Session::has('buy')){
                $session = \Session::get('buy');
            }

            $type = PluginBookingType::find($session->type);

            $start_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start);
            $diff_day = 1;

            if($session->end){
                $end_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->end);
                $diff_day = $start_carbon->diffInDays($end_carbon);
                if($diff_day == 0){
                    $diff_day = 1;
                }
            }


            //$tot = $session->total * $diff_day;
            $tot = $session->total;

            if($session->services){
                foreach($session->services as $k=>$servizio){
                    $temp = explode("|", $servizio);

                    if(property_exists($session, "services_day")){
                        if(key_exists($k, $session->services_day)){
                            $tot = $tot + (($temp[2]*$temp[3]) * $session->services_day[$k]);
                        }else{
                            $tot = $tot + ($temp[2]*$temp[3]);
                        }
                    }else{
                        $tot = $tot + ($temp[2]*$temp[3]);
                    }

                    //$tot = $tot + $temp[2];
                }
            }

            if($session->start_time){
                $start_time = Carbon::createFromFormat("H:i", $session->start_time);

                if(!$session->end_time){
                    $session->end_time = $start_time->addMinutes($type->duration)->format("H:i:s");
                }
            }

            if(!$session->end){
                $session->end = $session->start;
            }

            $session_temp = $session;
            $session_temp->html = "";

            $reservation = PluginBookingReservation::create([
                "date_start" => $session->start,
                "date_end" => $session->end,
                "start_time" => $session->start_time,
                "end_time" => $session->end_time,
                "total" => $tot,
                "total_qty" => $session->qty,
                "total_qty_bimbi" => $session->qty_bimbi,
                "type_id" => $session->type,
                "user_id" => $user->id,
                "is_payed" => 0,
                "plugin_booking_status_id" => $type->default_status_id,
                "plugin_booking_room_id" => $session->room_id,
                "sessione" => json_encode($session_temp)
            ]);

            if($reservation) {
                $reservation_room = PluginBookingReservationRoom::create([
                    "plugin_booking_reservation_id" => $reservation->id,
                    "plugin_booking_room_id" => $session->room_id,
                    "price" => $session->total
                ]);

                if ($session->services) {
                    foreach ($session->services as $k => $servizio) {
                        $temp = explode("|", $servizio);
                        if (!key_exists(3, $temp)) {
                            $temp[3] = 1;
                        }

                        $days = 1;
                        if (property_exists($session, "services_day")) {
                            if ((key_exists($k, $session->services_day))) {
                                $days = $session->services_day[$k];
                            }
                        }

                        PluginBookingReservationService::create([
                            "plugin_booking_reservation_id" => $reservation->id,
                            "plugin_booking_service_id" => $temp[0],
                            "name" => $temp[1],
                            "price" => $temp[2],
                            "qty" => $temp[3],
                            "days" => $days
                        ]);
                    }
                }

                if ($type->is_checkin) {
                    if ($session->partecipants) {
                        foreach ($session->partecipants as $partecipant) {
                            PluginBookingReservationRoomCheckin::create([
                                "plugin_booking_reservation_room_id" => $reservation_room->id,
                                "plugin_booking_reservation_id" => $reservation->id,
                                "first_name" => $partecipant['first_name'],
                                "last_name" => $partecipant['last_name'],
                                "birthdate" => $partecipant['birthdate'],
                                "line_code" => "1243"
                            ]);
                        }
                    }
                }
            }


            $vet_email = ["code_activation" => $code, "user" => $user];
            $destinatario = $request->input('email');

            $setting = PluginBookingSettings::first();

            try{
                \Mail::send("common.emails.register_booking", ['data' => $vet_email], function ($m) use ($destinatario, $setting) {
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


                if($setting) {
                    if ($setting->ccn_registered) {
                        $emails = explode(",", $setting->ccn_registered);
                        if (count($emails)) {
                            foreach ($emails as $k => $temp_email) {
                                $destinatario = trim($temp_email);
                                \Mail::send("common.emails.register_booking_staff", ['data' => $vet_email], function ($m) use ($destinatario, $setting) {
                                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                    $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                                    $m->to($destinatario)->subject("Registrazione nuovo cliente");
                                });
                            }
                        }
                    }
                }




            } catch (\Throwable $e) {

            }

            return response()->json([
                "error" => 0,
                "url" => route('pluginBooking.register.it')
            ]);

        }
    }
    public function save_order(Request $request){
        $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();

        if(\Session::has('buy')){
            $session = \Session::get('buy');
        }else{
            return redirect()->to("/");
        }

        $setting = PluginBookingSettings::first();
        $type = PluginBookingType::find($session->type);
        $status_confermati = \App\Models\PluginBookingStatus::where("is_unblock","!=", 1)->get()->pluck("id", "id")->toArray();


        if(\Session::has("user_id")){
            $user = User::find(\Session::get("user_id"));

            /*$res_ids = PluginBookingReservationRoom::where("plugin_booking_room_id", $session->room_id)
                ->pluck("plugin_booking_reservation_id", "plugin_booking_reservation_id")
                ->toArray();*/

            //controllo prenotazione
            $check_reservation = null;

            if(property_exists($session, "reservation_id")){
                $res_ids = \App\Models\PluginBookingReservationRoom::where("plugin_booking_room_id", $session->room_id)
                    ->where("plugin_booking_reservation_id", "!=", $session->reservation_id)
                    ->pluck("plugin_booking_reservation_id", "plugin_booking_reservation_id")
                    ->toArray();
            }else{
                $res_ids = \App\Models\PluginBookingReservationRoom::where("plugin_booking_room_id", $session->room_id)
                    ->pluck("plugin_booking_reservation_id", "plugin_booking_reservation_id")
                    ->toArray();
            }


            if(count($res_ids)){
                if($session->end){
                    $sql_add = "";
                    if($session->end_time){
                        $sql_add = "AND end_time = '$session->end_time'";
                    }

                    /*$session->start = "2025-04-08";
                    $session->end = "2025-04-21";
                    dump("DAL $session->start AL $session->end");*/

                    $check_res_start = Carbon::createFromFormat("Y-m-d", $session->start)->subDay();
                    $check_res_end = Carbon::createFromFormat("Y-m-d", $session->end);
                    $check_diff = $check_res_start->diffInDays($check_res_end);


                    $prenotabile = 1;
                    for($i=0;$i<$check_diff;$i++){

                        $check_date = $check_res_start->addDay()->format("Y-m-d");
                        //dump($check_date);

                        if(count($status_confermati)) {
                            $check_r_list = \App\Models\PluginBookingReservation::whereRaw("(date_start <= '$check_date' AND date_end >= '$check_date' $sql_add)")
                                ->whereIn("id", $res_ids)
                                ->whereIn("plugin_booking_status_id", $status_confermati)
                                ->get();
                        }else {
                            $check_r_list = \App\Models\PluginBookingReservation::whereRaw("(date_start <= '$check_date' AND date_end >= '$check_date' $sql_add)")
                                ->whereIn("id", $res_ids)
                                ->get();
                        }

                        if(count($check_r_list) == 0){
                            continue;
                        }

                        foreach ($check_r_list as $check_r){
                            if($check_date == $session->end){ //se il giorno in questione è la mia data di checkout
                                //controllo se la prenotazione già avvenuta
                                if($check_r->date_start == $check_date){ //se  check-in prenotazione già avvenuta coincide con checkout
                                    $prenotabile = 1;
                                }
                            }else{
                                if($check_date == $check_r->date_end){
                                    $prenotabile = 1;
                                }else{
                                    $check_reservation = $check_r;
                                    $prenotabile = 0;
                                    break;
                                }
                            }

                            //dump($check_date, $check_r->id, "dal $check_r->date_start al $check_r->date_end", $prenotabile);
                        }

                        if($prenotabile == 0){
                            break;
                        }
                    }

                    //dd($prenotabile);

                    if($prenotabile > 0){
                        //echo "Prenotabile";
                        $check_reservation = null;
                    }
                }else{
                    $sql_add = "";
                    if($session->start_time){
                        $sql_add = "AND start_time = '$session->start_time'";
                    }

                    if(count($status_confermati)){
                        $check_reservation = \App\Models\PluginBookingReservation::whereRaw("(date_start = '$session->start' $sql_add)")
                            ->whereIn("id", $res_ids)
                            ->whereIn("plugin_booking_status_id", $status_confermati)
                            ->first();
                    }else{
                        $check_reservation = \App\Models\PluginBookingReservation::whereRaw("(date_start = '$session->start' $sql_add)")
                            ->whereIn("id", $res_ids)
                            ->first();
                    }
                }
            }

            if($check_reservation){
                $message = "Non più disponibile la scelta selezionata";
                return redirect()->back()->withErrors(["$message"]);
            }


            $start_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start);
            $diff_day = 1;

            if($session->end){
                $end_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->end);
                $diff_day = $start_carbon->diffInDays($end_carbon);
                if($diff_day == 0){
                    $diff_day = 1;
                }
            }

            if($type->id == env('ID_TIPOLOGIA_MIN_MAX_GIORNI')){
                $diff_day = 1;
            }

            //$tot = $session->total * $diff_day;
            $tot = $session->total;

            if($session->services){
                foreach($session->services as $k=>$servizio){
                    $temp = explode("|", $servizio);

                    if(property_exists($session, "services_day")){
                        if(key_exists($k, $session->services_day)){
                            $tot = $tot + (($temp[2]*$temp[3]) * $session->services_day[$k]);
                        }else{
                            $tot = $tot + ($temp[2]*$temp[3]);
                        }
                    }else{
                        $tot = $tot + ($temp[2]*$temp[3]);
                    }

                    //$tot = $tot + $temp[2];
                }
            }

            if($session->start_time){
                $start_time = Carbon::createFromFormat("H:i", $session->start_time);

                if(!$session->end_time){
                    $session->end_time = $start_time->addMinutes($type->duration)->format("H:i:s");
                }
            }

            if(!$session->end){
                $session->end = $session->start;
            }


            $tot_acconto = 0;
            if($session->end && $session->start){
                $diff = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->diffInDays(\Carbon\Carbon::createFromFormat("Y-m-d", $session->end));
                if($diff >= $setting->number_days_for_acconto && $setting->number_days_for_acconto > 0){
                    $perc = ($setting->perc_acconto / 100);
                    $tot_acconto = round($tot * $perc,2);
                }
            }

            $reservation = PluginBookingReservation::where("user_id", $user->id)
                ->where("date_start", $session->start)
                ->where("date_end", $session->end)
                ->where("plugin_booking_room_id", $session->room_id)
                ->orderBy("id", "desc")
                ->first();

            if($reservation){
                $reservation->total_acconto = $tot_acconto;
                $reservation->plugin_booking_payment_id =  $request->has('payment_id') ? $request->get('payment_id') : null;
                $reservation->business_name = $request->has('business_name') ? $request->get('business_name') : null;
                $reservation->vat =  $request->has('vat') ? $request->get('vat') : null;
                $reservation->pec =  $request->has('pec') ? $request->get('pec') : null;
                $reservation->sdi =  $request->has('sdi') ? $request->get('sdi') : null;
                $reservation->address_invoice =  $request->has('address_invoice') ? $request->get('address_invoice') : null;
                $reservation->street_invoice =  $request->has('street_invoice') ? $request->get('street_invoice') : null;
                $reservation->zip_invoice =  $request->has('zip_invoice') ? $request->get('zip_invoice') : null;
                $reservation->city_invoice =  $request->has('city_invoice') ? $request->get('city_invoice') : null;
                $reservation->province_invoice =  $request->has('province_invoice') ? $request->get('province_invoice') : null;
                $reservation->state_invoice =  $request->has('state_invoice') ? $request->get('state_invoice') : null;
                $reservation->note =  $request->has('note') ? $request->get('note') : null;
                $reservation->save();
            }else{
                $reservation = PluginBookingReservation::create([
                    "date_start" => $session->start,
                    "date_end" => $session->end,
                    "start_time" => $session->start_time,
                    "end_time" => $session->end_time,
                    "total" => $tot,
                    "total_acconto" => $tot_acconto,
                    "total_qty" => $session->qty,
                    "total_qty_bimbi" => $session->qty_bimbi,
                    "type_id" => $session->type,
                    "user_id" => $user->id,
                    "is_payed" => 0,
                    "plugin_booking_status_id" => $type->default_status_id,
                    "plugin_booking_room_id" => $session->room_id,
                    "plugin_booking_payment_id" => $request->has('payment_id') ? $request->get('payment_id') : null,
                    "business_name" => $request->has('business_name') ? $request->get('business_name') : null,
                    "vat" => $request->has('vat') ? $request->get('vat') : null,
                    "pec" => $request->has('pec') ? $request->get('pec') : null,
                    "sdi" => $request->has('sdi') ? $request->get('sdi') : null,
                    "address_invoice" => $request->has('address_invoice') ? $request->get('address_invoice') : null,
                    "street_invoice" => $request->has('sdi') ? $request->get('street_invoice') : null,
                    "zip_invoice" => $request->has('zip_invoice') ? $request->get('zip_invoice') : null,
                    "city_invoice" => $request->has('city_invoice') ? $request->get('city_invoice') : null,
                    "province_invoice" => $request->has('province_invoice') ? $request->get('province_invoice') : null,
                    "state_invoice" => $request->has('state_invoice') ? $request->get('state_invoice') : null,
                    "note" => $request->has('note') ? $request->get('note') : null
                ]);
            }

            User::where("id", $user->id)->update([
                "business_name" => $request->has('business_name') ? $request->get('business_name') : null,
                "vat" => $request->has('vat') ? $request->get('vat') : null,
                "pec" => $request->has('pec') ? $request->get('pec') : null,
                "sdi" => $request->has('sdi') ? $request->get('sdi') : null,
                "address_invoice" => $request->has('address_invoice') ? $request->get('address_invoice') : null,
                "street_invoice" => $request->has('sdi') ? $request->get('street_invoice') : null,
                "zip_invoice" => $request->has('zip_invoice') ? $request->get('zip_invoice') : null,
                "city_invoice" => $request->has('city_invoice') ? $request->get('city_invoice') : null,
                "province_invoice" => $request->has('province_invoice') ? $request->get('province_invoice') : null,
                "state_invoice" => $request->has('state_invoice') ? $request->get('state_invoice') : null
            ]);

            if($reservation){
                $reservation_room = PluginBookingReservationRoom::where("plugin_booking_reservation_id", $reservation->id)
                    ->where("plugin_booking_room_id", $session->room_id)->first();

                if(!$reservation_room){
                    $reservation_room = PluginBookingReservationRoom::create([
                        "plugin_booking_reservation_id" => $reservation->id,
                        "plugin_booking_room_id" => $session->room_id,
                        "price" => $session->total
                    ]);
                }else{
                    $reservation_room->price = $session->total;
                    $reservation_room->save();
                }


                if($session->services){
                    foreach ($session->services as $k=>$servizio){
                        $temp = explode("|", $servizio);
                        if(!key_exists(3, $temp)){
                            $temp[3] = 1;
                        }

                        $days = 1;
                        if(property_exists($session, "services_day")){
                            if((key_exists($k, $session->services_day))){
                                $days = $session->services_day[$k];
                            }
                        }

                        $check1 = PluginBookingReservationService::where("plugin_booking_reservation_id", $reservation->id)
                            ->where("plugin_booking_service_id", $temp[0])->first();

                        if(!$check1){
                            PluginBookingReservationService::create([
                                "plugin_booking_reservation_id" => $reservation->id,
                                "plugin_booking_service_id" => $temp[0],
                                "name" => $temp[1],
                                "price" => $temp[2],
                                "qty" => $temp[3],
                                "days" => $days
                            ]);
                        }

                    }
                }

                if($type->is_checkin){
                    if($session->partecipants){
                        foreach ($session->partecipants as $partecipant){

                            $check1 = PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $reservation_room->id)
                                ->where("first_name", $partecipant['first_name'])
                                ->where("last_name", $partecipant['last_name'])
                                ->first();

                            if(!$check1){
                                PluginBookingReservationRoomCheckin::create([
                                    "plugin_booking_reservation_room_id" => $reservation_room->id,
                                    "plugin_booking_reservation_id" => $reservation->id,
                                    "first_name" => $partecipant['first_name'],
                                    "last_name" => $partecipant['last_name'],
                                    "birthdate" => $partecipant['birthdate'],
                                    "line_code" => "1586"
                                ]);
                            }

                        }
                    }
                }

                \Session::forget('buy');

                if($type->is_addiction == 1){
                    $addictions = PluginBookingRoomAddictions::where("plugin_booking_room_id", $session->room_id)->get();
                    if($addictions){
                        foreach ($addictions as $addict){
                            $room_temp = PluginBookingRoom::find($addict->room_id);


                            $reservation_temp = PluginBookingReservation::create([
                                "date_start" => $session->start,
                                "date_end" => $session->end,
                                "start_time" => $session->start_time,
                                "end_time" => $session->end_time,
                                "total" => $tot,
                                "total_acconto" => $tot_acconto,
                                "total_qty" => $session->qty,
                                "total_qty_bimbi" => $session->qty_bimbi,
                                "type_id" => $room_temp->plugin_booking_type_id,
                                "user_id" => $user->id,
                                "is_payed" => 0,
                                "plugin_booking_status_id" => $type->default_status_id,
                                "plugin_booking_room_id" => $addict->room_id,
                                "plugin_booking_payment_id" => $request->has('payment_id') ? $request->get('payment_id') : null,
                                "parent_id" => $reservation->id,
                                "is_hidden" => 1
                            ]);

                            if($reservation_temp) {
                                $reservation_room = PluginBookingReservationRoom::create([
                                    "plugin_booking_reservation_id" => $reservation_temp->id,
                                    "plugin_booking_room_id" => $reservation_temp->plugin_booking_room_id,
                                    "price" => $session->total
                                ]);

                                if ($session->services) {
                                    foreach ($session->services as $k=>$servizio) {
                                        $temp = explode("|", $servizio);
                                        if (!key_exists(3, $temp)) {
                                            $temp[3] = 1;
                                        }

                                        PluginBookingReservationService::create([
                                            "plugin_booking_reservation_id" => $reservation_temp->id,
                                            "plugin_booking_service_id" => $temp[0],
                                            "name" => $temp[1],
                                            "price" => $temp[2],
                                            "qty" => $temp[3],
                                            "days" => (key_exists($k, $session->services_day)) ? $session->services_day[$k] : 1
                                        ]);
                                    }
                                }

                                if ($type->is_checkin) {
                                    if ($session->partecipants) {
                                        foreach ($session->partecipants as $partecipant) {
                                            PluginBookingReservationRoomCheckin::create([
                                                "plugin_booking_reservation_room_id" => $reservation_room->id,
                                                "plugin_booking_reservation_id" => $reservation_temp->id,
                                                "first_name" => $partecipant['first_name'],
                                                "last_name" => $partecipant['last_name'],
                                                "birthdate" => $partecipant['birthdate'],
                                                "line_code" => "1656"
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $user = User::find($reservation->user_id);

                $vet_email = ["user" => $user, "reservation" => $reservation];
                $destinatario = $user->email;

                try{
                    \Mail::send("common.emails.pluginBooking.riepilogo", ['data' => $vet_email], function ($m) use ($destinatario, $user, $setting, $labels) {
                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                        $m->to($destinatario)->subject(@$labels['booking-email-oggetto']);
                    });

                    if($setting) {
                        if ($setting->ccn_ordered) {
                            $emails = explode(",", $setting->ccn_ordered);
                            if (count($emails)) {
                                foreach ($emails as $k => $temp_email) {
                                    $destinatario = trim($temp_email);
                                    $vet_email = ["user" => $user, "reservation" => $reservation];
                                    \Mail::send("common.emails.pluginBooking.riepilogo_staff", ['data' => $vet_email], function ($m) use ($destinatario, $user, $setting) {
                                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                        $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                                        $m->to($destinatario)->subject("Nuova richiesta di prenotazione");
                                    });
                                }
                            }
                        }
                    }
                } catch (\Throwable $e) {

                }

                return redirect()->route('pluginBooking.order.it', $reservation->id);
            }
        }
    }

    public function activate($code, Request $request){

        $user = User::where("code", $code)->first();
        if($user){
            $user->active = 1;
            $user->save();

            \Auth::loginUsingId($user->id);
            \Session::put("user_id", $user->id);

            return redirect()->route('pluginBooking.riassume.it');
        }

        return redirect()->route('login');
    }

    public function not_found(){

    }

}
